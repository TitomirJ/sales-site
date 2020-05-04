<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\Order;
use App\Usetting;
use App\Marketplace;
use App\Product;
use App\Transaction;
use App\Functions\StaticFunctions as SF;
use App\Functions\RozetkaApi;
use App\Functions\PromApi;
use App\SearchModels\OrderSearch\OrderSearch;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderOrderController extends Controller
{

    //трейт для смены настроек пользователя
    private function usettingTrait($user){
        $usettings = Usetting::firstOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_2' => 10
            ]
        );
        return $usettings;
    }

    // страница заказов пользователя с фильтром
    public function index(Request $request){
        $user = Auth::user();
        $usettings = self::usettingTrait($user);
        $pagination = $usettings->n_par_2;

        $marketplaces = Marketplace::all();
        $company_id = $user->company_id;
        $company = Company::find($company_id);

        $orders = Order::where('company_id', $company_id)->orderBy('created_at', 'desc')->get();
        $orders_count = $orders->count();
        $orders->load('product');
        $orders = $this->paginateCompanyOrderIndex($orders, $pagination);
        return view('provider.company.order.index.index', compact('orders', 'orders_count', 'marketplaces', 'pagination', 'company'))->withTitle('Заказы');
    }
    public function paginateCompanyOrderIndex($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('company/filter/orders')]);
    }

    //фильтр для страницы заказов пользователя
    public function companyOrderIndexFilter(Request $request){
        if($request->ajax()){
            $user = Auth::user();
            $usettings = self::usettingTrait($user);
            $pagination = (isset($request->p_ord_index))? $request->p_ord_index : $usettings->n_par_2;
            if(isset($request->p_ord_index)){
                self::chengeUserPagination($usettings, $request->p_ord_index);
            }

            $company_id = $user->company_id;
            $company = Company::find($company_id);
            $default_queries = [['where', 'company_id', '=', $company_id]];

            $query_request = $request->only('order_id_equally', 'marketplace_id_equally', 'status_equally', 'order_dpk_interval_create', 'name_like_percent', 'total_sum_equally', 'customer_name_like_percent', 'customer_email_like_percent', 'customer_phone_like_percent');

            $loads  = ['product', 'marketplace'];
            $collection_orders  = OrderSearch::apply($query_request, $loads, $default_queries, false);
            $count_orders = $collection_orders->count();
            $orders = $this->paginateCompanyOrderIndexFilter($collection_orders,  $pagination)->appends($query_request);

            $data['render'] = view('provider.company.order.index.layouts.ordersItems', compact('orders', 'company'))->render();
            $data['countOrders'] = $count_orders;

            return json_encode($data);
        }else{
            abort('404');
        }
    }
    public function paginateCompanyOrderIndexFilter($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('company/filter/orders')]);
    }
    //смена настроек пагинации страницы заказов пользователя
    private function chengeUserPagination($usetting, $pagination){
        if($usetting->n_par_2 != $pagination){
            $chenge_usetting = Usetting::find($usetting->id);
            $chenge_usetting->n_par_2 = $pagination;
            $chenge_usetting->save();
        }
    }

    //страница заказов пользователя по товару
    public function searchOrdersFromProduct(Request $request, $id){

        $user = Auth::user();
        $product_id = $id;
        $check_product = Product::withTrashed()->find($product_id);

        if($check_product->company_id != $user->company_id){
            return back()->with('warning', 'В доступе отказано!');
        }

        $usettings = $usettings = self::usettingTrait($user);

        $pagination = $usettings->n_par_2;

        $data = [];

        $marketplaces = Marketplace::all();
        $company_id = $user->company_id;
        $company = Company::find($company_id);

        $status_delimiter = '<>';
        $status_order = '5';

        $market_delimiter = '<>';
        $market_order = '3';

        $base_from = '2018-07-12 12:10:03';
        $base_to = date('Y-m-d' . ' 23:59:59', time());

        if($request->ajax()){
            if($request->status != 'all'){
                $status_delimiter = '=';
                $status_order = $request->status;
            }

            if($request->market != 'all'){
                $market_delimiter = '=';
                $market_order = $request->market;
            }

            if($request->dates != ''){
                $date_array = explode(' - ', $request->dates);
                $base_from = date('Y-m-d' . ' 00:00:00', strtotime($date_array[0]));
                $base_to = date('Y-m-d' . ' 23:59:59', strtotime($date_array[1]));
            }
            if($request->type != $pagination){
                $setting = Usetting::find($user->usetting->id);
                $setting->n_par_2 = $request->type;
                $setting->save();

                $pagination = $setting->n_par_2;
            }

            $orders = Order::where('company_id', $company_id)->where('product_id', $product_id)->where('marketplace_id', $market_delimiter, $market_order)->where('status', $status_delimiter, $status_order)->whereBetween('created_at', [$base_from, $base_to])->paginate($pagination);
            $orders->load('product');
            $data['render'] = view('provider.company.order.layouts.ordersItems', compact('orders', 'company'))->render();
            return json_encode($data);
        }


        $orders = Order::where('company_id', $company_id)->where('product_id', $product_id)->paginate($pagination);
        $orders_count = $orders->count();
        $orders->load('product');
        return view('provider.company.order.searchOrderFromProduct', compact('orders', 'orders_count', 'marketplaces', 'pagination', 'company', 'check_product'))->withTitle('Заказы');
    }

    // действия над заказами (общий трейт) в разработке!!
    public function ordersActions(Request $request, $id, $action){
        if($request->ajax()){
            if($action == 'edit_order_info'){
                return self::actionShowModalEditOrderInfo($id);
            }elseif($action == 'update_order_info'){

            }else{
                abort('404');
            }
        }else{
            abort('404');
        }
    }
    // в разработке!!
    private function actionShowModalEditOrderInfo($id){
        $order = Order::find($id);
        $data['render'] = view('provider.company.order.layouts.editOrderInfoContentModal', compact('order'))->render();
        return json_encode($data);
    }
    // в разработке!!
//    private function actionUpdateOrderInfo($id){
//        $order = Order::find($id);
//        $data['render'] = view('provider.company.order.layouts.editOrderInfoContentModal', compact('order'))->render();
//        return json_encode($data);
//    }






    /* Старые методы смены статусов заказов, можно удалить!! */
    // смена статуса заказа пользователем
    public function changeStatusOrder(Request $request, $id){
        $data = [];
        $order = Order::find($id);

        if(Auth::user()->company_id != $order->company_id){
            $data['status'] = 'error';
            return json_encode($data);
        }

        if($request->ajax()){
            return self::changeStatusOrderAjax($order, $request);
        }else{
            return back()->with('success', 'ТТН номер изменен!');
        }
    }
    private  function changeStatusOrderAjax($order, $request){
        $data = [];

        if($order->status == '1'){
            $data['status'] = 'nochange';
            $data['action'] = '1';
            return json_encode($data);
        }elseif($order->status == '2'){
            $data['status'] = 'nochange';
            $data['action'] = '2';
            return json_encode($data);
        }//Запрет на изменение статуса заказа при отмененном и выполненом заказе

        $action = $request->action;

        if($action == '1'){//Вывод окна подтверждения выполненого заказа

            $data['status'] = 'showModalForm2';
            $data['render'] = view('provider.company.order.layouts.successStatusForm', compact('order'))->render();
            return json_encode($data);
        }elseif($action == '2'){//Вывод формы отмены заказа, зависит от вида Маркетплейса

            $market_id = $order->marketplace_id;
            $data['status'] = 'showModalForm3';
            $data['render'] = view('provider.company.order.layouts.cancelStatusForm', compact('order', 'market_id'))->render();
            return json_encode($data);
        }elseif($action == '4'){//Изменение на статус "Проверено"
            self::changeStatusConfirmToMarketplace($order);
            $order->status = '4';
        }elseif($action == '3'){//измененние на статус "Отправлено", если метод доставки - Новая почта, вызывает модальное окно с вводом ТТН Новой почты

            $array_del_mathods = ['Нова пошта', 'Новая Почта', 'Нова Пошта', 'Новая почта'];
            if (in_array($order->delivery_method, $array_del_mathods)){
                $data['status'] = 'showModalForm';
                $data['render'] = view('provider.company.order.layouts.ttnOrderForm', compact('order' ))->render();
                return json_encode($data);
            }else{
                $order->status = '3';
                //смена статуса на оправлено на маркет плейсах без указания ТТН Новой почты
                self::changeStatusDeliveryToMarketplaceWithOutTTN($order);
            }
        }elseif($action == '5'){//Получение ТТН Новой почты

            $ttn = $request->number;
            self::changeStatusDeliveryToMarketplaceWithTTN($order, $ttn);//отправка ттн Новой почты на маркеты

            $order->status = '3';
            $order->ttn = $request->number;
            $data['action'] = 'del';
        }elseif($action == '6'){//подтверждение заказа

            SF::recalculationBalanceCompany($order->company_id);//перерасчет баланса
            self::changeStatusSuccessToMarketplace($order);
            $order->status = '1';
            $data['action'] = 'confirm';
        }elseif($action == '7'){//отмена заказа от Прома


            self::changeTypeTrasactionAfterChangeStatusOrder($order->id);
            SF::recalculationBalanceCompany($order->company_id);//перерасчет баланса

            $type_cancel = $request->cancellation_reason;
            $text_cancel = (isset($request->cancellation_text)) ? $request->cancellation_text : '';
            self::changeStatusCancelToMarketplace($order, $type_cancel, $text_cancel);

            $status_data_json = self::createStatusDataCancelOrder($order, $type_cancel, $text_cancel);

            $order->status_data = $status_data_json;
            $order->status = '2';
            $data['action'] = 'cancel';
        }elseif($action == '8'){//отмена заказа от Розетки

            self::changeTypeTrasactionAfterChangeStatusOrder($order->id);
            SF::recalculationBalanceCompany($order->company_id);//перерасчет баланса

            $type_cancel = $request->cancellation_reason;
            $text_cancel = (isset($request->cancellation_text)) ? $request->cancellation_text : '';
            self::changeStatusCancelToMarketplace($order, $type_cancel, $text_cancel);

            $status_data_json = self::createStatusDataCancelOrder($order, $type_cancel, $text_cancel);

            $order->status_data = $status_data_json;
            $order->status = '2';
            $data['action'] = 'cancel';
        }else{
            $data['status'] = 'error';
            return json_encode($data);
        }

        $order->save();
        $data['status'] = 'success';
        $data['render'] = view('provider.company.order.layouts.dropdownStatusButton', compact('order'))->render();//Возвращает изменненую кнопку смены статуса Ajax

        return json_encode($data);
    }
    // формирование и запись в базу данных причину и описание отказа от заказа
    private function createStatusDataCancelOrder($order, $type, $text){
        $array_rozet_zakup = [
                18 => 'Не удалось связаться с покупателем',
                7 => 'Не обработан продавцом',
                10 => 'Отправка просрочена',
                11 => 'Не забрал посылку',
                12 => 'Отказался от товара',
                13 => 'Отменен Администратором',
                15 => 'Некорректный ТТН',
                16 => 'Нет в наличии/брак',
                17 => 'Отмена. Не устраивает оплата',
                19 => 'Возврат',
                20 => 'Отмена. Не устраивает товар',
                24 => 'Отмена. Не устраивает доставка',
                27 => 'Отмена. Требует доукомплектации',
                28 => 'Некорректные контактные данные',
                29 => 'Отмена. Некорректная цена на сайте',
                30 => 'Истек срок резерва',
                31 => 'Отмена. Заказ восстановлен',
                32 => 'Отмена. Не устраивает разгруппировка заказа',
                33 => 'Отмена. Не устраивает стоимость доставки',
                34 => 'Отмена. Не устраивает перевозчик, способ доставки',
                35 => 'Отмена. Не устраивают сроки доставки',
                36 => 'Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности',
                37 => 'Отмена. Не устраивает предоплата',
                38 => 'Отмена. Не устраивает качество товара',
                39 => 'Отмена. Не подошли характеристики товара (цвет,размер)',
                40 => 'Отмена. Клиент передумал',
                41 => 'Отмена. Купил на другом сайте',
                42 => 'Нет в наличии',
                43 => 'Брак',
                44 => 'Отмена. Фейковый заказ',
            ];
        $array_prom = [
                "not_available" => 'Нет в наличии',
                "price_changed" => 'Цена была изменена',
                "buyers_request" => 'Покупатель отказался',
                "not_enough_fields" => 'Недостаточно данных',
                "duplicate" => 'Дубликат заказа',
                "invalid_phone_number" => 'Неправильный телефон заказчика',
                "less_than_minimal_price" => 'Цена меньше указаной',
                "another" => 'Другое'
        ];

        $market_id = $order->marketplace_id;

        $cancel_type = 'Причина отмены не указана!';
        $cancel_text = 'Описание причины отказа не указана!';
        if($market_id == 2){
            if(array_key_exists($type, $array_prom)){
                $cancel_type = $array_prom[$type];
                if($text != '' && $text != null){
                    $cancel_text = $text;
                }
            }
        }elseif($market_id == 1 || $market_id == 6){
            if(array_key_exists($type, $array_rozet_zakup)){
                $cancel_type = $array_rozet_zakup[$type];
                if($text != '' && $text != null){
                    $cancel_text = $text;
                }
            }
        }

        $data = ['type' => $cancel_type, 'text' => $cancel_text];

        return json_encode($data);
    }
    // изменение транзакции при отмене заказа
    private function changeTypeTrasactionAfterChangeStatusOrder($order_id){
        Transaction::where('order_id', $order_id)->update(['type_transaction' => '2']);
    }
    //отправка на маркеты подтверждение принятого заказа
    private function changeStatusConfirmToMarketplace($order){
        if ($order->marketplace_id == '1'){// Розетка

            $text = 'Заказ принят в разработку';
            RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

        }elseif($order->marketplace_id == '2'){
            PromApi::postOrderConfirm($order);
        }
    }
    //отправка на маркеты подтверждение выполненого заказа
    private function changeStatusSuccessToMarketplace($order){
        if($order->marketplace_id == '2'){// Пром
            $data = [
                'market_place_id' => $order->marketplace_id,
                'market_id' => $order->market_id,
                'status' => '1'
            ];
            $client = new \GuzzleHttp\Client();

            $client->post(
                'https://smart-plus.herokuapp.com/market-place/update-status',
                [
                    \GuzzleHttp\RequestOptions::JSON => $data
                ],
                ['Content-Type' => 'application/json']
            );
        }elseif ($order->marketplace_id == '1'){// Розетка

            $text = 'Посылка получена';
            RozetkaApi::putOrderStatus($order->order_market_id, 6, $text);

        }
    }
    //отправка на маркеты подтверждение отправленного заказа Новой Почтой с ТТН
    private function changeStatusDeliveryToMarketplaceWithTTN($order, $ttn){
        if ($order->marketplace_id == '1'){// Розетка
            $text1 = 'Заказ подоготовлен к отправке';
            RozetkaApi::putOrderStatus($order->order_market_id, 2, $text1);
            $text = 'ТТН: '.$ttn;
            RozetkaApi::putOrderStatus($order->order_market_id, 3, $text, $ttn);

        }
    }
    //отправка на маркеты подтверждение отправленного заказа Новой Почтой с ТТН
    private function changeStatusDeliveryToMarketplaceWithOutTTN($order){
        if ($order->marketplace_id == '1'){// Розетка
            $text1 = 'Заказ подоготовлен к отправке';
            RozetkaApi::putOrderStatus($order->order_market_id, 2, $text1);

            $text2 = 'Заказ отправлен';
            RozetkaApi::putOrderStatus($order->order_market_id, 4, $text2);
        }
    }
    //отправка на маркеты отмена заказа
    private function changeStatusCancelToMarketplace($order, $type, $text){
        if($order->marketplace_id == '2'){// Пром
            $cancel_reason = $type;
            $cancel_text = '';
            if($cancel_reason == 'price_changed' || $cancel_reason == 'not_enough_fields' || $cancel_reason == 'another') {
                $cancel_text = $text;
            }
            $data = [
                'market_place_id' => $order->marketplace_id,
                'market_id' => $order->market_id,
                'status' => '2',
                'cancellation_reason' => $cancel_reason,
                'cancellation_text' => $cancel_text
            ];
            $client = new \GuzzleHttp\Client();

            $client->post(
                'https://smart-plus.herokuapp.com/market-place/update-status',
                [
                    \GuzzleHttp\RequestOptions::JSON => $data
                ],
                ['Content-Type' => 'application/json']
            );
        }elseif ($order->marketplace_id == '1'){// Розетка

            RozetkaApi::putOrderStatus($order->order_market_id, $type, $text);

        }
    }
    /* Старые методы смены статусов заказов, можно удалить!! */

}

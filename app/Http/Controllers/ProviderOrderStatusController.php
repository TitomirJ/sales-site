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

class ProviderOrderStatusController extends Controller
{
    private $rozetka_status_orders = [
        1 => ['Новый заказ'],
        2 => ['Данные подтверждены. Ожидает отправки'],
        3 => ['Передан в службу доставки'],
        4 => ['Доставляется'],
        5 => ['Ожидает в пункте самовывоза'],
        6 => ['Посылка получена'],
        7 => ['Не обработан продавцом'],
        10 => ['Отправка просрочена'],
        11 => ['Не забрал посылку'],
        12 => ['Отказался от товара'],
        13 => ['Отменен Администратором'],
        15 => ['Некорректный ТТН'],
        16 => ['Нет в наличии/брак'],
        17 => ['Отмена. Не устраивает оплата'],
        18 => ['Не удалось связаться с покупателем'],
        19 => ['Возврат'],
        20 => ['Отмена. Не устраивает товар'],
        24 => ['Отмена. Не устраивает доставка'],
        25 => ['Тестовый заказ'],
        26 => ['Обрабатывается менеджером'],
        27 => ['Требует доукомплектации'],
        28 => ['Некорректные контактные данные'],
        29 => ['Отмена. Некорректная цена на сайте'],
        30 => ['Истек срок резерва'],
        31 => ['Отмена. Заказ восстановлен'],
        32 => ['Отмена. Не устраивает разгруппировка заказа'],
        33 => ['Отмена. Не устраивает стоимость доставки'],
        34 => ['Отмена. Не устраивает перевозчик, способ доставки'],
        35 => ['Отмена. Не устраивают сроки доставки'],
        36 => ['Отмена. Клиент хочет оплату по безналу. У продавца нет такой возможности'],
        37 => ['Отмена. Не устраивает предоплата'],
        38 => ['Отмена. Не устраивает качество товара'],
        39 => ['Отмена. Не подошли характеристики товара (цвет,размер)'],
        40 => ['Отмена. Клиент передумал'],
        41 => ['Отмена. Купил на другом сайте'],
        42 => ['Нет в наличии'],
        43 => ['Брак'],
        44 => ['Отмена. Фейковый заказ'],
        45 => ['Отменен покупателем'],
        46 => ['Восстановлен при прозвоне'],
        47 => ['Обрабатывается менеджером (не удалось связаться 1-ый раз)'],
        48 => ['Обрабатывается менеджером (не удалось связаться 2-ой раз)']
    ];

    private $prom_status_orders = [
        "not_available" => ['Нет в наличии'],
        "price_changed" => ['Цена была изменена'],
        "buyers_request" => ['Покупатель отказался'],
        "not_enough_fields" => ['Недостаточно данных'],
        "duplicate" => ['Дубликат заказа'],
        "invalid_phone_number" => ['Неправильный телефон заказчика'],
        "less_than_minimal_price" => ['Цена меньше указаной'],
        "another" => ['Другое']
    ];

    // точка входа всех запросов по сменен статуса заказа
    public function changeStatusOrder(Request $request, $id){
        if($request->ajax()){
            $order = Order::find($id);
            if(self::checkOrderCompany($order)){
                $result = self::routeActions($request, $order);
                return $result;
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            abort('404');
        }
    }

    // проверка принадлежности заказа к компании пользователя
    private function checkOrderCompany($order){
        $order_company_id = $order->company_id;
        $user_company_id = Auth::user()->company_id;
        if($order_company_id == $user_company_id){
            return true;
        }else{
            return false;
        }
    }

    // маршрутизатор экшенов
    private function routeActions(Request $request, $order){
        if(isset($request->action)){
            $action = $request->action;
            $actionsArray = ['newToConfirm','newToSend','newToReceived','newToCanceled','sendToReceived','sendToCanceled','confirmToSend','confirmToReceived','confirmToCanceled'];
            if (in_array($action, $actionsArray)){
                return self::$action($request, $order);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Недопустимый статус!'
                ]);
            }
        }else{
            return json_encode([
                'status' => 'error',
                'msg' => 'Не указан статус!'
            ]);
        }
    }

    /*Группа роутов для смены статусов*/

    // с нового на проверен (!READY)
    private function newToConfirm(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $text = 'Заказ принят в разработку.';
                    $response = RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

                    if($response->success){
                        $data = self::confirmOrderTrait($order);
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }
                }elseif($market_id == '2'){

                    $response = PromApi::postOrderConfirm($order);

                    if(array_key_exists('processed_ids', $response)){
                        $data = self::confirmOrderTrait($order);
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $data = self::confirmOrderTrait($order);
                }

                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalConfirm($request, $order);
            return $result;
        }
    }

    // с нового на отправлен (!READY)
    private function newToSend(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $text = 'Заказ принят в разработку.';
                    RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

                    $text = 'Данные заказа подтверждены. Заказ сформирован и ожидает отправки.';
                    $response = RozetkaApi::putOrderStatus($order->order_market_id, 2, $text);

                    $order->status = '3';
                    $order->delivery_method = $request->delivery_method;

                    $message = '';
                    if($request->delivery_method == 'Новая почта'){
                        $ttn = str_replace(' ', '', $request->ttn);
                        $text = 'ТТН: '.$ttn;
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, 3, $text, $ttn);

                        $order->ttn = $ttn;

                        $message = 'Заказ №'.$order->id.' отправлен Новой Почтой!<br>ТТН: '.$ttn;
                    }elseif($request->delivery_method == 'Курьером'){
                        $text = 'Заказ отправлен курьером';
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, 4, $text);
                        $message = 'Заказ №'.$order->id.' отправлен курьером!';
                    }elseif($request->delivery_method == 'Самовывоз'){
                        $message = 'Заказ №'.$order->id.' подготовлен!';
                    }

                    if($response->success){
                        $order->save();
                        $data = [
                            'status' => 'success',
                            'msg' => $message,
                            'orderId' => $order->id,
                            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                        ];
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }

                }elseif($market_id == '2'){
                    $response = PromApi::postOrderDelivery($order);

                    if(array_key_exists('processed_ids', $response)){

                        $order->status = '3';
                        $order->ttn = isset($request->ttn) ? str_replace(' ', '', $request->ttn) : '';
                        $order->delivery_method = $request->delivery_method;
                        $order->save();

                        $data = [
                            'status' => 'success',
                            'msg' => 'Заказ №'.$order->id.' отправлен!',
                            'orderId' => $order->id,
                            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                        ];
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $order->status = '3';
                    $order->ttn = isset($request->ttn) ? $request->ttn : '';
                    $order->delivery_method = $request->delivery_method;
                    $order->save();

                    $data = [
                        'status' => 'success',
                        'msg' => 'Заказ №'.$order->id.' отправлен!',
                        'orderId' => $order->id,
                        'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                    ];
                }
                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalSend($request, $order);
            return $result;
        }
    }

    // с нового на выполнен (!READY)
    private function newToReceived(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $text = 'Заказ принят в разработку.';
                    RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

                    $text = 'Данные заказа подтверждены. Заказ сформирован и ожидает отправки.';
                    RozetkaApi::putOrderStatus($order->order_market_id, 2, $text);

                    $text = 'Заказ успешно доставлен покупателю.';
                    $response = RozetkaApi::putOrderStatus($order->order_market_id, 6, $text);

                    if($response->success){
                        $data = self::receivedOrderTrait($order);
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }

                }elseif($market_id == '2'){

                    $response = PromApi::postOrderReceived($order);

                    if(array_key_exists('processed_ids', $response)){

                        $data = self::receivedOrderTrait($order);
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $data = self::receivedOrderTrait($order);
                }
                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalReceived($request, $order);
            return $result;
        }
    }

    // с нового на отменен (!READY)
    private function newToCanceled(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;
                $cancel_type = $request->cancel_type;
                $cancel_text = $request->cancel_text;

                if($market_id == '1'){

                    $get_market_order = RozetkaApi::getDataOrder($order->order_market_id);
                    $market_order_status = $get_market_order->content->status;

                    if($market_order_status == 1){// если заказ новый

                        $text = 'Заказ принят в разработку.';
                        RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

                        $response = RozetkaApi::putOrderStatus($order->order_market_id, $cancel_type, $cancel_text);

                        if($response->success){

                            $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                            ];
                        }

                    }elseif($market_order_status == 45){//если заказ отменен покупателем

                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Обновите страницу и попробуйте снова, данные не актуальны!'
                        ];
                    }

                }elseif($market_id == '2'){

                    $response = PromApi::postOrderCanceled($order, $cancel_type, $cancel_text);

                    if(array_key_exists('processed_ids', $response)){

                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);

                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }

                }else{

                    $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                }

                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalCanceled($request, $order);
            return $result;
        }
    }

    // с провереного на отправлен (!READY)
    private function confirmToSend(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $text = 'Данные заказа подтверждены. Заказ сформирован и ожидает отправки.';
                    $response = RozetkaApi::putOrderStatus($order->order_market_id, 2, $text);

                    $order->status = '3';
                    $order->delivery_method = $request->delivery_method;

                    $message = '';
                    if($request->delivery_method == 'Новая почта'){
                        $ttn = str_replace(' ', '', $request->ttn);
                        $text = 'ТТН: '.$ttn;
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, 3, $text, $ttn);

                        $order->ttn = $ttn;

                        $message = 'Заказ №'.$order->id.' отправлен Новой Почтой!<br>ТТН: '.$ttn;
                    }elseif($request->delivery_method == 'Курьером'){
                        $text = 'Заказ отправлен курьером';
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, 4, $text);
                        $message = 'Заказ №'.$order->id.' отправлен курьером!';
                    }elseif($request->delivery_method == 'Самовывоз'){
                        $message = 'Заказ №'.$order->id.' подготовлен!';
                    }

                    if($response->success){
                        $order->save();
                        $data = [
                            'status' => 'success',
                            'msg' => $message,
                            'orderId' => $order->id,
                            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                        ];
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }

                }elseif($market_id == '2'){
                    $response = PromApi::postOrderDelivery($order);

                    if(array_key_exists('processed_ids', $response)){

                        $order->status = '3';
                        $order->ttn = isset($request->ttn) ? str_replace(' ', '', $request->ttn) : '';
                        $order->delivery_method = $request->delivery_method;
                        $order->save();

                        $data = [
                            'status' => 'success',
                            'msg' => 'Заказ №'.$order->id.' отправлен!',
                            'orderId' => $order->id,
                            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                        ];
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $order->status = '3';
                    $order->ttn = isset($request->ttn) ? $request->ttn : '';
                    $order->delivery_method = $request->delivery_method;
                    $order->save();

                    $data = [
                        'status' => 'success',
                        'msg' => 'Заказ №'.$order->id.' отправлен!',
                        'orderId' => $order->id,
                        'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
                    ];
                }
                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalSend($request, $order);
            return $result;
        }
    }

    // с провереного на выполнен (!READY)
    private function confirmToReceived(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $text = 'Данные заказа подтверждены. Заказ сформирован и ожидает отправки.';
                    RozetkaApi::putOrderStatus($order->order_market_id, 2, $text);

                    $text = 'Заказ успешно доставлен покупателю.';
                    $response = RozetkaApi::putOrderStatus($order->order_market_id, 6, $text);

                    $message = 'Заказ №'.$order->id.' успешно выполнен!';

                    if($response->success){
                        $data = self::receivedOrderTrait($order);
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }

                }elseif($market_id == '2'){

                    $response = PromApi::postOrderReceived($order);

                    if(array_key_exists('processed_ids', $response)){
                        $data = self::receivedOrderTrait($order);
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $data = self::receivedOrderTrait($order);
                }
                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalReceived($request, $order);
            return $result;
        }
    }

    // с провереного на отменен (!READY)
    private function confirmToCanceled(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;
                $cancel_type = $request->cancel_type;
                $cancel_text = $request->cancel_text;

                if($market_id == '1'){

                    $respons_get_order = RozetkaApi::getDataOrder($order->order_market_id);
                    $order_rozet_status = $respons_get_order->content->status;

                    $rozetka_exception_statuses = [39, 45];
                    if(in_array($order_rozet_status,$rozetka_exception_statuses)){
                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                        return json_encode($data);
                    }else{
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, $cancel_type, $cancel_text);

                        if($response->success){

                            $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                            ];
                        }
                    }
                }elseif($market_id == '2'){

                    $response = PromApi::postOrderCanceled($order, $cancel_type, $cancel_text);

                    if(array_key_exists('processed_ids', $response)){

                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);

                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }

                }else{

                    $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                }

                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalCanceled($request, $order);
            return $result;
        }
    }

    // с отправленного на выполнен (!READY)
    private function sendToReceived(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;

                if($market_id == '1'){

                    $get_market_order = RozetkaApi::getDataOrder($order->order_market_id);
                    $market_order_status = $get_market_order->content->status;

                    if($market_order_status == 6){
                        $data = self::receivedOrderTrait($order);
                    }else{
                        $text = 'Заказ успешно доставлен покупателю.';
                        $response = RozetkaApi::putOrderStatus($order->order_market_id, 6, $text);


                        $message = 'Заказ №'.$order->id.' успешно выполнен!';

                        if($response->success){
                            $data = self::receivedOrderTrait($order);
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                            ];
                        }
                    }
                }elseif($market_id == '2'){

                    $response = PromApi::postOrderReceived($order);

                    if(array_key_exists('processed_ids', $response)){
                        $data = self::receivedOrderTrait($order);
                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }
                }else{
                    $data = self::receivedOrderTrait($order);
                }
                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalReceived($request, $order);
            return $result;
        }
    }

    // с отправленного на отменен (!READY)
    private function sendToCanceled(Request $request, $order){
        if (isset($request->confirm)){
            if(self::checkOrderCompany($order)){

                $market_id = $order->marketplace_id;
                $cancel_type = $request->cancel_type;
                $cancel_text = $request->cancel_text;

                if($market_id == '1'){

                    $respons_get_order = RozetkaApi::getDataOrder($order->order_market_id);
                    $order_rozet_status = $respons_get_order->content->status;
                    $array_canceled_self = [12, 19];

                    if($order_rozet_status == 3){
                        $text = 'Заказ отправлен курьером';
                        RozetkaApi::putOrderStatus($order->order_market_id, 4, $text);
                    }elseif(in_array($order_rozet_status,$array_canceled_self)){
                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                        return json_encode($data);
                    }else{
                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                        return json_encode($data);
                    }

                    $response = RozetkaApi::putOrderStatus($order->order_market_id, $cancel_type, $cancel_text);

                    if($response->success){

                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                    }else{
                        $data = [
                            'status' => 'error',
                            'msg' => 'Код ошибки:'.$response->errors->code. ' ('.$response->errors->message.').'
                        ];
                    }
                }elseif($market_id == '2'){

                    $response = PromApi::postOrderCanceled($order, $cancel_type, $cancel_text);

                    if(array_key_exists('processed_ids', $response)){

                        $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);

                    }else{
                        if(array_key_exists('error', $response)){
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка:'.$response->error
                            ];
                        }else{
                            $data = [
                                'status' => 'error',
                                'msg' => 'Ошибка сервера'
                            ];
                        }
                    }

                }else{

                    $data = self::cancelOrderTrait($order, $cancel_type, $cancel_text);
                }

                return json_encode($data);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'В доступе отказано!'
                ]);
            }
        }else{
            $result = self::contentModalCanceled($request, $order);
            return $result;
        }
    }
    /*Группа роутов для смены статусов(end)*/

    /*  Группа функций для формирования контента модального окна смены статусов*/
    // Вызов модального окна для подверждения
    private function contentModalConfirm(Request $request, $order){
        $action = $request->action;
        $render = view('provider.company.order.index.layouts.modalsContent.confirm', compact('order', 'action'))->render();
        $data = [
            'status' => 'success',
            'action' => 'modal',
            'render' => $render,
            'title' => 'Вы принимаете заказ?',
            'msg' => 'Подтвердите действие!'
        ];
        return json_encode($data);
    }
    // Вызов модального окна для отправки
    private function contentModalSend(Request $request, $order){
        $action = $request->action;
        $render = view('provider.company.order.index.layouts.modalsContent.send', compact('order', 'action'))->render();
        $data = [
            'status' => 'success',
            'action' => 'modal',
            'render' => $render,
            'title' => 'Укажите способ доставки?',
            'msg' => 'Подтвердите действие!'
        ];
        return json_encode($data);
    }
    // Вызов модального окна для выполнения
    private function contentModalReceived(Request $request, $order){
        $action = $request->action;
        $render = view('provider.company.order.index.layouts.modalsContent.received', compact('order', 'action'))->render();
        $data = [
            'status' => 'success',
            'action' => 'modal',
            'render' => $render,
            'title' => 'Вы подтверждаете выполнение заказа?',
            'msg' => 'Подтвердите действие!'
        ];
        return json_encode($data);
    }
    // Вызов модального окна для отмены
    private function contentModalCanceled(Request $request, $order){
        $market_id = $order->marketplace_id;
        $action = $request->action;
        if($market_id == '1'){
            $response = RozetkaApi::getDataOrder($order->order_market_id);
            if($response->success){
                $market_order_status = $response->content->status;

                $curent_st_roz = self::getRozetOrderStatusesFromArray($market_order_status);

                $render = view('provider.company.order.index.layouts.modalsContent.canceled', compact('order', 'action', 'market_id', 'market_order_status', 'curent_st_roz'))->render();
            }else{

                $market_order_status = false;
                $render = view('provider.company.order.index.layouts.modalsContent.canceled', compact('order', 'action', 'market_id', 'market_order_status', 'curent_st_roz'))->render();
                $data = [
                    'status' => 'success',
                    'action' => 'modal',
                    'render' => $render,
                    'title' => 'Заказа с таким номером в базе данных Розетки нет!',
                    'msg' => 'Ошибка'
                ];
                return json_encode($data);
            }
        }else{
            $curent_st_prom_and_other = self::getPromAndOtherOrderStatusesFromArray();
            $render = view('provider.company.order.index.layouts.modalsContent.canceled', compact('order', 'action', 'market_id', 'curent_st_prom_and_other'))->render();
        }
        $data = [
            'status' => 'success',
            'action' => 'modal',
            'render' => $render,
            'title' => 'Укажите причину и описание отмены заказа?',
            'msg' => 'Подтвердите действие!'
        ];
        return json_encode($data);
    }
    //получение массива отмен для Розетки через массив доступных
    private function getRozetOrderStatusesFromArray($status){
        $rozet_all_statuses = $this->rozetka_status_orders;
        $resp = [];
        if($status == 1 || $status == 26){
            $current_array_statuses = [17, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43];
        }elseif($status == 2){
            $current_array_statuses = [30, 40, 10, 11];
        }elseif($status == 3 || $status == 4){
            $current_array_statuses = [12];
        }elseif($status == 5){
            $current_array_statuses = [12, 11];
        }elseif($status == 15){
            $current_array_statuses = [40];
        }elseif($status == 45){
            $current_array_statuses = [45];
        }elseif($status == 39){
            $current_array_statuses = [39];
        }elseif($status == 19){
            $current_array_statuses = [19];
        }else{
            $current_array_statuses = [12];
        }

        foreach ($current_array_statuses as $value){
            $resp[] = [
                'key' => $value,
                'value' => $rozet_all_statuses[$value][0]
            ];
        }

        return $resp;
    }
    //получение массива отмен для Прома и Закупки через массив доступных
    private function getPromAndOtherOrderStatusesFromArray(){
        $prom_all_statuses_cancel = $this->prom_status_orders;
        $resp = [];

        foreach ($prom_all_statuses_cancel as $key => $value){
            $resp[] = [
                'key' => $key,
                'value' => $value[0]
            ];
        }

        return $resp;
    }
    // формирование и запись в базу данных причину и описание отказа от заказа
    private function createStatusDataCancelOrder($order, $type, $text){
        $array_rozet = $this->rozetka_status_orders;
        $array_prom_zakup = $this->prom_status_orders;

        $market_id = $order->marketplace_id;

        $cancel_type = 'Причина отмены не указана!';
        $cancel_text = 'Описание причины отказа не указана!';

        if($market_id == 2 || $market_id == 6){
            if(array_key_exists($type, $array_prom_zakup)){
                $cancel_type = $array_prom_zakup[$type][0];
                if($text != '' && $text != null){
                    $cancel_text = $text;
                }
            }
        }elseif($market_id == 1){
            if(array_key_exists($type, $array_rozet)){
                $cancel_type = $array_rozet[$type][0];
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
    /*  Группа функций для формирования контента модального окна смены статусов(end)*/

    /* Трейты для смены статусов на платформе БигСейлс*/
    // Трейт принятого заказ на бигсейлс
    private function confirmOrderTrait($order){
        $order->status = '4';
        $order->save();

        $data = [
            'status' => 'success',
            'msg' => 'Заказ №'.$order->id.' принят!',
            'orderId' => $order->id,
            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
        ];

        return $data;
    }

    // Трейт для выпоненого заказа на БигСейлс
    private function receivedOrderTrait($order){
        $order->status = '1';
        $order->save();

        $data = [
            'status' => 'success',
            'msg' => 'Заказ №'.$order->id.' успешно выполнен!',
            'orderId' => $order->id,
            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
        ];

        return $data;
    }
    // Трейт для отмены заказа на бигсейлс
    private function cancelOrderTrait($order, $cancel_type, $cancel_text){
        $status_data_json = self::createStatusDataCancelOrder($order, $cancel_type, $cancel_text);

        $order->status_data = $status_data_json;
        $order->status = '2';
        $order->save();

        self::changeTypeTrasactionAfterChangeStatusOrder($order->id);
        SF::recalculationBalanceCompany($order->company_id);

        $data = [
            'status' => 'success',
            'msg' => 'Заказ №'.$order->id.' успешно отменен!',
            'orderId' => $order->id,
            'render' => view('provider.company.order.index.layouts.dropdownStatusButton', compact('order'))->render()
        ];

        return $data;
    }
    /* Трейты для смены статусов на платформе БигСейлс(end)*/
}

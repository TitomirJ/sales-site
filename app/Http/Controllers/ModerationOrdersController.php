<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Company;
use App\Order;
use App\CompanyWarning;
use App\Functions\RozetkaApi;
use App\Functions\PromApi;
use Illuminate\Support\Facades\Mail;
use App\Mail\RestoreCanceledOrder;


class ModerationOrdersController extends Controller
{

    public function index()
    {

        $orders_bilder = Order::select(['id','comment', 'total_sum', 'quantity', 'delivery_method', 'ttn', 'name', 'company_id', 'product_id', 'marketplace_id', 'created_at', 'status_data', 'customer_name', 'customer_phone', 'customer_email', 'customer_adress'])->where('status', '2')->where('moder_confirm', '0')->orderBy('created_at', 'desc');
        $orders_count  = $orders_bilder->count();
        $orders = $orders_bilder->paginate(20);
        $orders->load('company:id,name');
        $orders->load('product:id,name,gallery');
        $orders->load('marketplace:id,name,image_path');

        return view('adminAndModerator.moderation.order.index', compact('orders', 'orders_count'))->withTitle('Отмененные заказы');
    }

    public function show($id)
    {
        $user = Auth::user();
        if($user->isModerator()){
            $companies_array = [];
            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }
            $order = Order::where('id', $id)->first();
            if(!in_array($order->company_id, $companies_array)){
                return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
            }
        }elseif($user->isAdmin()){
            $order = Order::where('id', $id)->first();
        }else{
            return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
        }


        $order->load('product');
        $order->load('company');

        return view('adminAndModerator.moderation.order.show', compact('order'))->withTitle('Просмотр заказа');
    }

    public function destroy($id)
    {
        //
    }

    public function showActionModal(Request $request, $id){

        if($request->ajax()){

            $order = Order::find($id);
            $type = $request->type;
            $data = self::showActionModalTrait($order,$type);

            return json_encode($data);
        }
    }
    private function showActionModalTrait($order, $action){
        $data = [];
        $type = $action;
        if($action == 'restore'){
            $flag_check_order = self::checkStatusOrderBeforAction($order);
            if($flag_check_order){
                $data['title'] = 'Восстановить заказ?';
            }else{
                $data['title'] = 'Заказ отменен на маркетплейсе, вернуть деньги на депозит и отменить заказ?';
                $type = 'restore-cancel';
            }
        }elseif($action == 'cancel'){
            $data['title'] = 'Отменить заказ?';
        }elseif($action == 'ignor'){
            $data['title'] = 'Проигнорировать заказ?';
        }elseif($action == 'block'){
            $data['title'] = 'Пожаловаться на компанию?';
        }

        $data['status'] = 'success';
        $data['render'] = view('adminAndModerator.moderation.order.layouts.modalContent', compact('order', 'type'))->render();

        return $data;
    }
    private function checkStatusOrderBeforAction($order){
        $marketplace = 	$order->marketplace_id;
        if($marketplace == '1'){
            $id = $order->order_market_id;
            $api_resault = RozetkaApi::getDataOrder($id);
            $api_order_status = $api_resault->content->status;
            if($api_order_status == 1){
                return true;
            }else{
                return false;
            }
        }elseif($marketplace == '2'){
            $api_resault = PromApi::getOrderData($order);
            $api_order_status = $api_resault->order->status;
            if($api_order_status == 'pending' || $api_order_status == 'canceled'){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function actionWithModerOrders(Request $request){
        if($request->ajax()){
            $data = [];
            $order = Order::find($request->order_id);


            $action = $request->action;
            if($action == 'ignor'){
                $order->moder_confirm = '1';
                $order->save();

                $data['status'] = 'success';
                $data['msg'] = 'Заказ проверен и отправлен в архив!';
                $data['orderId'] = $order->id;
            }elseif($action == 'block'){
                $data_error = [
                    'short_error' => $request->short_error,
                    'long_error' => $request->long_error
                ];


                $inspector_id = Auth::user()->id;
                $company_id = $order->company_id;
                self::sendOrderToAdminForBlockCompany($request, $company_id, $inspector_id);

                $order->moder_confirm = '1';
                $order->data_error = json_encode($data_error);
                $order->save();

                $data['status'] = 'success';
                $data['msg'] = 'Заказ проверен и отправлен администратору на рассмотение!';
                $data['orderId'] = $order->id;
            }elseif($action == 'restore'){
                $order->status = '4';
                $order->save();

                $data['status'] = 'success';
                $data['msg'] = 'Заказ успешно востановлен, статус на маркетплейсе изменен на "Принят"!';
                $data['orderId'] = $order->id;

                self::changeStatusOrderToConfirm($order);
                self::sendEmailToProviderAboutRestoreOrder($order);
            }elseif($action == 'restore-cancel'){

            }elseif($action == 'cancel'){

                // нужно дописать метод смены статуса заказа и транзакции,
                // пересчитать баланс, востоновить товары если нужно,
                // а также отправить статус на маркетплейс о отменен заказа
                $data['status'] = 'success';
                $data['msg'] = 'Заказ успешно отменен, комиссия возвращена компании!';
            }

            return json_encode($data);
        }
    }
    private function changeStatusOrderToConfirm($order){
        if ($order->marketplace_id == '1'){// Розетка

            $text = 'Заказ принят в разработку';
            RozetkaApi::putOrderStatus($order->order_market_id, 26, $text);

        }elseif($order->marketplace_id == '2'){
            PromApi::postOrderConfirm($order);
        }
    }
    private function sendEmailToProviderAboutRestoreOrder($order){
        $user = User::find($order->user_id);
        $company = Company::find($user->company_id);
        Mail::to($user->email)->send(new RestoreCanceledOrder($company, $order));
    }

    private function sendOrderToAdminForBlockCompany($request, $company_id, $inspector_id){
        CompanyWarning::updateOrCreate(
            ['type_warning' => '1', 'order_id' => $request['order_id']],
            [
                'company_id' => $company_id,
                'inspector_id' => $inspector_id,
                'type_warning' => '1',
                'desc_warning' => $request['long_error'],
                'order_id' => $request['order_id'],
                'confirm' => '0'
            ]
        );
    }
}

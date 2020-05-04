<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Functions\StaticFunctions as SF;
use App\User;
use App\Company;
use App\Product;
use App\Order;
use Carbon\Carbon;
use App\Transaction;
use App\AndroidLoginToken;

class ApiProviderOrderController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        // self::checkProvider($user);

        $orders = Order::where('company_id', $user->company_id)->get();
        $orders->load('marketplace');
        $data = [];
        $count = 0;

        foreach ($orders as $order){
            $data[$count]['id'] = $order->id;
            $data[$count]['name'] = $order->name;
            $data[$count]['price'] = $order->total_sum;
            $data[$count]['quantity'] = $order->quantity;
            $data[$count]['ttn'] = $order->ttn;
            $data[$count]['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d');
            $data[$count]['status'] = $order->status;
            $data[$count]['delivery_method'] = $order->delivery_method;
            $data[$count]['marketplace'] = $order->marketplace->name;
            $json_array = json_decode($order->product->gallery);
            $data[$count]['image'] = $json_array[0]->public_path;
            $count++;
        }
        return response()->json($data);
    }

    public function show(Request $request, $id){
        $user = Auth::user();
        $order = Order::find($id);
        $order->load('marketplace');
        if($user->company_id == $order->company_id){
            $data = [];

            $data['id'] = $order->id;
            $data['name'] = $order->name;
            $data['price'] = $order->total_sum;
            $data['quantity'] = $order->quantity;
            $data['ttn'] = $order->ttn;
            $data['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y-m-d');
            $data['status'] = $order->status;
            $data['commission_sum'] = $order->commission_sum;
            $data['customer_name'] = $order->customer_name;
            $data['customer_email'] = $order->customer_email;
            $data['customer_phone'] = $order->customer_phone;
            $data['customer_adress'] = $order->customer_adress;
            $data['comment'] = $order->comment;
            $data['delivery_method'] = $order->delivery_method;
            $data['marketplace'] = $order->marketplace->name;
            $data['payment_method'] = $order->payment_method;
            $json_array = json_decode($order->product->gallery);
            $data['image'] = $json_array[0]->public_path;
            $data['image_market'] = asset($order->marketplace->image_path);

            return response()->json($data);
        }else{
            abort('404');
        }

    }

    public function update(Request $request, $id){
        $user = Auth::user();
        $order = Order::find($id);
        if($request->method() == 'PUT'){
            if($user->company_id == $order->company_id){
                $resronse = self::changeStatusOrder($request->all(), $id);
                return $resronse;
            }
        }else{
            abort('404');
        }
    }

    private function changeStatusOrder($request, $order_id){
        $order = Order::find($order_id);
        $status_order = $request['status'];
        if($status_order == '3'){
            $order->ttn = $request['ttn'];
            $order->status = $status_order;
            $order->save();

            return 'true';
        }elseif($status_order == '2'){
            $order->status = $status_order;
            $order->save();


            //изменение статуса транзакции и перерасчет баланса
             self::changeTypeTrasactionAfterChangeStatusOrder($order->id);
             SF::recalculationBalanceCompany($order->company_id);//перерасчет баланса


            $type_cancel = $request['cancellation_reason'];
            $text_cancel = $request['cancellation_text'];
            self::changeStatusCancelToMarketplace($order, $type_cancel, $text_cancel);

            return 'true';
        }else{
            $order->status = $status_order;
            $order->save();

            return 'true';
        }
    }

    private function changeTypeTrasactionAfterChangeStatusOrder($order_id){
        Transaction::where('order_id', $order_id)->update(['type_transaction' => '2']);
    }

    private function changeStatusCancelToMarketplace($order, $type, $text){
        if($order->marketplace_id == '2'){
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
        }
    }

    public function brief(){
        $array = [];
        $company_id = Auth::user()->company_id;
        $orders = Order::where('company_id', $company_id)->get();
        $orders->load('marketplace');

        $count_orders = 0;
        $count_new_orders = 0;
        $sum_ended_orders = 0;
        $count_ended_orders = 0;
        $count_deleted_orders = 0;

        foreach ($orders as $order){
            $array[$order->marketplace_id] = [
                'id_market'=> $order->marketplace->id,
                'name_market'=>$order->marketplace->name,
                'count_orders'=>(isset($array[$order->marketplace_id]['count_orders']) ? $array[$order->marketplace_id]['count_orders'] : 0)+1,
                'color_market'=>$order->marketplace->pie_color,
            ];

            $count_orders++;
            if($order->status == '1'){
                $sum_ended_orders += $order->total_sum;
                $count_ended_orders++;
            }
            if($order->status == '0'){
                $count_new_orders++;
            }
            if($order->status == '2'){
                $count_deleted_orders++;
            }
        }
        $array = array_values($array);

        $data = [
            'pie_chart' => $array,
            'count_orders' => $count_orders,
            'total_sum' => $sum_ended_orders,
            'count_left_orders' => $count_deleted_orders,
            'count_new_orders' => $count_new_orders,
            'count_confirm_orders' => $count_ended_orders,
            'count_left_orders_d' => $count_deleted_orders,
        ];

        return json_encode($data);
    }
}

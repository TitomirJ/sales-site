<?php

namespace App\Functions;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Cache;
use Carbon\Carbon;
use App\Order;


class PromApi
{

    // получение информации по заказу от Пром.уа
    public static function getOrderInfo($order)
    {
        $api_key = env('PROM_API_KEY');
        $prom_order_id = $order->market_id;


        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        $result = $client->get('https://my.prom.ua/api/v1/orders/' . $prom_order_id);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // получение списка заказов от Пром.уа
    public static function getOrdersList()
    {
        $api_key = env('PROM_API_KEY');

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        $result = $client->get('https://my.prom.ua/api/v1/orders/list');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // подтверждение принятоого заказа от Пром.уа компанией
    public static function postOrderConfirm($order)
    {
        $api_key = env('PROM_API_KEY');
		//$api_key ='65e89392924a3810aef0ddc492a960858baa8527';
        $prom_order_id = $order->market_id;

		//dd($api_key);
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
            'json' => [
                "status" => 'received',
                "ids" => [ $prom_order_id ]
            ]
        ]);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // подтверждение отправленного заказа от Пром.уа компанией
    public static function postOrderDelivery($order)
    {
        $api_key = env('PROM_API_KEY');
        $prom_order_id = $order->market_id;

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
            'json' => [
                "status" => 'paid',
                "ids" => [ $prom_order_id ]
            ]
        ]);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // подтверждение выполненого заказа от Пром.уа компанией
    public static function postOrderReceived($order)
    {
        $api_key = env('PROM_API_KEY');
        $prom_order_id = $order->market_id;

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
            'json' => [
                "status" => 'delivered',
                "ids" => [ $prom_order_id ]
            ]
        ]);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // подтверждение отмененного заказа от Пром.уа компанией
    public static function postOrderCanceled($order, $cancel_type, $cancel_text)
    {
        $api_key = env('PROM_API_KEY');
        $prom_order_id = $order->market_id;

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        if($cancel_type == 'price_changed' || $cancel_type == 'not_enough_fields' || $cancel_type == 'another'){
            $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
                'json' => [
                    "status" => 'canceled',
                    "ids" => [ $prom_order_id ],
                    'cancellation_reason' => $cancel_type,
                    'cancellation_text' => $cancel_text
                ]
            ]);
        }else{
            $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
                'json' => [
                    "status" => 'canceled',
                    "ids" => [ $prom_order_id ],
                    'cancellation_reason' => $cancel_type
                ]
            ]);
        }


        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //получение данных по заказу через апи Прома
    public static function getOrderData($order){
        $api_key = env('PROM_API_KEY');
        $prom_order_id = $order->market_id;

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$api_key,
            'Content-Type' => 'application/json'
        ]]);

        try {
            $result = $client->request('GET','https://my.prom.ua/api/v1/orders/'.$prom_order_id);
            $body_json = $result->getBody();
            $body_array = json_decode($body_json);
        } catch (RequestException $e) {
            $array =  [ 'order' =>
                [
                    'status' => 'not found'
                ]
            ];

            $object = self::array_to_object($array);
            return $object;
        }

        return $body_array;
    }
    private static function array_to_object($array)
    {
        foreach($array as $key => $value)
        {
            if(is_array($value))
            {
                $array[$key] = self::array_to_object($value);
            }
        }
        return (object)$array;
    }

    // подтверждение принятоого заказа от Пром.уа компанией
//    public static function getProductsList()
//    {
//        $api_key = env('PROM_API_KEY');
//
//
//        $client = new Client(['headers' => [
//            'Authorization' => 'Bearer '.$api_key,
//            'Content-Type' => 'application/json'
//        ]]);
//
//        $result = $client->request('POST','https://my.prom.ua/api/v1/orders/set_status', [
//            'json' => [
//                "status" => 'received',
//                "ids" => [ $prom_order_id ]
//            ]
//        ]);
//
//        $body_json = $result->getBody();
//        $body_array = json_decode($body_json);
//
//        return $body_array;
//    }
}
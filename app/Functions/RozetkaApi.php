<?php

namespace App\Functions;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Cache;
use Carbon\Carbon;
use App\Order;


class RozetkaApi
{
    //получение токена доступа для Розетки (Авторизация)
    public static function createOrGetTokenRozetkaAvtorizationFromCache()
    {
        //dd(Cache::get('Rozet_auth_token'));
		if(!Cache::has('Rozet_auth_token')){
            $client = new Client(); //GuzzleHttp\Client
            $result = $client->post('https://api.seller.rozetka.com.ua/sites', [
                'form_params' => [
                    'username' => env('ROZETKA_LOGIN'),
                    'password' => base64_encode(env('ROZETKA_PASSWORD'))

                ]
           ]);


            $body_json = $result->getBody();
            $body_array = json_decode($body_json);
            $content_array = $body_array->content;
            $rozetka_auth_token = $content_array->access_token;


            $expiresAt = Carbon::now()->addMinutes(120);
            Cache::put('Rozet_auth_token', $rozetka_auth_token, $expiresAt);

            return $rozetka_auth_token;
        }else{

            return Cache::get('Rozet_auth_token');
        }
    }

    // фасад авторизации
    private static function authorizationFacadeRozetka(){
        $token = RozetkaApi::createOrGetTokenRozetkaAvtorizationFromCache();
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json',
             "cache-control" => "no-cache"
        ]]); //GuzzleHttp\Client

        return $client;
    }

    //поиск доступных статусов заказов через АПИ Розетки
    public static function searchAvailStatusesRozetka($id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/order-statuses/search?id='.$id.'&expand=status_available');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //поиск доступных статусов заказов через АПИ Розетки
    public static function searchAvailStatusesGroupRozetka($id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/order-statuses/search?status_group='.$id.'&expand=status_available');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //поиск подкатегорий через АПИ Розетки
    public static function searchSubcatFromRozetka($market_id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/market-categories/search?category_id=' . $market_id);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //поиск характеристик подкатегорий  через АПИ Розетки
    public static function searchSubcatParametrsFromRozetka($market_id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/market-categories/category-options?category_id=' . $market_id);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //поиск заказов по поараметрам(вывод списком)
    public static function getOrderSearchList($data){
        $client = self::authorizationFacadeRozetka();
        $url_params = http_build_query($data);// url data params

        $result = $client->get('https://api.seller.rozetka.com.ua/orders/search?' .  $url_params);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //получить список заказов Розетки по типу
    public static function getOrderTypeList($type){
        $client = self::authorizationFacadeRozetka();
        $first_result = $client->get('https://api.seller.rozetka.com.ua/orders/search?type='.$type);
        $first_body_array = json_decode($first_result->getBody());
        $pages = $first_body_array->content->_meta->pageCount;

        $array_orders_id = [];
        for($i = 1; $i <= $pages; $i++){
            $wile_request = $client->get('https://api.seller.rozetka.com.ua/orders/search?type='.$type.'&page='.$i);
            $wile_request = json_decode($wile_request->getBody());
            foreach ($wile_request->content->orders as $o){
                array_push($array_orders_id, $o->id);
            }
        }

        return $array_orders_id;
    }

    //получение полной информации по заказу
    public static function getDataOrder($id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/orders/' .  $id.'?expand=purchases');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    // изменение статуса заказа
    public static function putOrderStatus($id, $status, $seller_comment, $ttn = ''){
        $token = RozetkaApi::createOrGetTokenRozetkaAvtorizationFromCache();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.seller.rozetka.com.ua/orders/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n\t\"status\": $status,\n\t\"seller_comment\":\"$seller_comment\",\n\t\"ttn\": \"$ttn\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$token,
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $body_array = "cURL Error #:" . $err;
        } else {
            $body_array = json_decode($response);
        }

        return $body_array;
    }

    //Поиск товара по нашему имени и артикулу
    public static function getSearchProductToNameAndCode($name){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/items/search?expand=sell_status&item_active=1&page=56');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    //Список активных товаров
    public static function getSearchActiveProducts(){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/items/search?item_active=1&page=26');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    /*
     * Методы для работы с коментариями и сообщениями
    */

    // метод получения списка чатов по параметрам
    public static function searchMassages($params){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/messages/search?'.$params);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    public static function getMassage($id){
        $client = self::authorizationFacadeRozetka();

        $result = $client->get('https://api.seller.rozetka.com.ua/messages/'.$id.'?expand=messages');

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;
    }

    /* Отправка сообщения для чата Розетки*/
    public static function createMessageForChart($request){

        $client = self::authorizationFacadeRozetka();

        $form_data = [
            'body' => (string) $request['body'],
            'chat_id' => (int) $request['m_id'],
            'sendEmailUser' => (int) (isset($request['send_email'])) ? 1 : 0,
            'receiver_id' => (int) $request['receiver_id']
        ];

        if(isset($request['m_order_id'])){
            $form_data['order_id'] = (int) $request['m_order_id'];
        }

        $result = $client->request('POST', 'https://api.seller.rozetka.com.ua/messages/create', [
            'form_params' => $form_data
        ]);

        $body_json = $result->getBody();
        $body_array = json_decode($body_json);

        return $body_array;

        /*
          +"success": true
          +"content": {#2126
            +"chat_id": 3500415
            +"body": "Тест"
            +"created": "2019-05-30 10:01:49"
            +"receiver_id": 72892692
            +"sender": 2
            +"seller": {#2139 }
            +"seller_id": 6511
        }*/

    }
}
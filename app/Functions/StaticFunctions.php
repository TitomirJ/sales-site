<?php

namespace App\Functions;

use App\Company;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Vis\eSputnikClient\eSputnikClient;

class StaticFunctions
{

    //статическая функция отправки смс
    public static function sendsms($from, $text, $phone)
    {
        $client = new eSputnikClient();
        $phones = [$phone];
        $client->sendSMS($from, $text, $phones);
    }

    //статическая функция перерасчета баланса
    static public  function recalculationBalanceCompany($company_id){
        $transactions_all = Transaction::where('company_id', $company_id)->get();

        $debet_array = [];
        $kredit_array = [];

        foreach ($transactions_all as $t){
            if($t->type_dk == '1'){
                if($t->type_transaction != '4' && $t->type_transaction != '3'){
                    array_push($debet_array, $t->total_sum);
                }
            }elseif($t->type_dk == '0'){
                if($t->type_transaction != '2'){
                    array_push($kredit_array, $t->total_sum);
                }
            }
        }

        $debet_sum = array_sum($debet_array);
        $kredit_sum = array_sum($kredit_array);
        $balance = $debet_sum-$kredit_sum;


        $res = DB::table('companies')
            ->where('id', $company_id)
            ->update([
                'balance_sum' => $balance,
                'debet_sum' => $debet_sum,
                'kredit_sum' => $kredit_sum,
            ]);

        return $res;
    }

    public static function checkCompanyBalance($company_id){
        $company = Company::find($company_id);
        if($company->balance_sum <= $company->balance_limit){
            if($company->block_bal == '0'){
                $company->block_bal = '1';
                $company->save();
            }
        }elseif($company->balance_sum > $company->balance_limit){
            if($company->block_bal == '1'){
                $company->block_bal = '0';
                $company->save();
            }
        }
    }

    //Не используется в данный момент(может пригодиться)
    public static function checkCompanyAboniment($company_id){
        $company = Company::find($company_id);

        $flag = self::checkAbonimentDatesCompany($company->ab_to);

        if($flag){
            if($company->block_ab == '1'){
                $company->block_ab = '0';
                $company->save();
            }
        }else{
            if($company->block_ab == '0'){
                $company->block_ab = '1';
                $company->save();
            }
        }
    }

    //Не используется в данный момент(может пригодиться)
    public static function checkAbonimentDatesCompany($ab_time){
        $time_now = time();
        $time_aboniment = strtotime($ab_time);
        if($time_aboniment >= $time_now){
            return true;
        }elseif($time_aboniment < $time_now){
            return false;
        }

    }

    //проверка на компании на вывод товаров из маркета
    public static function checkCompanyToBlockProductsSpetial($company_id){
        $company = Company::find($company_id);
        if($company->block_ab == '0' && $company->block_bal == '0' && $company->block_new == '0'){
            return true;
        }else{
            return false;
        }
    }
    //вывод или отправка товаров на маркетплейсы после проверки блокировок компании
    public static function changeProductsSpetialStatus($company_id, $flag){
        if($flag){ $block = '1'; }else{ $block = '0'; }

        $count_changed_products = DB::table('products')
            ->where('company_id', $company_id)
            ->update(['status_spacial' => $block]);

        return $count_changed_products;
    }

    public static function sendNotificationToAndroidAboutNewOrder($token, $order_id){
        $api_access_key = env('API_ACCESS_KEY');

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $fcmNotification = [
            'to'        => $token,
            'data' => [
                "body" => "Новый заказ",
                "title" => "Заказ",
                "order_id" => $order_id,
            ]
        ];

        $headers = [
            'Authorization: key=' . $api_access_key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
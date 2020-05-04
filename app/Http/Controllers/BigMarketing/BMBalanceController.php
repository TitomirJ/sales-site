<?php

namespace App\Http\Controllers\BigMarketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Functions\StaticFunctions as SF;
use Illuminate\Support\Facades\Session;
use App\BmTransaction;
use App\Currency;

class BMBalanceController extends Controller
{
    public function liqpayStatus(Request $request)
    {
        $data = $request->data;
        $signature = $request->signature;
        $result= json_decode( base64_decode($request->data ));

        if(self::checkSignature($signature, $data)){
            return redirect()->to('/bigmarketing/pay')->with('result-liqpay', $result);
        }else{
            return redirect()->to('/bigmarketing/pay')->with('danger', 'Сигнатуры данных, платежной системы, отсутствуют или не верны!');
        }
    }

    public function liqpayServer(Request $request)
    {

        $data = $request->data;
        $signature = $request->signature;
        if(self::checkSignature($signature, $data)){
            self::checkStatusPayment($data);
        }else{
            Log::info('Сигнатуры не совпадают!');
            Log::info(base64_decode($data));
        }
    }

    private function checkStatusPayment($data)
    {

        $resault_data = json_decode( base64_decode($data));
        if($resault_data->status == 'success' || $resault_data->status == 'sandbox')
        {
            $bm_transaction_code = $resault_data->order_id;
            $bm_transaction_bilder = BmTransaction::where('code', $bm_transaction_code);

            $bm_transaction_bilder->update([
                'status' => '1',
                'data' => base64_decode($data)
            ]);

            //Уведомление для Влада о пополнении баланса или абонплаты
            self::sendSMStoVlad($bm_transaction_code);

        }elseif($resault_data->status == 'failure' || $resault_data->status == 'error'){
            $bm_transaction_code = $resault_data->order_id;
            $bm_transaction_bilder = BmTransaction::where('code', $bm_transaction_code);
            $bm_transaction_bilder->update([
                'status' => '2',
                'data' => base64_decode($data)
            ]);
        }
    }

    private function checkSignature($request_signature, $request_data)
    {
        $private_key = env('LIQPAY_PRIVAT_KEY');

        $liqpay_data = $request_data;
        $liqpay_signature = $request_signature;

        $resault_sign = base64_encode( sha1($private_key.$liqpay_data.$private_key, 1 ));

        if($liqpay_signature === $resault_sign){
            return true;
        }else{
            return false;
        }
    }

    private function sendSMStoVlad($bm_transaction_code){
        $bm_transaction = BmTransaction::where('code', $bm_transaction_code)->first();
        $currency = Currency::find($bm_transaction->currency_id);

        $from = env('ALFA_NAME_ESPUTNIK');
        $text = $bm_transaction->name.' '.$bm_transaction->surname.' пополнил(а) счет BigMarketing.com.ua на сумму '.$bm_transaction->amount.' '.$currency->short_name;
        $phone = env('VLAD_PHONE');
        SF::sendsms($from, $text, $phone);
    }
}

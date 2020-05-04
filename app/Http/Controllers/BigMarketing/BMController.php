<?php

namespace App\Http\Controllers\BigMarketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\LiqPay;
use Illuminate\Pagination\Paginator;
use App\Currency;
use App\BmTransaction;

class BMController extends Controller
{
    public function index(){
        $currencies = Currency::all();

        return view('bigmarketing.pay.payForm', compact('currencies'));
    }

    public function balance(){
        if(Auth::user()->id == 28 || Auth::user()->id == 9){
            $bm_transactions = BmTransaction::where('status', '<>', '0')->orderBy('created_at', 'desc')->paginate(20);
            $bm_transactions->load('currency');

            return view('bigmarketing.balance.index', compact('bm_transactions'))->withTitle('BigMarketing баланс');
        }else{
            abort('404');
        }
    }

    public function createPayForm(Request $request){
        if($request->ajax()){
            $response_data = [];

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:80',
                'surname' => 'required|string|max:80',
                'phone' => 'required|max:40',
                'amount' => 'required|max:20',
                'description' => 'max:255|min:10',
            ]);

            if ($validator->fails()) {
                $response_data['status'] = 'error';
                $response_data['errors'] = $validator->errors();
                return json_encode($response_data);
            }

                $bm_transaction = self::createBmTransaction($request);

                $type_modal = 'LiqPay_form';
                $liq_pay_bytton = self::getLiqPayButton($request, $bm_transaction);

                $response_data['status'] = 'success';
                $response_data['render'] = view('bigmarketing.pay.layouts.modalContent', compact('type_modal', 'bm_transaction', 'liq_pay_bytton'))->render();

                return json_encode($response_data);
        }else{
            abort('404');
        }
    }

    private function createBmTransaction(Request $request){
        $code = sha1(date('YmdHis').str_random(5));

        $bm_transaction = BmTransaction::create([
            'code' => $code ,
            'name' => (isset($request->name)) ? $request->name : 'No name',
            'surname' => (isset($request->surname)) ? $request->surname : 'No surname',
            'email' => (isset($request->email)) ? $request->email : 'No email',
            'phone' => (isset($request->phone)) ? $request->phone : 'No name',
            'currency_id' => $request->currency_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return $bm_transaction;
    }

    private function getLiqPayButton(Request $request, $bm_transaction){
        $currency = Currency::find($bm_transaction->currency_id);


        $server_url =  asset('bigmarketing/liqpay/server');
        $result_url =  asset('bigmarketing/liqpay/status');

        $params = [
            'action'         => 'pay',
            'amount'         => $bm_transaction->amount,
            'currency'       => $currency->code,
            'description'    => $bm_transaction->description,
            'order_id'       => $bm_transaction->code,
            'version'        => '3',
            'language'       => 'ru',
            'sender_first_name' => $bm_transaction->name,
            'sender_last_name' => $bm_transaction->surname,
            "server_url" => $server_url,
            "result_url" => $result_url,
            //'sandbox'  => true,
        ];

        $public_key = env('LIQPAY_PUBLIC_KEY');
        $privat_key = env('LIQPAY_PRIVAT_KEY');

        $liqP = new LiqPay($public_key , $privat_key);
        $formLiqPay = $liqP->cnb_form($params);

        return $formLiqPay;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Company;
use App\Transaction;
use App\Product;
use App\TariffAboniment;
use App\TariffDeposite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LiqPay;
use App\Functions\StaticFunctions as SF;
use Notification;
use App\Notifications\AdminTransactionShipped;
use Illuminate\Support\Collection;

class ProviderBalanceController extends Controller
{
    public function index(Request $request){

        $company_id = Auth::user()->company_id;
        //Рекалькуляция времено отключена, калькуляция происходит во время появления товара и пополнения баланса
    //  SF::recalculationBalanceCompany($company_id);
//        SF::checkCompanyBalance($company_id);

        $company = Company::find($company_id);
        $transactions = Transaction::where('company_id', $company_id)->where('type_transaction', '<>', '4')->orderBy('created_at', 'desc')->get();

        $products =  Product::where('company_id', $company_id)->get();
        $products->load('subcategory');
        if(session('result')){
            $result = session('result');
            Session::forget('result');
            return view('provider.company.balance.index', compact('company', 'transactions', 'products', 'result'))->withTitle('Баланс');
        }
        return view('provider.company.balance.index', compact('company', 'transactions', 'products'))->withTitle('Баланс');
    }

    private function deleteTransactionsTypeFour($company_id){
        Transaction::where('company_id', $company_id)->where('type_transaction', '4')->delete();
    }

    public function getSelectPayForm(Request $request){
        $user =  Auth::user();
        $company_id = $user->company->id;
        $type = $request->type;
        if($type == 'ab'){
            $select = TariffAboniment::all();
        }elseif($type == 'bal'){
            $select = TariffDeposite::all();
        }

        $data['render']= view('provider.company.balance.modal.layouts.select', compact('user', 'type', 'select'))->render();
        return json_encode($data);
    }

    public function getLiqpayForm(Request $request){
        $user =  User::find(Auth::user()->id);
        $user->load('company');
        $data = $request->all();

        $public_key = env('LIQPAY_PUBLIC_KEY');
        $privat_key = env('LIQPAY_PRIVAT_KEY');
        $tariff_id = $data['tariff'];
        if($data['pay_type'] == 'ab'){
            $tariff = TariffAboniment::find($tariff_id);
        }elseif($data['pay_type'] == 'bal'){
            $tariff = TariffDeposite::find($tariff_id);
        }
        $price = $tariff->amount*1.02828;
        $time = date('Y-m-d H:i:s', time());

        if($data['pay_type'] == 'ab'){
            $transaction_id = DB::table('transactions')->insertGetId(
                [
                    'company_id' => $user->company->id,
                    'type_dk' => '1',
                    'type_transaction' => '4',
                    'total_sum' => $tariff->amount,
                    'created_at' => $time,
                    'data_ab' => $tariff->count_d,
                    'data' => $data['pay_type']
                ]
            );
            $desc = 'Пополнение абонимента компании "'.$user->company->name.'" на сайте BigSales.pro, платеж №'.$transaction_id;
        }elseif($data['pay_type'] == 'bal'){
            $transaction_id = DB::table('transactions')->insertGetId(
                [
                    'company_id' => $user->company->id,
                    'type_dk' => '1',
                    'type_transaction' => '4',
                    'total_sum' => $tariff->amount,
                    'created_at' => $time,
                    'data' => $data['pay_type']
                ]
            );

            $desc = 'Пополнение баланса компании "'.$user->company->name.'" на сайте BigSales.pro, платеж №'.$transaction_id;
        }

        $server_url =  asset('/liqpay/server');
        $result_url =  asset('/liqpay/status');

        if(($user->name == '' || $user->name == null) && ($user->surname == '' || $user->surname == null)){
            $params = [
                'action'         => 'pay',
                'amount'         => $price,
                'currency'       => 'UAH',
                'description'    => $desc,
                'order_id'       =>  $transaction_id,
                'version'        => '3',
                'language'       => 'ru',
                "server_url" => $server_url,
                "result_url" => $result_url,
                // 'sandbox'  => true,
            ];
        }elseif($user->name == '' || $user->name == null){
            $params = [
                'action'         => 'pay',
                'amount'         => $price,
                'currency'       => 'UAH',
                'description'    => $desc,
                'order_id'       =>  $transaction_id,
                'version'        => '3',
                'language'       => 'ru',
                'sender_last_name' => $data['payeur_surname'],
                "server_url" => $server_url,
                "result_url" => $result_url,
                // 'sandbox'  => true,
            ];
        }elseif($user->surname == '' || $user->surname == null){
            $params = [
                'action'         => 'pay',
                'amount'         => $price,
                'currency'       => 'UAH',
                'description'    => $desc,
                'order_id'       =>  $transaction_id,
                'version'        => '3',
                'language'       => 'ru',
                'sender_first_name' => $data['payeur_name'],
                "server_url" => $server_url,
                "result_url" => $result_url,
                // 'sandbox'  => true,
            ];
        }else{
            $params = [
                'action'         => 'pay',
                'amount'         => $price,
                'currency'       => 'UAH',
                'description'    => $desc,
                'order_id'       =>  $transaction_id,
                'version'        => '3',
                'language'       => 'ru',
                'sender_first_name' => $data['payeur_name'],
                'sender_last_name' => $data['payeur_surname'],
                "server_url" => $server_url,
                "result_url" => $result_url,
                // 'sandbox'  => true,
            ];
        }

        $liqP = new LiqPay($public_key , $privat_key);
        $formLiqPay = $liqP->cnb_form($params);

        $data['render_body']= view('provider.company.balance.modal.layouts.payInfo', compact('user', 'data', 'price', 'time'))->render();
        $data['render_footer']= view('provider.company.balance.modal.layouts.liqpayButtonAndCancel', compact('formLiqPay'))->render();
        return json_encode($data);
    }

    public function liqpayStatus(Request $request)
    {
        $data = $request->data;
        $signature = $request->signature;
        $result= json_decode( base64_decode($request->data ));

        if(self::checkSignature($signature, $data)){
            Session::put('result', $result);
            return redirect()->to('/company/balance');
        }else{
            return redirect()->to('/company/balance')->with('danger', 'Сигнатуры данных, платежной системы, отсутствуют или не верны!');
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
            $transaction_id = $resault_data->order_id;
            $transaction = Transaction::find($transaction_id);
            $company_id = $transaction->company_id;

            if($transaction->data == 'bal'){
                $transaction->type_transaction = '0';
                $transaction->data = base64_decode($data);
                $transaction->save();

                SF::recalculationBalanceCompany($company_id);//перерасчет баланса
                SF::checkCompanyBalance($company_id);//блокировка или разблокировка баланса
                $count_changed_products = self::comboFunctionsProductsSpetial($company_id);

            }elseif($transaction->data == 'ab'){
                $count_d = $transaction->data_ab;

                $transaction->type_transaction = '3';
                $transaction->data = base64_decode($data);
                $transaction->save();

                self::addAbonimentToCompany($company_id, $count_d);
                $count_changed_products = self::comboFunctionsProductsSpetial($company_id);
            }

            self::deleteTransactionsTypeFour($company_id);

            //Уведомление для Влада о пополнении баланса или абонплаты
            self::sendSMStoVlad($company_id, $transaction->type_transaction, $transaction->total_sum);
            //Создание группового уедомления для сотрудников сайта
            self::createAdminTransactionNotification($transaction->id);

        }elseif($resault_data->status == 'failure' || $resault_data->status == 'error'){

            Log::info('Ошибка платежа'.base64_decode($data));
        }
    }

    private function createAdminTransactionNotification($id){
        $users = User::all();

        $personnel_bigsales = collect($users)->filter(function ($item, $key) {
            if ($item->isAdmin()) {
                return true;
            }
        });

        $transaction = Transaction::find($id);
        $company = $transaction->company;

        Notification::send($personnel_bigsales, new AdminTransactionShipped($transaction, $company));
    }

    private function sendSMStoVlad($company_id, $type, $sum){
        $type_pay = '';
        if($type == '0'){
            $type_pay = 'баланс';
        }elseif($type == '3'){
            $type_pay = 'абонплату';
        }

        $company = Company::find($company_id);

        $from = env('ALFA_NAME_ESPUTNIK');
        $text = 'Компания "'.$company->name.'" пополнила '.$type_pay.' на сумму '.$sum.' грн.';
        $phone = env('VLAD_PHONE');
        SF::sendsms($from, $text, $phone);
    }

    private function comboFunctionsProductsSpetial($company_id){
        $flag = SF::checkCompanyToBlockProductsSpetial($company_id);
        $resault = SF::changeProductsSpetialStatus($company_id, $flag);

        return $resault;
    }

    private function addAbonimentToCompany($company_id, $count_d){
        $company = Company::find($company_id);
        $date_now = time();
        $date_ab_old = $company->ab_to;
        $date_ab_old_unix = strtotime($date_ab_old);

        $days = $count_d;
        $index_day = 86400;
        $time_delimit = $days*$index_day;

        if($date_ab_old_unix >= $date_now){
            $next_date = date('Y-m-d 23:59:59', $date_ab_old_unix+$time_delimit);
        }else{
            $next_date = date('Y-m-d 23:59:59', $date_now+$time_delimit);
        }

        $company->ab_from = null;
        $company->ab_to = $next_date;
        $company->block_ab = '0';
        if($company->block_new == '1'){
            $company->block_new = '0';
        }
        $company->save();
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
}
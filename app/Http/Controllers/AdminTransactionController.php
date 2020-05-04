<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TariffAboniment;
use App\TariffDeposite;
use App\Company;
use DB;
use App\Functions\StaticFunctions as SF;
use Illuminate\Support\Facades\Auth;

class AdminTransactionController extends Controller
{
    public function storeNewTransaction(Request $request){
        $action = $request->action;
        $company_id = $request->company_id;

        $company = Company::find($company_id);

        if($action == 'add_bal' || $action == 'remove_bal'){
            $amount = $request->amount;
            if($amount == '' || $amount == null){
                return back()->with('danger', 'Не указана сумма!');
            }

            if($action == 'add_bal'){
                $total_add_sum = self::addDepositTransaction($request, $company);
                return back()->with('success', 'Депозит компании "'.$company->name.'" пополнен на '.$total_add_sum.' грн.');
            }elseif($action == 'remove_bal'){
                $total_add_sum = self::removeDepositTransaction($request, $company);
                return back()->with('success', 'Депозит компании "'.$company->name.'" снижен на '.$total_add_sum.' грн.');
            }
        }elseif($action == 'add_ab'){

            $next_date = self::addAbonimentTransaction($request, $company);

            return back()->with('success', 'Абонплата компании "'.$company->name.'" продлена до '.$next_date.'.');
        }else{
            abort('404');
        }
        dd($request->all());

    }

    private function addDepositTransaction(Request $request, $company){
        $time = date('Y-m-d H:i:s', time());

        $data = [
            'action' => 'moder_create',
            'moder_name' => Auth::user()->getFullName()
        ];

        DB::table('transactions')->insertGetId(
            [
                'company_id' => $company->id,
                'type_dk' => '1',
                'type_transaction' => '0',
                'total_sum' => $request->amount,
                'created_at' => $time,
                'data' => json_encode($data)
            ]
        );

        SF::recalculationBalanceCompany($company->id);//перерасчет баланса
        SF::checkCompanyBalance($company->id);//блокировка или разблокировка баланса
        self::comboFunctionsProductsSpetial($company->id);

        return $request->amount;
    }

    private function removeDepositTransaction(Request $request, $company){
        $time = date('Y-m-d H:i:s', time());

        $data = [
            'action' => 'moder_create',
            'moder_name' => Auth::user()->getFullName()
        ];

        DB::table('transactions')->insertGetId(
            [
                'company_id' => $company->id,
                'type_dk' => '0',
                'type_transaction' => '5',
                'total_sum' => $request->amount,
                'created_at' => $time,
                'data' => json_encode($data)
            ]
        );

        SF::recalculationBalanceCompany($company->id);//перерасчет баланса
        SF::checkCompanyBalance($company->id);//блокировка или разблокировка баланса
        self::comboFunctionsProductsSpetial($company->id);

        return $request->amount;
    }

    private function addAbonimentTransaction(Request $request, $company){
        $tariff = TariffAboniment::find($request->tarif_id);
        $time = date('Y-m-d H:i:s', time());

        $data = [
            'action' => 'moder_create',
            'moder_name' => Auth::user()->getFullName()
        ];

        DB::table('transactions')->insertGetId(
            [
                'company_id' => $company->id,
                'type_dk' => '1',
                'type_transaction' => '3',
                'total_sum' => $tariff->amount,
                'created_at' => $time,
                'data_ab' => $tariff->count_d,
                'data' => json_encode($data)
            ]
        );

        $next_date = self::addAbonimentToCompany($company->id, $tariff->count_d);
        self::comboFunctionsProductsSpetial($company->id);

        return $next_date;
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

        $company->ab_to = $next_date;
        $company->block_ab = '0';
        if($company->block_new == '1'){
            $company->block_new = '0';
        }
        $company->save();

        return $next_date;
    }

    private function comboFunctionsProductsSpetial($company_id){
        $flag = SF::checkCompanyToBlockProductsSpetial($company_id);
        $resault = SF::changeProductsSpetialStatus($company_id, $flag);

        return $resault;
    }
}

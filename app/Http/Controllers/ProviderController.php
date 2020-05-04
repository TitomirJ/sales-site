<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Company;
use App\Subcategory;
use App\Category;
use Illuminate\Support\Facades\Auth;
use App\Test;
use App\Order;
use App\Product;

class ProviderController extends Controller
{
    public function showCompany(Request $request){

        $company_id = Auth::user()->company_id;
       // $company = Company::find($company_id);
        $products = Product::where('company_id', $company_id)->get();
        $base_from = '2018-07-12 12:10:03';
        $base_to = date('Y-m-d' . ' 23:59:59', time());
        $range_date = $base_from.' - '.$base_to;

        if($request->ajax()){
            return self::searchBrife($company_id, $request->date);
        }else{
            $from = $base_from;
            $to = $base_to;
        }

        $company_users = User::where('company_id', $company_id)->get();
        $array = [0,0,0,0,0];
        $orders = Order::where('company_id', $company_id)->whereBetween('created_at', [$from, $to])->get();

        foreach ($orders as $order){
            if($order->marketplace_id == '1'){
                $array[0] = $array[0]+1;
            }elseif($order->marketplace_id == '2'){
                $array[1] = $array[1]+1;
            }elseif($order->marketplace_id == '4'){
                $array[2] = $array[2]+1;
            }elseif($order->marketplace_id == '6'){
                $array[3] = $array[3]+1;
            }elseif($order->marketplace_id == '7'){
                $array[4] = $array[4]+1;
            }
        }

        $count_orders = 0;
        $count_new_orders = 0;
        $sum_ended_orders = 0;
        $count_ended_orders = 0;
        $count_deleted_orders = 0;
        foreach ($orders as $order){
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
        $market_json = json_encode($array ,true);
        $poducts_info_array = self::calculationStatusesProducts($products);

        return view('provider.company.brief.companyIndex', compact('company_users',  'count_orders', 'market_json', 'count_new_orders', 'count_ended_orders','sum_ended_orders', 'count_deleted_orders', 'from', 'to', 'poducts_info_array'))->withTitle('Сводка');
    }

    private function calculationStatusesProducts($products){
        $array = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];
        foreach ($products as $product){
            if($product->status_moderation == '0'){
                $array[0]++;
            }
            if($product->status_moderation == '1' && $product->status_available == '1' && $product->status_spacial == '1'){
                $array[1]++;
            }
            if($product->status_moderation == '2'){
                $array[2]++;
            }
            if($product->status_moderation == '3'){
                $array[5]++;
            }
            if($product->status_available == '1'){
                $array[3]++;
            }
            if($product->status_available == '0'){
                $array[4]++;
            }
        }

        return $array;
    }

    private function searchBrife($company_id, $dates){

        $date_array = explode(' - ', $dates);
        $from = date('Y-m-d' . ' 00:00:00', strtotime($date_array[0]));
        $to = date('Y-m-d' . ' 23:59:59', strtotime($date_array[1]));

        $orders = Order::where('company_id', $company_id)->whereBetween('created_at', [$from, $to])->get();
        $company_users = User::where('company_id', $company_id)->get();
        $array = [];
        $count_orders = 0;
        $count_new_orders = 0;
        $count_ended_orders = 0;
        $sum_ended_orders = 0;
        $count_deleted_orders = 0;
        foreach ($orders as $order){
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

        $array_pie = [0,0,0,0];
        foreach ($orders as $order){
            if($order->marketplace_id == '1'){
                $array_pie[0] = $array_pie[0]+1;
            }elseif($order->marketplace_id == '2'){
                $array_pie[1] = $array_pie[1]+1;
            }elseif($order->marketplace_id == '8'){
                $array_pie[2] = $array_pie[2]+1;
            }elseif($order->marketplace_id == '6'){
                $array_pie[3] = $array_pie[3]+1;
            }
        }
        $market_json = json_encode($array_pie ,true);
        $render_string_pie_chart = view('provider.company.brief.layouts.pieChart', compact('market_json'))->render();
        $render_string_static_block = view('provider.company.brief.layouts.statisticBlock', compact('count_new_orders', 'count_ended_orders', 'count_deleted_orders'))->render();
        $render_string_personnel_block = view('provider.company.brief.layouts.personnelBlock', compact('company_users', 'from', 'to'))->render();

        $array[0] = $count_orders;
        $array[1] = $sum_ended_orders;
        $array[2] = $count_deleted_orders;
        $array[3] = $render_string_pie_chart;
        $array[4] = $render_string_static_block;
        $array[5] = $render_string_personnel_block;
        return $array;
    }

    public function companyBlocked(Request $request){
        Auth::logout();
        return  view('provider.company.blocked.index');
    }

    public function showJivoSite(){
        if(session('jivosite')){
            Session::forget('jivosite');
        }else{
            Session::put('jivosite', 'default');
        }

        return back();
    }

    public function showPersonnelCompany(Request $request){

        $user_id = $request->user()->id;

        if(Auth::check()){
            if(Auth::user()->id == $user_id){
                $company_id = Auth::user()->company_id;
                $company = Company::find($company_id);
                $personnel = $company->users;
                return view('provider.company.companyPersonnel', compact('personnel'));

            }else{
                return back()->with('danger', 'В доступе отказано!');
            }

        }else{
            return redirect()->route('login');
        }

    }
}

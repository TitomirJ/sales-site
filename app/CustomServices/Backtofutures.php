<?php

namespace App\CustomServices;

use App\Company;
use App\Product;
use App\Auddown;

class Backtofutures
{
      public function aud_rollback()
      {
          /**
         * определяется для каких компаний делать скрин состояния 
         * инфо на продукты.
         */
        $companise_aud = Company::where('update_auto','!=',NULL)->get();

        // $cid = 59;
        // $companise_aud = Company::where('id',$cid)->get();// для проверки работы скрипта
   
        /**
         * найденные продукты компании записать 
         * в таблицу для бэкапа автообновления, чтобы возможно 
         * было сделать откат на сутки назад после обновления 
         */
        foreach($companise_aud as $compani){
            $total_arr = [];
            $products = Product::select('id','price','old_price','status_available')->where('company_id',$compani->id)->get();
            if(count($products) > 0){
                $r = Auddown::where('dcompany_id',$compani->id)->delete();
                \Log::info('удалено из таблицы для бэкапа '.$r.' товаров у компании с id:'.$compani->id);
            }
            foreach($products as $item){
                $p = [
                    'dcompany_id'=>$compani->id,
                    'dproduct_id'=>$item->id,
                    'dprice'=>$item->price,
                    'dold_price'=>$item->old_price,
                    'dstatus_available'=>$item->status_available,
                    ];
                    array_push($total_arr,$p);
            }
           
            //\Log::info(count($products).' company:'.$compani);
            $pic = Auddown::insert($total_arr);
            if($pic){
                \Log::info('состояние зафиксировано в таблице успешно '.count($products).' товаров у компании :'.$compani->id);
            }else{
                \Log::info('ошибка! при записи в таблицу для бэкапа у компании :'.$compani->id);
            }
           
        }
      }
    
    
}
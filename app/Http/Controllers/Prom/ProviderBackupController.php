<?php

namespace App\Http\Controllers\Prom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Auddown;
use App\Product;
use Carbon\Carbon;

class ProviderBackupController extends Controller
{
    public function audbackup(Request $request)
    {

        $company_id = \Auth::user()->company_id;
		
		if(self::isWorkedBackup()){

        if(isset($request->comp) && is_numeric($request->comp) && $company_id == $request->comp){
            $count_prod = 0;
            $products_screen = Auddown::where('dcompany_id',$company_id)->get();

            foreach($products_screen as $item){
                $product_in_bd = Product::find($item->dproduct_id);

                //echo $product_in_bd->price.'=price real '.$item->dprice.'=screen price<br>';
                if($product_in_bd){
                    $product_in_bd->price = $item->dprice;
                    $product_in_bd->old_price = $item->dold_price;
                    $product_in_bd->status_available = $item->dstatus_available;
                    //TO DO включить на продакшене запись!!!!
                    $product_in_bd->save();
                    $count_prod++;

                }else{
                    \Log::info('при бэкапе компании:'.$company_id.' не найден товар с id:'.$item->dproduct_id);
                }

            }//end foreach
            return back()->with('success','изменено товаров: '.$count_prod);

        }else{
            \Log::info('ATTENTION!!!!HACKING!!!:подмена данных:компания-'.$company_id.' id в форме:'.$request->comp);
             return back();
    }
			}else{
            \Log::info('использование бэкапа с 20-25 до 03-00 ч. компания:'.$company_id);
            return back()->with('danger','бэкап работает с 03-00 до 20-00');
            //dd($date_work_btn.'not wok');
        }
}
	
	public static function isWorkedBackup()
{
    /**
         * время определяется для того чтобы
         * кнопка бэкапа не работала в промежуток 
         * заданный в date_open и date_close
         */
        $date_work_btn = Carbon::now();
        $date_open = Carbon::createFromTime('03', '0', '0', 'Europe/Kiev');
        $date_close = Carbon::createFromTime('20', '25', '0', 'Europe/Kiev');
        if($date_work_btn > $date_open && $date_work_btn < $date_close){
            return true;
        }else{
            return false;
        }
}
	
	
}
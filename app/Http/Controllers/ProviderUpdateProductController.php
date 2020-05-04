<?php

namespace App\Http\Controllers;

use App\Product;
use App\Company;
use App\ExternalProduct;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Models\ApiModule\ModuleJobs;

class ProviderUpdateProductController extends Controller
{


    /* Страница обновления товаров */
    public function index(Request $request){
        $company = Company::find(\Auth::user()->company_id);
        $company->load('externalProduct');

        return view('provider.company.product.external.index', compact('company'))->withTitle('Обновление товаров');
    }

    public function store(Request $request){

        $company_id = \Auth::user()->company_id;

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return json_encode([
                'status' => 'validation',
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $checkFile = self::checkExcelFile($request);

        if(!$checkFile['status']){
            return json_encode([
                'status' => 'error',
                'msg' => 'Неправильная структура таблицы!'
            ]);
        }
		 /**
          * отработка при режиме логистера включенного
          * те товары которых нет в файле обновления переводятся в: -нет в наличии-
          * а те кто есть - перезаписываются с новой инфо
          * можно вывести отдельно в метод, но сейчас внутри сужествующего метода
          */

         if($request->logistor == 'on'){
             /**
              * обнуление наличия у всех товаров компании
              */
             $products_old = self::logister($company_id);

             if($products_old <=0){
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Ошибка сервера!'
                ]);
             }

         /**
          * перезапись значений в БД из файла обновления товаров компании
          *
          */

          //получает данные из xlsx файла
         $rows = Excel::load($request->file, function($reader) {
            $reader->all();
        })->get();
        $numloop = 0;
        $notreal = 0;
         foreach($rows as $key){


                $code = $company_id.'-'.$key->vendor;

                $itemstest = Product::where('code',$code)->get();

                    if(count($itemstest) > 0){
						if( ($key->old_price) > 0 && ($key->price) > ($key->old_price ) ){
						 return json_encode([
                    'status' => 'error',
                    'msg' => 'Old Price меньше Price!'
                ]);
						}

                foreach($itemstest as $item){

                    //$item->price = $key->price;
                    //$item->old_price = $key->old_price;
	
			if(($key->price) > 0 && ($key->price < $key->old_price) ){
                       $item->price = $key->price;						
                   }elseif( ($key->old_price) <= 0 && ($key->price) > 0){
                    $item->price = $key->price;
                   }
					 
                   if($key->old_price > 0){
                       $item->old_price = $key->old_price;
                   }else{
					   $item->old_price = null;
				   }
					
                    if($key->available > 0){
                        $item->status_available = '1';
                    }else{
                        $item->status_available = '0';
                    }
                    $item->save();
                }

           $numloop++;
        }else{
            $notreal++;
        }

        }

        return json_encode([
            'logister' => 'logister',
            'status' => 'success',
            'msg' => 'Обновлено товаров: '.$numloop.' из'.count($rows),
            'countnew' => $numloop,
            'notreal' => $notreal
        ]);
    }

    //-----------end logister work------------------

        $external_product = ExternalProduct::where('company_id', $company_id)->first();

        if($external_product){
            if($external_product->status == '2'){
                // создание файла
                $input_file_path = self::uploadFile(Input::file('file'));
                // удаление старого файла
                $delete_file_path = json_decode($external_product->file_path);
                unlink(public_path($delete_file_path->file_path));

                $update_ext_product = ExternalProduct::find($external_product->id);
                $update_ext_product->company_id = $company_id;
                $update_ext_product->file_path = json_encode($input_file_path);
                $update_ext_product->count_products = $checkFile['count_rows'];
                $update_ext_product->count_updated = 0;
                $update_ext_product->count_notfound = 0;
                $update_ext_product->step = 0;
                $update_ext_product->status = '0';
                $update_ext_product->save();

                $externalProduct = $update_ext_product;

                // метод для создания задачи на обновление товаров на АПИ сарвере
                $response_from_api_server = ModuleJobs::createJobForUpdateProductsFromExcel($externalProduct, 'M', 0);
                return json_encode([
                    'status' => 'success',
                    'msg' => 'Файл загружен и взят в разработку, обновление данных будет выполнено в течение суток.',
                    'render' => view('provider.company.product.external.layouts.statistic', compact('externalProduct'))->render(),
                    'job_status' => $response_from_api_server
                ]);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Нельзя обновить продукты пока ранее загруженый файл в процесе работы!'
                ]);
            }
        }else{
            $input_file_path = self::uploadFile(Input::file('file'));

            $create_ext_product = ExternalProduct::create([
                'company_id' => $company_id,
                'file_path' => json_encode($input_file_path),
                'count_products' => $checkFile['count_rows'],
                'status' => '0',
                'count_updated' => 0,
                'count_notfound' => 0
            ]);

            $externalProduct = $create_ext_product;

            if($create_ext_product){
                // метод для создания задачи на обновление товаров на АПИ сарвере
                $response_from_api_server = ModuleJobs::createJobForUpdateProductsFromExcel($externalProduct, 'M', 0);

                return json_encode([
                    'status' => 'success',
                    'msg' => 'Файл загружен и взят в разработку, обновление данных будет выполнено в течение суток.',
                    'render' => view('provider.company.product.external.layouts.statistic', compact('externalProduct'))->render(),
                    'job_status' => $response_from_api_server
                ]);
            }else{
                return json_encode([
                    'status' => 'error',
                    'msg' => 'Ошибка сервера!'
                ]);
            }
        }
    }
    // проверка структуры файла
    private function checkExcelFile($request){

        $array_headers = ["vendor","available","price","old_price"];

        $rows = Excel::load($request->file, function($reader) {
            $reader->all();
        })->get();
        $headings =  $rows->getHeading();

        if(count($headings) != 4){
            return [
                'status' => false
            ];
        }

        array_multisort($headings);
        array_multisort($array_headers);

        if( serialize($headings) !== serialize($array_headers)){
            return [
                'status' => false
            ];
        }

        return [
            'status' => true,
            'count_rows' => $rows->count()
        ];
    }
    // загрузка файла на сервер
    private function uploadFile($file){
        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.' . $file->getClientOriginalExtension();
        $path = public_path().'/files/excel/';
        $file->move($path, $resize_name);

        return [
            'file_path' => 'files/excel/'.$resize_name,
            'public_path' => asset('files/excel/'.$resize_name)
        ];
    }
    // удаление старого файла
    private function deleteFile($file_path){
        unlink(public_path($file_path));
    }
    // метод для создания задачи на АПИ сервере для обновления товаров через файл
    private function createJobForUpdateProducts($external_product){

    }

    public function open(){
        $user = \Auth::user();
        $company = Company::find($user->company_id);

        $public_path = public_path('files/excel/test.xlsx');

        $rows = Excel::load($public_path, function($reader) {
            $reader->all();
        })->limit(true, 2)->take(10)->get();
        $headings =  $rows->getHeading();

        $products_array = [];

        foreach ($rows as $row){
            $product_vendor  = (string) $rows[0]->vendor;
            $product = Product::where('company_id', $company->id)->where('code', $company->id.'-'.$product_vendor)->first();
            if($product){
                array_push($products_array, $product);
            }
        }


        dd($products_array );
    }

	 public function logister($company_id)
    {
          return Product::where('company_id',$company_id)->update(array('status_available'=>'0'));

    }
}
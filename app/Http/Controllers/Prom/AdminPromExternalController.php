<?php

namespace App\Http\Controllers\Prom;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\PromExternal;
use App\PromCategory;
use App\PromProduct;

class AdminPromExternalController extends Controller
{
   public function index(){
       $externals = PromExternal::where('is_unload', '0')->paginate(20);
       $externals->load('company');
       $externals->load('promProducts');

       return view('admin.prom.external.index', compact('externals'));
   }

    public function show(Request $request, $id){
       if($request->ajax()){
           $data = [];
           $action = $request->action;
           $external = PromExternal::find($id);
           $data['status'] = 'success';
           if($action == 'parsing'){
               $data['title'] = 'Распарсить ссылку?';
               $data['render'] =  view('admin.prom.external.layouts.modalContent', compact('external', 'action'))->render();
           }elseif($action == 'reparsing'){
               $data['title'] = 'Распарсить ссылку повторно?';
               $data['render'] =  view('admin.prom.external.layouts.modalContent', compact('external', 'action'))->render();
           }

           return json_encode($data);
       }
    }

//    public function action(Request $request, $id){
//        $action = $request->action;
//        if($action == 'parsing'){
//            $external = PromExternal::find($id);
//            $external->is_unload = '2';
//            $external->save();
//
//            return back()->with('success', 'Товары отправлены на добавление!');
//        }elseif($action == 'reparsing'){
//            $external = PromExternal::find($id);
//            $external->is_unload = '2';
//            $external->save();
//
//            return back()->with('success', 'Товары отправлены на обновление!');
//        }
//
//
//
//
//
//
//    }

    public function action(Request $request, $id){
       $action = $request->action;
       if($action == 'parsing'){
           $response_data = self::herokuParsingPromItems($id);
           $response_status = $response_data['status'];
       }elseif($action == 'reparsing'){
           $response_data = self::herokuReParsingPromItems($id);
           $response_status = $response_data['status'];
       }

        if($response_status == 200){
            return back()->with('success', 'YML файл данные подготовлены к обработке!');
        }else{
            return back()->with('danger', $response_data['response']);
        }
    }

    private function herokuParsingPromItems($id){
        $external = PromExternal::find($id);
        $external->is_unload = '2';
        $external->save();

        $data = [];
        $client = new \GuzzleHttp\Client(
                    ['headers' => [
                        'Content-Type' => 'application/json'
                        ]
                    ]
                );
//        try{
//            $response = $client->request('POST', 'https://smart-plus.herokuapp.com/load-yml-ix', [
//                'form_params' => [
//                    'external_id' => $external->id,
//                ]
//            ]);
            $response = $client->request('POST', 'http://smart-pl.tk/load-yml-ix', [
                'form_params' => [
                    'external_id' => $external->id,
                ]
            ]);
//        }catch (Exception $exception){
//            $ex_code = $exception->getCode();
//            $ex_massage = $exception->getMessage();
//
//            $data['status'] = $ex_code;
//            $data['response'] = $ex_massage;
//
//            return $data;
//        }

            //  пример правильного ответа от хероку - array:3 [▼
            //  0 => {#2255 ▼
            //    +"success": true
            //    +"message": "affected_rows_86"
            //    +"last_insert_id": 3225
            //    +"method": "category"
            //  }
            //  1 => {#2257 ▼
            //    +"success": true
            //    +"message": "affected_rows_14"
            //    +"last_insert_id": 14033
            //    +"method": "product"
            //  }
            //  2 => {#2251 ▼
            //    +"table": "external_unloading"
            //    +"success": true
            //    +"msg": "change"
            //  }
            //]
            $response = $response->getBody()->getContents();
            $response_array = json_decode($response);

            $data['status'] = 200;
            $data['response'] = $response_array;

            return $data;
    }

//    private function herokuReParsingPromItems($id){
//        $external = PromExternal::find($id);
//    }

    public function externalCategoriesIndex(Request $request, $id){
       $external = PromExternal::find($id);
       if(isset($request->type)){
           $type = $request->type;
           if($type == 'link'){
               $prom_cats = PromCategory::where('external_id', $external->id)->whereNotNull('subcategory_id')->whereHas('promProducts')->paginate(20)->appends('type', $type);
           }elseif($type == 'nolink'){
               $prom_cats = PromCategory::where('external_id', $external->id)->whereNull('subcategory_id')->whereHas('promProducts')->paginate(20)->appends('type', $type);
           }

           return view('admin.prom.external.show.categories.index', compact('external', 'prom_cats', 'type'));
       }else{
           $prom_cats = PromCategory::where('external_id', $external->id)->whereHas('promProducts')->paginate(20);
       }

       return view('admin.prom.external.show.categories.index', compact('external', 'prom_cats'));
    }

    public function externalProductsIndex(Request $request, $id){
        $external = PromExternal::find($id);

        if(isset($request->type)){
            $type = $request->type;

            if($type == 'all'){
                $products = PromProduct::where('external_id', $external->id)->paginate(20)->appends('type', $type);
            }elseif($type >= 0 && $type <=4){
                $products = PromProduct::where('external_id', $external->id)->where('confirm', strval($type))->paginate(20)->appends('type', $type);
            }else{
                abort(404);
            }

            return view('admin.prom.external.show.products.index', compact('external', 'products', 'type'));
        }else{
            $products = PromProduct::where('external_id', $external->id)->paginate(20);
            return view('admin.prom.external.show.products.index', compact('external', 'products'));
        }

    }
}

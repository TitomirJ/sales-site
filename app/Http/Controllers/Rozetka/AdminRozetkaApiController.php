<?php

namespace App\Http\Controllers\Rozetka;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Functions\RozetkaApi;
use Cache;
use App\Subcategory;
use App\Category;
use App\Parametr;
use App\Value;
use App\ParametrsValue;
use App\SubcategoriesParametr;
use Auth;


class AdminRozetkaApiController extends Controller
{

    public function apiCreateFromRozetka(){

        $subcategories = Subcategory::all();
        return view('admin.subcategory.create.createSubcatFromRozetka', compact('subcategories'));
    }

    // формирование ответа из базы данных и апи розетки по айди категории
    public function apiSearchSubcatRozetka(Request $request){
        if($request->ajax()) {

            $data_rozetka = self::renderCreateRozetkaBlock($request);
            $status_rozetka = $data_rozetka['status'];
            $data_bigsales = self::renderCreateBigSalesBlock($request);
            $status_bigsales = $data_bigsales['status'];

            $data['status'] = 'success';
            $data['render']['rozetka'] = $data_rozetka['render'];
            $data['render']['bigsales'] = $data_bigsales['render'];

            $categories = Category::all();
            $market_id = $request->market_id;

            if($status_rozetka && $status_bigsales){
                $form_type = 'update';
                $data['render']['form'] = view('admin.subcategory.create.layouts.contentFormCreateOrUpdateSubcat', compact('form_type', 'market_id'))->render();
            }elseif(!$status_rozetka && $status_bigsales){
                $form_type = 'noUpdateNotHaveParams';
                $data['render']['form'] = view('admin.subcategory.create.layouts.contentFormCreateOrUpdateSubcat', compact('form_type'))->render();
            }elseif($status_rozetka && !$status_bigsales){
                $rozetka_subcat_name = $data_rozetka['subcategory_name'];
                $form_type = 'createNewWithRozet';
                $data['render']['form'] = view('admin.subcategory.create.layouts.contentFormCreateOrUpdateSubcat', compact('form_type', 'categories', 'market_id', 'rozetka_subcat_name'))->render();
            }elseif(!$status_rozetka && !$status_bigsales){

                $form_type = 'createWithOutRozet';
                $data['render']['form'] = view('admin.subcategory.create.layouts.contentFormCreateOrUpdateSubcat', compact('form_type', 'categories', 'market_id'))->render();
            }



            return json_encode($data);
        }else{
            abort('404');
        }
    }
    private function renderCreateRozetkaBlock(Request $request){
        $response_rezetka_subcat = RozetkaApi::searchSubcatFromRozetka($request->market_id);//категория через апи
        $check_subcat = self::checkRozetkaSubcategory($response_rezetka_subcat);//проверка категории апи

        $data = [];
        if ($check_subcat != false) {
            $status = true;
            $response_rezetka_subcat_params = RozetkaApi::searchSubcatParametrsFromRozetka($request->market_id);// json параметры категории
            $rozet_params = json_decode($response_rezetka_subcat_params->content);

            $data_rozet_params = [];
            foreach ($rozet_params as $params) {
                if (!in_array($params->name, $data_rozet_params)) {
                    array_push($data_rozet_params, $params->name);
                }
            }
            $count_params_rozetka = count($data_rozet_params);
            $count_values_rozetka = count($rozet_params);


            $data['status'] = true;
            $data['render'] = view('admin.subcategory.create.layouts.rozetkaBlockInfo', compact('status', 'response_rezetka_subcat', 'count_params_rozetka', 'count_values_rozetka'))->render();
            $data['subcategory_name'] = $response_rezetka_subcat->content->marketCategorys[0]->name;

            return $data;
        } else {
            $status = false;
            $data['status'] = false;
            $data['render'] = view('admin.subcategory.create.layouts.rozetkaBlockInfo', compact('status'))->render();

            return $data;
        }
    }
    private function checkRozetkaSubcategory($subcategory){
        if((isset($subcategory->success)) ? $subcategory->success : false ){
            if(count($subcategory->content->marketCategorys) > 0){
                return $subcategory->content->marketCategorys[0];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    private function checkRozetkaSubcategoryParametrs($subcategory){
        if((isset($subcategory->success)) ? $subcategory->success : false ){
            if(count($subcategory->content) > 0){
                return $subcategory->content->marketCategorys[0];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    private function renderCreateBigSalesBlock(Request $request){
        $subcategory = Subcategory::withTrashed()->where('market_subcat_id', $request->market_id)->first();
        $data = [];

        if ($subcategory != null){
            $subcategory->load('parametrs.values');
            $status = true;
            $response_bigsales_subcat = $subcategory;

            $count_params_bigsales = $subcategory->parametrs->count();

            $count_values_bigsales = 0;
            foreach ($subcategory->parametrs as $parm){
                foreach ($parm->values as $value){
                    $count_values_bigsales++;
                }
            }

            $data['status'] = true;
            $data['render'] = view('admin.subcategory.create.layouts.bigsalesBlockInfo', compact('status', 'response_bigsales_subcat', 'count_params_bigsales', 'count_values_bigsales'))->render();

            return $data;

        }else{
            $status = false;

            $data['status'] = false;
            $data['render'] = view('admin.subcategory.create.layouts.bigsalesBlockInfo', compact('status'))->render();

            return $data;
        }


        return $subcategory;

    }

    public function showSubcatParams($type, $id){
        $subcategory = Subcategory::withTrashed()->where('market_subcat_id', $id)->first();
        $flag = false;
        if($subcategory != null){
            $flag = true;
            $subcategory->load('parametrs.values');

            $array_check_param = [];
            $array_check_values = [];
            foreach ($subcategory->parametrs as $parametr){
                array_push($array_check_param, $parametr->rozet_id);
                foreach ($parametr->values as $value){
                    array_push($array_check_values, $value->rozet_id);
                }
            }
        }

        if($type == 'rozetka'){

            $response_rezetka_subcat = RozetkaApi::searchSubcatFromRozetka($id);
            $response_rezetka_subcat_params = RozetkaApi::searchSubcatParametrsFromRozetka($id);

            $rozetka_subcat_name = $response_rezetka_subcat->content->marketCategorys[0]->name;
            $rozetka_params_array = json_decode($response_rezetka_subcat_params->content);

            $count = 0;
            $params_array = [];
            foreach ($rozetka_params_array as $params){
                if(!array_key_exists($params->name, $params_array)){
                    $count = 0;
                }
               $params_array[$params->name][$count] = [
                    "id" => $params->id,
                    "name" => $params->name,
                    "attr_type" => $params->attr_type,
                    "value_id" => $params->value_id,
                    "value_name" => $params->value_name
                ];
                $count++;
            }

            if($flag){
                return view('admin.subcategory.create.showRozetParams', compact('rozetka_subcat_name', 'params_array', 'array_check_param', 'array_check_values'));
            }else{
                return view('admin.subcategory.create.showRozetParams', compact('rozetka_subcat_name', 'params_array'));
            }
        }elseif($type == 'bigsales'){
            return view('admin.subcategory.create.showBigSalesParams', compact('subcategory'));
        }else{
            abort('404');
        }
    }

    public function updateSubcategoryParams(Request $request, $id){
        $response_rezetka_subcat_params = RozetkaApi::searchSubcatParametrsFromRozetka($id);
        $rozet_params = json_decode($response_rezetka_subcat_params->content);

        $subcategory_bigsales = Subcategory::where('market_subcat_id', $id)->first();
        $subcategory_bigsales_id = $subcategory_bigsales->id;


        for ($i=0; $i < count($rozet_params); $i++){
            $parametr = Parametr::firstOrCreate(
                ['rozet_id' => $rozet_params[$i]->id],
                [
                    'rozet_id' => $rozet_params[$i]->id,
                    'name' => $rozet_params[$i]->name,
                    'attr_type' => $rozet_params[$i]->attr_type,
                ]
            );



            SubcategoriesParametr::firstOrCreate(
                [
                    'subcategory_id' => $subcategory_bigsales_id,
                    'parametr_id' => $parametr->id,
                ],
                [
                    'subcategory_id' => $subcategory_bigsales_id,
                    'parametr_id' => $parametr->id,
                ]
            );



            if(($rozet_params[$i]->value_id != null) && ($rozet_params[$i]->value_id != '')){
                $value = Value::firstOrCreate(
                    ['rozet_id' => $rozet_params[$i]->value_id],
                    [
                        'rozet_id' => $rozet_params[$i]->value_id,
                        'name' => $rozet_params[$i]->value_name,
                    ]
                );

                ParametrsValue::firstOrCreate(
                    [
                        'parametr_id' => $parametr->id,
                        'value_id' => $value->id,
                    ],
                    [
                        'parametr_id' => $parametr->id,
                        'value_id' => $value->id,
                    ]
                );

            }


        }

        return back()->with('success', 'Характеристики подкатегории "'.$subcategory_bigsales->name.'", успешно обновлены!');

    }

    public function createSubcategoryWithRozetkaParams(Request $request){
        if($request->method() == 'POST'){

            if($request->user()->id == Auth::user()->id){

                $response_rezetka_subcat_params = RozetkaApi::searchSubcatParametrsFromRozetka($request->market_id);
                $rozet_params = json_decode($response_rezetka_subcat_params->content);

                $subcategory = Subcategory::create([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'market_subcat_id' => $request->market_id,
                    'commission' => $request->commission,
                ]);

                for ($i=0; $i < count($rozet_params); $i++){
                    $parametr = Parametr::firstOrCreate(
                        ['rozet_id' => $rozet_params[$i]->id],
                        [
                            'rozet_id' => $rozet_params[$i]->id,
                            'name' => $rozet_params[$i]->name,
                            'attr_type' => $rozet_params[$i]->attr_type,
                        ]
                    );



                    SubcategoriesParametr::firstOrCreate(
                        [
                            'subcategory_id' => $subcategory->id,
                            'parametr_id' => $parametr->id,
                        ],
                        [
                            'subcategory_id' => $subcategory->id,
                            'parametr_id' => $parametr->id,
                        ]
                    );



                    if(($rozet_params[$i]->value_id != null) && ($rozet_params[$i]->value_id != '')){
                        $value = Value::firstOrCreate(
                            ['rozet_id' => $rozet_params[$i]->value_id],
                            [
                                'rozet_id' => $rozet_params[$i]->value_id,
                                'name' => $rozet_params[$i]->value_name,
                            ]
                        );

                        ParametrsValue::firstOrCreate(
                            [
                                'parametr_id' => $parametr->id,
                                'value_id' => $value->id,
                            ],
                            [
                                'parametr_id' => $parametr->id,
                                'value_id' => $value->id,
                            ]
                        );

                    }
                }

                return redirect('/admin/subcategories')->with('success', 'Подкатегория '.$subcategory->name.' создана, характеристики Розетки обновлены!')->withTitle('Подкатегории товаров');
            }else{
                return redirect('/admin/subcategories')->with('danger', 'В доступе отказано!');
            }

        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }
}

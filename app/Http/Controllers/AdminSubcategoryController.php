<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Subcategory;
use App\Category;
use App\Product;
use App\Parametr;
use App\Value;
use App\ParametrsValue;
use App\SubcategoriesParametr;
use Excel;
use Storage;
use Illuminate\Support\Facades\File;
use DB;

class AdminSubcategoryController extends Controller
{

    public function index()
    {
        $test = Category::where('id', '<', 320)->get();
        $test_array = [];
        foreach ($test as $c){
            array_push($test_array, $c->id);
        }
        $pagination = 20;
        $subcategories_all = Subcategory::all();
        $subcategories = Subcategory::paginate($pagination);
        $subcategories->load('products');
        $subcategories->load('category');
        return view('admin.subcategory.index', compact('subcategories','subcategories_all', 'test_array'))->withTitle('Подкатегории товаров');
    }


    public function create(Request $request)
    {
        $categories = Category::all();
        if(isset($request->category_id)){
            $selected_category_id = $request->category_id;
            return view('admin.subcategory.create', compact('categories', 'selected_category_id'))->withTitle('Создание подкатегории');
        }else{
            return view('admin.subcategory.create', compact('categories'))->withTitle('Создание подкатегории');
        }
    }


    public function store(Request $request)
    {
        if($request->method() == 'POST'){

            if($request->user()->id == Auth::user()->id){

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:170',
                    'commission' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect('admin/subcategories/create')
                        ->with('errorsArray', $validator->getMessageBag()->toArray())
                        ->withInput();
                }else {
                    $subcategory = Subcategory::create([
                        'category_id' => $request->category_id,
                        'name' => $request->name,
                        'market_subcat_id' => $request->market_id,
                        'commission' => $request->commission,
                    ]);
                }

                Session::flash('success', 'Подкатегория '.$subcategory->name.', успешно создана!');

                return redirect('/admin/subcategories')->withTitle('Подкатегории товаров');
            }else{
                return redirect('/admin/subcategories')->with('danger', 'В доступе отказано!');
            }

        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }


    public function show($id)
    {
        $subcategory = Subcategory::withTrashed()->find($id);
        $parametrs = $subcategory->parametrs;
       return view('admin.subcategory.show', compact('subcategory', 'parametrs'))->withTitle('Редактирование подкатегории');
    }

    public function search(Request $request)
    {
        $id = $request->subcategory_id;
        $subcategory = Subcategory::withTrashed()->find($id);
        $parametrs = $subcategory->parametrs;
        return view('admin.subcategory.show', compact('subcategory', 'parametrs'))->withTitle('Редактирование подкатегории');
    }


    public function edit(Request $request, $id)
    {
        $data = [];
        $subcategory = Subcategory::find($id);
        $categories = Category::all();
        $type = $request->type_edit;
        $data['status'] = 'success';
        $data['render'] = view('admin.subcategory.edit', compact('subcategory', 'categories', 'type'))->render();
        return json_encode($data);
    }


    public function update(Request $request, $id)
    {
        $data = [];
        if($request->method() == 'PUT'){

            if($request->user()->id == Auth::user()->id){

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:170',
                    'commission' => 'required',
                ]);

                if ($validator->fails()) {
                    $data['status'] = 'validator';
                    $data['fails'] = $validator->getMessageBag()->toArray();
                    return json_encode($data);
                }else {

                    $subcategory = Subcategory::find($id);
                    $check_subcat_id = $subcategory->category_id;

                    $subcategory->category_id = $request->category_id;
                    $subcategory->name = $request->name;
                    $subcategory->commission = $request->commission;
                    $subcategory->save();

                    if($subcategory->category_id == $check_subcat_id && $request->type_edit == 'true'){
                        $data['status'] = 'success';
                        $data['msg'] = 'Подкатегория '.$subcategory->name.' , успешно изменена!';
                        return json_encode($data);
                    }else{
                        $data['status'] = 'success-with-remove';
                        $data['idSubcat'] = $subcategory->id;
                        $data['msg'] = 'Подкатегория '.$subcategory->name.' , успешно изменена!';
                        return json_encode($data);
                    }

                }
            }else{
                $data['status'] = 'error';
                $data['msg'] = 'В доступе отказано!';
                return json_encode($data);
            }

        }else{
            $data['status'] = 'error';
            $data['msg'] = 'Ошибка сервера!';
            return json_encode($data);
        }
    }

    public function check(Request $request, $id){
        $data = [];
        if($request->ajax()){

            $subcategory = Subcategory::find($id);
            $count_products = $subcategory->products->count();
            $flag = false;
            if($count_products > 0){
                $flag = false;
            }else{
                $flag = true;
            }
            $render = view('admin.subcategory.delete', compact('subcategory', 'count_products', 'flag'))->render();
            $data['status'] = 'success';
            $data['render'] = $render;
            return json_encode($data);
        }else{
            $data['status'] = 'error';
            $data['msg'] = 'Ошибка сервера!';
            return json_encode($data);
        }
    }

    public function destroy(Request $request, $id)
    {
        $data = [];
        if($request->method() == 'DELETE'){

            if($request->user()->id == Auth::user()->id){

                $subcategory = Subcategory::find($id);
                $count_products = $subcategory->products->count();

                if($count_products <= 0){
                    $name_subcategory = $subcategory->name;
                    $subcategory->delete();

                    $data['status'] = 'success';
                    $data['msg'] = 'Подкатегория '.$name_subcategory.' успешно удалена!';
                    $data['subcat_id'] = $id;
                    return json_encode($data);

                }elseif($count_products >=1){

                    $name_subcategory = $subcategory->name;

                    $data['status'] = 'danger';
                    $data['msg'] = 'Подкатегория '.$name_subcategory.', не может быть удалена!';
                    return json_encode($data);
                }

            }else{
                $data['status'] = 'danger';
                $data['msg'] = 'В доступе отказано!';
                return json_encode($data);
            }

        }else{
            $data['status'] = 'danger';
            $data['msg'] = 'Ошибка сервера!';
            return json_encode($data);
        }
    }

    public function updateParamsSubcat(Request $request, $id){

        if ($request->hasFile('excel_file')) {
                // сохранение файла
            $file = $request->file('excel_file');
            $contents = File::get($file->getRealPath());
            $file_type = $file->getClientOriginalExtension();
            $new_file_name = $id.self::generateString().'.'.$file_type;
            $public_path = public_path('excel/'.$new_file_name);
            File::put($public_path, $contents);

            // формирование обьекта параметров подкатегории из полученого файла
            $resault = Excel::load($public_path, function($reader) {
                        $reader->all();
                    })->get();
            $headings =  $resault->getHeading(); //- заголовки

            // удаление файла
            Storage::disk('public_excel')->delete($new_file_name);

            if(self::checkExcelFile($headings)){
                self::createOrUpdateParamsAndValuesFromExcelForSubcategories($resault, $headings, $id);
                return redirect('admin/search/subcategory?subcategory_id='.$id)->with('success', 'Характеристики успешно обновлены!');
            }else{
                return back()->with('danger', 'Файл не подходит по структуре!');
            }
        } else {
            return back()->with('danger', 'Файл не выбран!');
        }
    }
    private function checkExcelFile($headings){
        $flag = true;
        $rule_headings_array = ["id_parametra", "nazvanie_parametra", "tip_parametra", "id_znacheniya", "nazvanie_znacheniya"];
        foreach ($headings as $heading){
            if(!in_array($heading, $rule_headings_array)){
                $flag = false;
            }
        }

        return $flag;
    }
    private function createOrUpdateParamsAndValuesFromExcelForSubcategories($params, $headings, $subcategory_id){
        foreach($params as $param){

            $parametr = Parametr::firstOrCreate(
                ['rozet_id' => $param->$headings[0]],
                [
                    'rozet_id' => $param->$headings[0],
                    'name' => $param->$headings[1],
                    'attr_type' => $param->$headings[2],
                ]
            );

            SubcategoriesParametr::firstOrCreate(
                [
                    'subcategory_id' => $subcategory_id,
                    'parametr_id' => $parametr->id,
                ],
                [
                    'subcategory_id' => $subcategory_id,
                    'parametr_id' => $parametr->id,
                ]
            );

            if(($param->$headings[3] != 'N/D') && ($param->$headings[3] != '')){
                $value = Value::firstOrCreate(
                    ['rozet_id' => $param->$headings[3]],
                    [
                        'rozet_id' => $param->$headings[3],
                        'name' => $param->$headings[4],
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
        };

    }
    private function generateString($length = 4){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }

        return $string;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Subcategory;
use App\Category;
use App\Product;
use App\Theme;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{

    public function index()
    {
        $test_subcat = Subcategory::where('id', '<', 320)->get();
        $test_array = [];
        foreach ($test_subcat as $s){
            array_push($test_array, $s->id);
        }
        $pagination = 40;
        $categories_all = Category::all();
        $categories = Category::paginate($pagination);
        //$categories->load('products');
        //$categories->load('themes');
        return view('admin.category.index', compact('categories', 'categories_all', 'test_array'))->withTitle('Категории товаров');
    }


    public function create(Request $request)
    {
        $themes = Theme::all();
        $data = [];
        if($request->theme_id != 'null'){
            $selected_theme_id = $request->theme_id;
            $data['status'] = 'success';
            $data['render'] = view('admin.category.create', compact('themes', 'selected_theme_id'))->render();
            return json_encode($data);
        }else{
            $data['status'] = 'success';
            $data['render'] = view('admin.category.create', compact('themes'))->render();
            return json_encode($data);
        }

    }


    public function store(Request $request)
    {

       $data = [];
        if($request->method() == 'POST'){

            if($request->user()->id == Auth::user()->id){

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:140',
                    'commission' => 'required',
                ]);

                if ($validator->fails()) {
                    $data['status'] = 'validator';
                    $data['fails'] = $validator->getMessageBag()->toArray();
                    return json_encode($data);
                }else {
                    $category = Category::create([
                        'name' => $request->name,
                        'commission' => $request->commission,
                    ]);

                    $theme_id = $request->theme_id;
                    $category_id = $category->id;

                    DB::insert('insert into categories_themes (category_id, theme_id) values (?, ?)', [$category_id, $theme_id]);

                    $data['status'] = 'success';
                    $data['msg'] = 'Категория , успешно создана';
                    return json_encode($data);
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


    public function show($id)
    {
        $pagination = 20;
        $category = Category::find($id);
        $subcategories_all = Subcategory::where('category_id', $id)->get();
        $subcategories = Subcategory::where('category_id', $id)->paginate($pagination);
        $subcategories->load('products');
        $subcategories->load('category');
        return view('admin.category.show', compact('subcategories', 'category', 'subcategories_all'))->withTitle($category->name);
    }

    public function search(Request $request)
    {
        $id = $request->category_id;
        $pagination = 20;
        $category = Category::find($id);
        $subcategories_all = Subcategory::where('category_id', $id)->orderBy('name', 'asc')->get();
        $subcategories = Subcategory::where('category_id', $id)->paginate($pagination)->appends('category_id', $id);
        $subcategories->load('products');
        $subcategories->load('category');
        return view('admin.category.show', compact('subcategories', 'category', 'subcategories_all'))->withTitle($category->name);
    }


    public function edit($id)
    {
        $themes = Theme::all();
        $category = Category::find($id);
        $data = [];
        $data['status'] = 'success';
        $data['render'] = view('admin.category.edit', compact('category', 'themes'))->render();

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

                    $category = Category::find($id);

                    $category->name = $request->name;
                    $category->commission = $request->commission;
                    $category->save();

                    if($category->subcategories->count() > 0 && isset($request->group)){
                        $subcategories = Subcategory::where('category_id', $category->id)->get();
                        foreach ($subcategories as $s){
                            $s1 = Subcategory::find($s->id);
                            $s1->commission = $category->commission;
                            $s1->save();
                        }

                    }
                    $data['status'] = 'success';
                    $data['msg'] = 'Подкатегория '.$category->name.' , успешно изменена!';
                    return json_encode($data);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->method() == 'DELETE'){

            if($request->user()->id == Auth::user()->id){

                $category = Category::find($id);
                $count_products = $category->products->count();

                if($count_products <= 0){
                    $name_category = $category->name;
                    $category->delete();

                    Session::flash('success', 'Категория '.$name_category.', успешно удалена!');

                    return redirect()->route('categories.index');
                }elseif($count_products >=1){
                    $name_category = $category->name;

                    Session::flash('warning', 'Категория '.$name_category.', не может быть удалена!');

                    return redirect()->route('categories.index');
                }

            }else{
                return redirect()->route('categories.index')->with('danger', 'В доступе отказано!');
            }

        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }

}
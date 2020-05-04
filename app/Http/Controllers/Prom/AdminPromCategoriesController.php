<?php

namespace App\Http\Controllers\Prom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PromCategory;
use App\Subcategory;
use DB;

class AdminPromCategoriesController extends Controller
{
    public function index(){

        $prom_cats = PromCategory::where('subcategory_id', null)->paginate(20);
        $prom_cats->load('external');
         $prom_cats->load('promProducts');

        return view('admin.prom.category.index', compact('prom_cats'));
    }

    public function edit(Request $request, $id){
        if($request->ajax()){
            $data = [];
            $prom_cat = PromCategory::find($id);
            $subcategories = Subcategory::all();
            $data['status'] = 'success';
            $data['title'] = 'Выберите нашу подкатегорию';
            $data['render'] = view('admin.prom.category.layouts.modalContent', compact('prom_cat', 'subcategories'))->render();
            return json_encode($data);
        }
    }

    public function update(Request $request, $id){
        if($request->ajax() && $request->isMethod('put')){
            $data = [];
            $prom_cat = PromCategory::find($id);
            $prom_cat->subcategory_id = $request->subcategory_id;
            $prom_cat->save();

            DB::table('promproducts')
                ->where('market_id', $prom_cat->market_id)
                ->where('external_id', $prom_cat->external_id)
                ->update(['confirm' => '1']);

            $render = view('admin.prom.category.layouts.itemPromCat', compact('prom_cat'))->render();
            $data['status'] = 'success';
            $data['msg'] = 'Привязка успешна!';
            $data['catId'] = $prom_cat->id;
            $data['render'] = $render;

            return json_encode($data);
        }
    }

    public function destroy(Request $request, $id){
        $prom_cat = PromCategory::find($id);
        if($prom_cat->promProducts->count() > 0){
            return back()->with('danger', 'Удалить нельзя, у этой категории есть товары!');
        }
        $prom_cat->delete();

        return back()->with('success', 'Категория успешно удалена!');
    }
}

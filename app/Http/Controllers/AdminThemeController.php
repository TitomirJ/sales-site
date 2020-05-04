<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\Category;
use DB;


class AdminThemeController extends Controller
{
    public function index()
    {
        $count_subcat = self::getArrayThemeCountSubcat();
        $count_products = self::getArrayThemeCountProducts();
        $pagination = 25;
        $themes_all = Theme::orderBy('name', 'asc')->get();
        $themes = Theme::orderBy('name', 'asc')->paginate($pagination);
        $themes->load('categories');

        return view('admin.theme.index', compact('themes', 'count_products', 'count_subcat', 'themes_all'))->withTitle('Родительские категории товаров');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $pagination = 25;
        $theme = Theme::find($id);
        $categories_all = $theme->categories;
        $categories = $theme->categories()->paginate($pagination);
        $categories->load('products');
        $categories->load('subcategories');
        return view('admin.theme.show', compact('categories', 'theme', 'categories_all'))->withTitle($theme->name);
    }

    public function search(Request $request){
        $id = $request->theme_id;
        $pagination = 25;
        $theme = Theme::find($id);
        $categories_all = $theme->categories;
        $categories = $theme->categories()->paginate($pagination)->appends('theme_id', $id);
        $categories->load('products');
        $categories->load('subcategories');
        return view('admin.theme.show', compact('categories', 'theme', 'categories_all'))->withTitle($theme->name);
    }



    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function getArrayThemeCountProducts(){
        $count_products = [];

        //$themes = Theme::all()->load('categories');
		$themes = Theme::all();
        foreach ($themes as $theme){
            $count = 0;
            foreach ($theme->categories as $category){
                //$count+= $category->products->count();
				$count+= DB::table('products')->where('category_id',$category->id)->count();
            }
            $count_products[$theme->id] = $count;
        }

        return  $count_products;
    }

    private function getArrayThemeCountSubcat(){
        $count_subcat = [];

        $themes = Theme::all()->load('categories');
        foreach ($themes as $theme){
            $count = 0;
            foreach ($theme->categories as $category){
                $count+= $category->subcategories->count();
            }
            $count_subcat[$theme->id] = $count;
        }

        return  $count_subcat;
    }
}
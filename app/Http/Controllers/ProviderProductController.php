<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\SearchModels\ProductSearch\ProductSearch;
use Illuminate\Support\Collection;
use App\Product;
use App\Category;
use App\Subcategory;
use App\Parametr;
use App\TreshedImage;
use App\ProductsItem;
use App\Value;
use App\Usetting;
use App\Company;
use DB;
use Illuminate\Support\Facades\Auth;

use App\Autoupdate;

class ProviderProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function usettingTrait(){
        $user = Auth::user();

        $usettings = Usetting::firstOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_1' => 10
            ]
        );

        return $usettings;
    }

    public function indexNew(Request $request)
    {


        $user = Auth::user();

        $usettings = Usetting::firstOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_1' => 10
            ]
        );
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);

        $products = Product::where('company_id', $company_id)->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '1');
        $products->load('orders');

        $products_nomoder = Product::where('company_id', $company_id)->where('status_moderation', '2')->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '2');
        $all_products_nomoder = Product::where('company_id', $company_id)->where('status_moderation', '2')->get();

        $not_av_products = Product::where('company_id', $company_id)->where('status_available', '0')->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '3');
        $not_av_products->load('orders');

        $deleted_products = Product::onlyTrashed()->where('company_id', $company_id)->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '4');
        $deleted_products->load('orders');

        if($request->ajax() && $request->type == 1){
            return view('provider.company.productNew.layouts.allProducts', compact('products', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 2)){
            return view('provider.company.productNew.layouts.recomended', compact('products_nomoder', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 3 || $request->type == 5)){
            return view('provider.company.productNew.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        }elseif($request->ajax() && $request->type == 4){
            return view('provider.company.productNew.layouts.deletedProducts', compact('deleted_products', 'company'))->render();
        }

        $render_products = view('provider.company.productNew.layouts.allProducts', compact('products', 'company'))->render();
        $render_not_av_products = view('provider.company.productNew.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        $render_deleted_products = view('provider.company.productNew.layouts.deletedProducts', compact('deleted_products', 'company'))->render();


        return view('provider.company.productNew.index', compact('render_products', 'render_deleted_products', 'render_not_av_products', 'products_nomoder', 'company', 'all_products_nomoder'))->withTitle('Товары');
    }


    //страница пользователя (товары)
    public function index(Request $request)
    {


        $user = Auth::user();

        $usettings = Usetting::firstOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_1' => 10
            ]
        );
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);

        $bilder_products = Product::withTrashed()->where('company_id', $company_id)->orderBy('created_at', 'desc')->get();
        $bilder_products->load('orders');
        $bilder_products->load('subcategory');

        //вкладка Все товары
        $collection_all_products = collect($bilder_products);
        $all_products = $collection_all_products->filter(function ($value, $key) {
            return $value->deleted_at == null;
        })->all();
            //подготовка селектора поиска по категориям
            $array_subcats = [];
            foreach ($all_products as $product){
                if(!array_key_exists($product->subcategory_id, $array_subcats)){
                    $array_subcats[$product->subcategory_id] = $product->subcategory->name;
                }
            }
        $products = $this->paginateCollection($all_products, $usettings->n_par_1, null, ['path' => '/company/products'])->appends('type', '1');
        $collection_all_products_without_trashed = collect($all_products);

        //вкладка Не прошли модерацию
        $all_products_nomoder = $collection_all_products_without_trashed->filter(function ($value, $key) {
            return $value->status_moderation == '2';
        })->all();
        $products_nomoder = $this->paginateCollection($all_products_nomoder, $usettings->n_par_1, null, ['path' => '/company/products'])->appends('type', '2');

        //вкладка Нет в наличии
        $not_av_products = $collection_all_products_without_trashed->filter(function ($value, $key) {
            return $value->status_available == '0';
        })->all();
        $not_av_products = $this->paginateCollection($not_av_products, $usettings->n_par_1, null, ['path' => '/company/products'])->appends('type', '3');

        //вкладка Удаленные товары
        $deleted_products = $collection_all_products->filter(function ($value, $key) {
            return $value->deleted_at != null;
        })->all();
        $deleted_products = $this->paginateCollection($deleted_products, $usettings->n_par_1, null, ['path' => '/company/products'])->appends('type', '4');


        if($request->ajax() && $request->type == 1){
            return view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 2)){
            return view('provider.company.product.layouts.recomended', compact('products_nomoder', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 3 || $request->type == 5)){
            return view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        }elseif($request->ajax() && $request->type == 4){
            return view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();
        }

        $render_products = view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        $render_not_av_products = view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        $render_deleted_products = view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();


        return view('provider.company.product.indexWithFilter', compact('render_products', 'render_deleted_products', 'render_not_av_products', 'products_nomoder', 'company', 'all_products_nomoder', 'array_subcats'))->withTitle('Товары');
    }

    //test
    public function indexToNew(Request $request)
    {




        $usettings = self::usettingTrait();
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);

        $bilder_products = Product::withTrashed()->where('company_id', $company_id)->orderBy('created_at', 'desc')->get();
        $bilder_products->load('orders');
        $bilder_products->load('subcategory');

        $count_products = [[0,0],[0,0],[0,0],[0,0]];
        //вкладка Все товары
        $collection_all_products = collect($bilder_products);
        $all_products = $collection_all_products->filter(function ($value, $key) {
            return $value->deleted_at == null;
        })->all();

        $count_products[0][0] = count($all_products);
        //подготовка селектора поиска по категориям
        $array_subcats = [];
        foreach ($all_products as $product){
            if(!array_key_exists($product->subcategory_id, $array_subcats)){
                $array_subcats[$product->subcategory_id] = $product->subcategory->name;
            }
        }
        $products = $this->paginateCollection($all_products, $usettings->n_par_1, null, ['path' => '/company/test2/product/index'])->appends('type', '1');
        $count_products[0][1] = count($products);
        $collection_all_products_without_trashed = collect($all_products);

        //вкладка Не прошли модерацию
        $all_products_nomoder = $collection_all_products_without_trashed->filter(function ($value, $key) {
            return $value->status_moderation == '2';
        })->all();
        $count_products[1][0] = count($all_products_nomoder);
        $products_nomoder = $this->paginateCollection($all_products_nomoder, $usettings->n_par_1, null, ['path' => '/company/test2/product/index'])->appends('type', '2');
        $count_products[1][1] = count($products_nomoder);

        //вкладка Нет в наличии
        $not_av_products = $collection_all_products_without_trashed->filter(function ($value, $key) {
            return $value->status_available == '0';
        })->all();
        $count_products[2][0] = count($not_av_products);
        $not_av_products = $this->paginateCollection($not_av_products, $usettings->n_par_1, null, ['path' => '/company/test2/product/index'])->appends('type', '3');
        $count_products[2][1] = count($not_av_products);

        //вкладка Удаленные товары
        $deleted_products = $collection_all_products->filter(function ($value, $key) {
            return $value->deleted_at != null;
        })->all();
        $count_products[3][0] = count($deleted_products);
        $deleted_products = $this->paginateCollection($deleted_products, $usettings->n_par_1, null, ['path' => '/company/test2/product/index'])->appends('type', '4');
        $count_products[3][1] = count($deleted_products);

        if($request->ajax() && $request->type == 1){
            return view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 2)){
            return view('provider.company.product.layouts.recomended', compact('products_nomoder', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 3 || $request->type == 5)){
            return view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        }elseif($request->ajax() && $request->type == 4){
            return view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();
        }

        $render_products = view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        $render_not_av_products = view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        $render_deleted_products = view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();


        return view('provider.company.product.indexToNew', compact('count_products','render_products', 'render_deleted_products', 'render_not_av_products', 'products_nomoder', 'company', 'all_products_nomoder', 'array_subcats'))->withTitle('Товары');
    }

    //Мой самописный пагинатор
    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    //страница пользователя (товары) - до оптимизации
    public function indexOld(Request $request)
    {


        $user = Auth::user();

        $usettings = Usetting::firstOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'user_id' =>  $user->id,
                'n_par_1' => 10
            ]
        );
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);

        $bilder_products = Product::where('company_id', $company_id)->orderBy('created_at', 'desc');
        $all_products = $bilder_products->get();
        $array_subcats = [];
        foreach ($all_products as $product){
            if(!array_key_exists($product->subcategory_id, $array_subcats)){
                $array_subcats[$product->subcategory_id] = $product->subcategory->name;
            }
        }

        $products = $bilder_products->paginate($usettings->n_par_1)->appends('type', '1');
        $products->load('orders');

        $products_nomoder = Product::where('company_id', $company_id)->where('status_moderation', '2')->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '2');
        $all_products_nomoder = Product::where('company_id', $company_id)->where('status_moderation', '2')->get();

        $not_av_products = Product::where('company_id', $company_id)->where('status_available', '0')->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '3');
        $not_av_products->load('orders');

        $deleted_products = Product::onlyTrashed()->where('company_id', $company_id)->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends('type', '4');
        $deleted_products->load('orders');


        if($request->ajax() && $request->type == 1){
            return view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 2)){
            return view('provider.company.product.layouts.recomended', compact('products_nomoder', 'company'))->render();
        }elseif($request->ajax() && ($request->type == 3 || $request->type == 5)){
            return view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        }elseif($request->ajax() && $request->type == 4){
            return view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();
        }

        $render_products = view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
        $render_not_av_products = view('provider.company.product.layouts.notAvailableProducts', compact('not_av_products', 'company'))->render();
        $render_deleted_products = view('provider.company.product.layouts.deletedProducts', compact('deleted_products', 'company'))->render();


        return view('provider.company.product.indexWithFilter', compact('render_products', 'render_deleted_products', 'render_not_av_products', 'products_nomoder', 'company', 'all_products_nomoder', 'array_subcats'))->withTitle('Товары');
    }

    //Фильтр для страницы с товарами
    public function providerProductsFilter(Request $request, $type){
        if($request->ajax()){
            $company = Company::find($request->user()->company_id);
            $company_id = $company->id;

            $user = Auth::user();

            $usettings = Usetting::firstOrCreate(
                [
                    'user_id' =>  $user->id,
                ],
                [
                    'user_id' =>  $user->id,
                    'n_par_1' => 10
                ]
            );

            $default_queries = [['where', 'company_id', '=', $company_id]];
            if($request->type == '1'){//all products
                //$query_request = $request->only('product_id', 'name_like_persent', 'price_like', 'product_subcat_commission_like', 'status_moderation_equally', 'product_dpk_interval_create');
                $query_request = $request->only('type', 'status_moderation_equally', 'subcategory_id', 'name_like_persent', 'code_like_persent', 'price_like');

                $loads  = ['subcategory', 'orders'];
                $collection_products  = ProductSearch::apply($query_request, $loads, $default_queries, (isset($request->status_moderation_equally))?(($request->status_moderation_equally == 'deleted') ? true : false) : false);

                $query_request = array_merge($query_request, ['type' => $type]);
                $products = $this->paginateFilterCompanyProductsAll($collection_products,  $usettings->n_par_1, $type)->appends($query_request);

                return view('provider.company.product.layouts.allProducts', compact('products', 'company'))->render();
            }else{

            }
        }else{
            abort('404');
        }
    }

    public function paginateFilterCompanyProductsAll($items, $perPage = 15, $type, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('company/filter/products/'.$type)]);
    }

    /*AJAX изменение группы товаров*/
    public function productsGroupActions(Request $request){

        $company_id = Auth::user()->company_id;
        if(isset($request->product_id)){
            $products = Product::find($request->product_id);
            foreach ($products as $p){
                if($company_id != $p->company_id){
                    return 'hack';
                }
            }
        }else{
            return 'false';
        }



        if($request->action == 'false'){
            return 'false';
        }elseif ($request->action == 'avail_to_not_avail'){

            return self::groupActionProductsAvail('avail_to_not_avail', $company_id, $request->product_id);
        }elseif ($request->action == 'group_product_from_all_products_delete'){

            return self::groupActionProductsToDeleteOrRestore('group_product_from_all_products_delete', $company_id, $request->product_id);
        }elseif ($request->action == 'group_product_from_all_products_to_market'){

            return self::groupActionAllProductsToMarketplace($company_id, $request->product_id);
        }elseif ($request->action == 'group_product_from_not_avail_products_to_avail'){

            return self::groupActionProductsAvail('group_product_from_not_avail_products_to_avail', $company_id, $request->product_id);
        }elseif ($request->action == 'group_product_from_not_avail_products_delete'){

            return self::groupActionProductsToDeleteOrRestore('group_product_from_not_avail_products_delete', $company_id, $request->product_id);
        }elseif ($request->action == 'group_deleted_product_to_restore'){

            return self::groupActionProductsToDeleteOrRestore('group_deleted_product_to_restore', $company_id, $request->product_id);
        }


    }

    private function groupActionProductsAvail($action, $company_id, $products_id){

        if($action == 'avail_to_not_avail'){
            for ($i=0; $i<count($products_id); $i++){
                $products = Product::where('company_id', $company_id)
                    ->where('id', $products_id[$i])
                    ->update(['status_available' => '0']);
            }
            return "all";
        }elseif($action == 'group_product_from_not_avail_products_to_avail'){
            for ($i=0; $i<count($products_id); $i++){
                $products = Product::where('company_id', $company_id)
                    ->where('id', $products_id[$i])
                    ->update(['status_available' => '1']);
            }
            return "not-avail";
        }

    }

    private function groupActionProductsToDeleteOrRestore($action, $company_id, $products_id){


        if($action == 'group_product_from_all_products_delete'){
            for ($i=0; $i<count($products_id); $i++){
                $products = Product::where('company_id', $company_id)
                    ->where('id', $products_id[$i])
                    ->delete();
            }
            return "all";
        }elseif($action == 'group_product_from_not_avail_products_delete'){
            for ($i=0; $i<count($products_id); $i++){
                $products = Product::where('company_id', $company_id)
                    ->where('id', $products_id[$i])
                    ->delete();
            }
            return "not-avail";
        }elseif($action == 'group_deleted_product_to_restore'){
            for ($i=0; $i<count($products_id); $i++){
                $products = Product::onlyTrashed()->where('company_id', $company_id)
                    ->where('id', $products_id[$i])
                    ->restore();
            }
            return "deleted";
        }
    }

    private function groupActionAllProductsToMarketplace($company_id, $products_id){

        for ($i=0; $i<count($products_id); $i++){
            $product = Product::find($products_id[$i]);
            if($product->company_id == $company_id){
                if($product->status_spacial == '0'){
                    $product->status_spacial = '1';
                    $product->save();
                }
            }
        }
        return "all";
    }
    /*AJAX изменение группы товаров(end)*/

    /*AJAX изменение пагинации пользователя*/
    public function changePaginationOnProductPage(Request $request){
        $pag = $request->pag_set_user;
        $user = Auth::user();
        if(Auth::user()->usetting == null){
            Usetting::create(
                [
                    'user_id' => $user->id,
                    'n_par_1' => $pag
                ]
            );

            return $pag;
        }else{
            $setting = Usetting::find($user->usetting->id);
            $setting->n_par_1 = $pag;
            $setting->save();

            return $pag;
        }
    }

    public function infoRozetParametr(){
        return view('provider.company.companyRozetProductParametrs')->withTitle('Требования для создания товара');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if(Auth::user()->company_id != 42){
//            return view('provider.company.product.technik')->withTitle('Технические работы!');
//        }
        //$categories = Category::orderBy('name', 'asc')->get();
        $subcategories = Subcategory::orderBy('name', 'asc')->get();
        $subcategories->load('category');
        return view('provider.company.product.create', compact('subcategories'))->withTitle('Создание товаров');
    }


    public function test()
    {
        //$categories = Category::orderBy('name', 'asc')->get();
        $subcategories = Subcategory::orderBy('name', 'asc')->get();
        return view('provider.company.product.test', compact('subcategories'))->withTitle('Создание товаров');
    }

    public function store(Request $request)
    {
        //промоцена не может быть больше цены (апрель2020)
       if($request->price_promo > $request->price){
        $request->price_promo = null;
        }
		
		$user = Auth::user();
        $company_id = $user->company->id;

        $your_self_parametrs_array = $request->your_self_parametr['parametr'];
        $default_parametrs_array = $request->default_parametr['parametr'];

        $code = $company_id.'-'.$request->code;
        $st_sp = self::createProductCheckSpetial($company_id);

        $gallery = $request->gallery;
        $galleryArray = explode(",", $gallery);

        $json_array_images = self::uploadImagesToS3Drive($galleryArray);

        $subcategory = Subcategory::find($request->subcategory);

        $product = Product::create([
            'company_id' => $company_id,
            'user_id' =>  Auth::user()->id,
            'category_id' => $subcategory->category_id,
            'subcategory_id' => $request->subcategory,
            'name' => $request->name,
            'desc' => $request->desc,
            'code' => $code,
            'brand' => $request->brand,
            'price' => $request->price,
            'old_price' => (isset($request->old_price)?$request->old_price:null),
			'price_promo' => (isset($request->price_promo)?$request->price_promo:null),
            'gallery' => $json_array_images,
            'video_url' => (isset($request->video)?$request->video:null),
            'status_spacial' => $st_sp
        ]);



        if(($default_parametrs_array == null) && ($your_self_parametrs_array == null)){

        }elseif($your_self_parametrs_array == null){
            self::storeProductItems('default', $product->id, $default_parametrs_array);
        }elseif($default_parametrs_array == null){
            self::storeProductItems('your_self', $product->id, $your_self_parametrs_array);
        }elseif(($default_parametrs_array != null) && ($your_self_parametrs_array != null)){
            self::storeProductItems('default', $product->id, $default_parametrs_array);
            self::storeProductItems('your_self', $product->id, $your_self_parametrs_array);
        }


        return redirect('company/products')->with('success', 'Товар '.$product->name.' успешно создан!')->withTitle('Товары');
    }

   public function changeProitTest(){
        $product = Product::find(13051);
        dd($product);
    }

    private function uploadImagesToS3Drive($array){

        $new_array = [];

        for($i=0; $i < count($array); $i++){
            $rest = substr($array[$i], 15);


            $image_public_path = asset($array[$i]);

            $contents = file_get_contents($image_public_path);
            $name = substr($image_public_path, strrpos($image_public_path, '/') + 1);
            $flag = Storage::disk('s3')->put($name, $contents, 'public');


            if($flag){
                $image_url = Storage::disk('s3')->url($name);
                $new_array[$i]['name'] = $rest;
                $new_array[$i]['public_path'] = $image_url;
            }
        }

        return json_encode($new_array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = Product::withTrashed()->find($id);
        if(Auth::user()->company_id == $product->company_id){
            $product_items = ProductsItem::where('product_id', $product->id)->get();
            $images = json_decode($product->gallery);

            return view('provider.company.product.show', compact('product', 'product_items', 'images'))->withTitle('Просмотр товара');
        }else{
            return redirect('/welcome')->with('danger', 'В доступе отказано!')->withTitle('Welcome');
        }
    }

    public function showCloneForm(Request $request, $id)
    {
        $product = Product::withTrashed()->find($id);

        if(Auth::user()->company_id != $product->company_id){
            return back()->with('danger', 'В доступе отказано!');
        }
        //$categories = Category::all();

        $array_image = json_decode($product->gallery);
        $array_dz_images = self::storageCloudFromS3Drive($array_image);

        $image = json_encode($array_dz_images, true);


        if($product->subcategory_id != null){

            $subcategories = Subcategory::where('category_id', $product->category_id)->get();
            $subcategories->load('category');
            $subcategory = Subcategory::find($product->subcategory_id);
            $parametrs = $subcategory->parametrs;

            if($parametrs->count() > 0){
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.clone', compact('product',  'subcategories', 'parametrs', 'product_items', 'image'))->withTitle('Клонирование товара');
                }else{
                    return view('provider.company.product.clone', compact('product',  'subcategories', 'parametrs', 'image'))->withTitle('Клонирование товара');
                }

            }else{
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.clone', compact('product',  'subcategories', 'product_items', 'image'))->withTitle('Клонирование товара');
                }else{
                    return view('provider.company.product.clone', compact('product',  'subcategories', 'image'))->withTitle('Клонирование товара');
                }
            }

        }else{

            if($product->productsItems->count() > 0){
                $product_items = self::renderEditInputs($product->productsItems);
                return view('provider.company.product.clone', compact('product',  'product_items', 'image'))->withTitle('Клонирование товара');
            }else{

                return view('provider.company.product.clone', compact('product',  'image'))->withTitle('Клонирование товара');
            }
        }
    }

    public function clon2(Request $request)
    {
        $product = Product::withTrashed()->find(211);

        if(Auth::user()->company_id != $product->company_id){
            return back()->with('danger', 'В доступе отказано!');
        }
        //$categories = Category::all();

//        $array_image = json_decode($product->gallery);
//        $array_dz_images = self::storageCloudFromS3Drive($array_image);
//
//        $image = json_encode($array_dz_images, true);


        if($product->subcategory_id != null){

            $subcategories = Subcategory::where('category_id', $product->category_id)->get();
            $subcategories->load('category');
            $subcategory = Subcategory::find($product->subcategory_id);
            $parametrs = $subcategory->parametrs;

            if($parametrs->count() > 0){
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.clone2', compact('product',  'subcategories', 'parametrs', 'product_items'))->withTitle('Клонирование товара');
                }else{
                    return view('provider.company.product.clone2', compact('product',  'subcategories', 'parametrs'))->withTitle('Клонирование товара');
                }

            }else{
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.clone2', compact('product',  'subcategories', 'product_items'))->withTitle('Клонирование товара');
                }else{
                    return view('provider.company.product.clone2', compact('product',  'subcategories'))->withTitle('Клонирование товара');
                }
            }

        }else{

            if($product->productsItems->count() > 0){
                $product_items = self::renderEditInputs($product->productsItems);
                return view('provider.company.product.clone2', compact('product',  'product_items'))->withTitle('Клонирование товара');
            }else{

                return view('provider.company.product.clone2', compact('product'))->withTitle('Клонирование товара');
            }
        }
    }

    public function checkEditProduct(Request $request, $id){
        $product = Product::find($id);

        if(Auth::user()->company_id != $product->company_id){
            $data = [
                'status' => 'error'
            ];
            return json_encode($data);
        }

        if($product->status_moderation == '1'){
            $render_string = view('provider.company.product.layouts.layouts.editProductModalStart', compact('product'))->render();
            $data = [
                'status' => 'false',
                'render' => $render_string
            ];
            return json_encode($data);
        }else{
            $data = [
                'status' => 'true'
            ];
            return json_encode($data);
        }
    }

    public function shortUpdateProduct(Request $request, $id){
        $product = Product::find($id);

        if(Auth::user()->company_id != $product->company_id){
            return back()->with('danger', 'В доступе отказано!');
        }

        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->status_remod = '2';
        $product->status_available = (isset($request->status_available)?$request->status_available:'0');

        $product->save();

        return redirect('company/products')->with('success', 'Товар успешно изменен!')->withTitle('Товары');

    }

    public function showShortEditForm($id){
        $product = Product::find($id);
        if(Auth::user()->company_id != $product->company_id){
            $data = [
                'status' => 'error'
            ];
            return json_encode($data);
        }else{
            $render_string_form = view('provider.company.product.layouts.layouts.editProductModalForm', compact('product'))->render();
            $data = [
                'status' => 'true',
                'form' => $render_string_form
            ];

            return json_encode($data);
        }
    }

    public function edit(Request $request, $id)
    {
//        if(Auth::user()->company_id != 42){
//            return view('provider.company.product.technik')->withTitle('Технические работы!');
//        }

        $product = Product::find($id);

        if(Auth::user()->company_id != $product->company_id){
            return back()->with('danger', 'В доступе отказано!');
        }
        //$categories = Category::all();

        $array_image = json_decode($product->gallery);
        $array_dz_images = self::storageCloudFromS3Drive($array_image);

        $image = json_encode($array_dz_images, true);


        if($product->subcategory_id != null){

            $subcategories = Subcategory::all();
            $subcategories->load('category');
            $subcategory = Subcategory::find($product->subcategory_id);
            $parametrs = $subcategory->parametrs;

            if($parametrs->count() > 0){
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.edit', compact('product',  'subcategories', 'parametrs', 'product_items', 'image'))->withTitle('Редактирование товара');
                }else{
                    return view('provider.company.product.edit', compact('product',  'subcategories', 'parametrs', 'image'))->withTitle('Редактирование товара');
                }

            }else{
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.edit', compact('product',  'subcategories', 'product_items', 'image'))->withTitle('Редактирование товара');
                }else{
                    return view('provider.company.product.edit', compact('product',  'subcategories', 'image'))->withTitle('Редактирование товара');
                }
            }

        }else{

            if($product->productsItems->count() > 0){
                $product_items = self::renderEditInputs($product->productsItems);
                return view('provider.company.product.edit', compact('product',  'product_items', 'image'))->withTitle('Редактирование товара');
            }else{

                return view('provider.company.product.edit', compact('product',  'image'))->withTitle('Редактирование товара');
            }
        }
    }

    public function edit2(Request $request)
    {
        $product = Product::find(283);

        if(Auth::user()->company_id != $product->company_id){
            return back()->with('danger', 'В доступе отказано!');
        }
        //$categories = Category::all();

//        $array_image = json_decode($product->gallery);
//        $array_dz_images = self::storageCloudFromS3Drive($array_image);
//
//        $image = json_encode($array_dz_images, true);


        if($product->subcategory_id != null){

            $subcategories = Subcategory::where('category_id', $product->category_id)->get();
            $subcategories->load('category');
            $subcategory = Subcategory::find($product->subcategory_id);
            $parametrs = $subcategory->parametrs;

            if($parametrs->count() > 0){
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.editOld', compact('product',  'subcategories', 'parametrs', 'product_items'))->withTitle('Редактирование товара');
                }else{
                    return view('provider.company.product.editOld', compact('product',  'subcategories', 'parametrs'))->withTitle('Редактирование товара');
                }

            }else{
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('provider.company.product.editOld', compact('product',  'subcategories', 'product_items'))->withTitle('Редактирование товара');
                }else{
                    return view('provider.company.product.editOld', compact('product',  'subcategories'))->withTitle('Редактирование товара');
                }
            }

        }else{

            if($product->productsItems->count() > 0){
                $product_items = self::renderEditInputs($product->productsItems);
                return view('provider.company.product.editOld', compact('product',  'product_items'))->withTitle('Редактирование товара');
            }else{

                return view('provider.company.product.editOld', compact('product'))->withTitle('Редактирование товара');
            }
        }
    }
//    private function storageCloudForGoogleDrive($array_image){
//        $array = [];
//        for ($i=0; $i < count($array_image); $i++) {
//            $filename = $array_image[$i]->name;
//            $dir = '/';
//            $recursive = false; // Get subdirectories also?
//            $contents = collect(Storage::cloud()->listContents($dir, $recursive));
//            $file = $contents
//                ->where('type', '=', 'file')
//                ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
//                ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
//                ->first(); // there can be duplicate file names!
//
//            $new_name = self::renameImagesForGoogleDrive($filename);
//
//            $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
//            $targetFile = public_path("images/uploads/" . $new_name);
//            $flag = file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);
//
//            if($flag){
//                TreshedImage::firstOrCreate(
//                    [
//                        'image_path' => 'images/uploads/'.$new_name
//                    ],
//                    [
//                        'user_id' => Auth::user()->id,
//                        'image_path' => 'images/uploads/'.$new_name,
//                    ]
//                );
//            }
//
//            $array[$i] = [
//                'name' => $new_name,
//                'size' => $file["size"],
//                'url' => asset("images/uploads/" . $new_name)
//            ];
//        }
//
//        return $array;
//    }

    private function storageCloudFromS3Drive($array_image){
        $array = [];
        for ($i=0; $i < count($array_image); $i++) {
            $file_name = $array_image[$i]->name;
            $file_path = $array_image[$i]->public_path;

            $new_name = self::renameImagesForS3Drive($file_name);
            $contents = @file_get_contents($file_path);

            if($contents == false){
                $new_name = self::renameImagesForS3Drive('no_foto.png');
                $contents = @file_get_contents('https://bigsales.pro/images/default/no_foto.png');
            }

            $flag = Storage::disk('public_uploads')->put($new_name, $contents);

            $file_size = round(filesize(public_path('/images/uploads/'.$new_name)));

            if($flag){
                TreshedImage::firstOrCreate(
                    [
                        'image_path' => 'images/uploads/'.$new_name
                    ],
                    [
                        'user_id' => Auth::user()->id,
                        'image_path' => 'images/uploads/'.$new_name,
                    ]
                );
            }

            $array[$i] = [
                'name' => $new_name,
                'size' => $file_size,
                'url' => asset("images/uploads/" . $new_name)
            ];
        }

        return $array;
    }

    private function renameImagesForS3Drive($filename){
        $format_file = stristr($filename, '.');
        $new_name = sha1(date('YmdHis').str_random(30)).$format_file;
        return $new_name;
    }


    private function renderEditInputs($colection){
        $render_string = '';
        foreach ($colection as $item){
            $new_string = self::getEditRenderInputs($item);
            $render_string = $render_string.$new_string;
        }

        return $render_string;
    }

    private function getEditRenderInputs($item){
        $input_jsone = json_decode($item->data);
        $input_type = $input_jsone->attr_type;

        if($input_type == 'ListValues'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $values = $parametr->values;
            $p_value = $input_jsone->values_id;
            $renderView =  view('provider.company.product.renderEditInputs.list', compact('parametr', 'values', 'p_value'))->render();
        }elseif($input_type == 'List'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $values = $parametr->values;
            if(is_array($input_jsone->values_id)){
                $p_value = $input_jsone->values_id;
            }else{
                $p_value[] = $input_jsone->values_id;
            }

            $renderView =  view('provider.company.product.renderEditInputs.listArray', compact('parametr', 'values', 'p_value'))->render();
        }elseif(($input_type == 'CheckBoxGroup') || ($input_type == 'CheckBoxGroupValues') || ($input_type == 'ComboBox')){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $values = $parametr->values;
            $p_value = $input_jsone->values_id[0];
            $renderView =  view('provider.company.product.renderEditInputs.combobox', compact('parametr', 'values', 'p_value'))->render();
        }elseif(($input_type == 'Text') || ($input_type == 'TextArea')){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.textarea', compact('parametr', 'p_value'))->render();
        }elseif($input_type == 'TextInput'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.inputtext', compact('parametr', 'p_value'))->render();
        }elseif($input_type == 'Decimal'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.inputnumd', compact('parametr', 'p_value'))->render();
        }elseif($input_type == 'Integer'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.inputnum', compact('parametr', 'p_value'))->render();
        }elseif($input_type == 'CheckBox'){
            $parametr = Parametr::find($input_jsone->parametr_id);
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.checkbox', compact('parametr', 'p_value'))->render();
        }elseif($input_type == 'your_self'){
            $parametr = $input_jsone->parametr;
            $p_value = $input_jsone->value;
            $renderView =  view('provider.company.product.renderEditInputs.yourSelfInput', compact('parametr', 'p_value'))->render();
        }

        return $renderView;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          if($request->isMethod('PUT')){
			  
			  //промоцена не может быть больше цены (апрель2020)
       			if($request->price_promo > $request->price){
        		$request->price_promo = null;
        		}
			  
              $product = Product::find($id);

              if($product->company_id != Auth::user()->company_id){return redirect('/welcome')->with('danger', 'В доступе отказано!');}

              $your_self_parametrs_array = $request->your_self_parametr['parametr'];
              $default_parametrs_array = $request->default_parametr['parametr'];

              $code = $product->company_id.'-'.$request->code;
              $st_sp = self::createProductCheckSpetial($product->company_id);

              $array_for_deleting_from_s3_drive = json_decode($product->gallery);
              self::deleteImagesFromS3Drive($array_for_deleting_from_s3_drive);

              $gallery = $request->gallery;
              $galleryArray = explode(",", $gallery);
              $json_array_images = self::uploadImagesToS3Drive($galleryArray);

              ProductsItem::where('product_id', $product->id)->delete();

              $subcategory = Subcategory::find($request->subcategory);

              $product->category_id = $subcategory->category_id;
              $product->subcategory_id = $request->subcategory;
              $product->name = $request->name;
              $product->desc = $request->desc;
              $product->code = $code;
              $product->brand = $request->brand;
              $product->price = $request->price;
              $product->old_price = (isset($request->old_price)?$request->old_price:null);
			  $product->price_promo = (isset($request->price_promo)?$request->price_promo:null);
              $product->gallery = $json_array_images;
              $product->video_url = (isset($request->video)?$request->video:null);
              $product->status_spacial = $st_sp;
              $product->status_moderation = '0';
              $product->status_remod = '1';
              $product->save();



              if(($default_parametrs_array == null) && ($your_self_parametrs_array == null)){

              }elseif($your_self_parametrs_array == null){
                  self::storeProductItems('default', $product->id, $default_parametrs_array);
              }elseif($default_parametrs_array == null){
                  self::storeProductItems('your_self', $product->id, $your_self_parametrs_array);
              }elseif(($default_parametrs_array != null) && ($your_self_parametrs_array != null)){
                  self::storeProductItems('default', $product->id, $default_parametrs_array);
                  self::storeProductItems('your_self', $product->id, $your_self_parametrs_array);
              }


              return redirect('company/products')->with('success', 'Товар '.$product->name.' успешно изменен!')->withTitle('Товары');
          }else{
              return back()->with('warning', 'Ошибка сервера!');
          }
    }

    private function deleteImagesFromS3Drive($array){
        for($i=0; $i<count($array);$i++){
            $file_name = $array[$i]->name;

            Storage::disk('s3')->delete($file_name);
        }
    }

    public function deleteProduct(Request $request){
        $user = Auth::user();
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $data = [];
        if($product->company_id == $user->company_id){
            $product->delete();
            $data['status'] = 'success';
            $data['productId'] = $product_id;
        }else{
            $data['status'] = 'error';
        }

        return json_encode($data);
    }

    public function destroy($id)
    {
        //
    }

    public function getSubcategories(Request $request){
        $category_id = $request->category_id;
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return $subcategories->toJson();
    }

    public function getSubcategoryOptions(Request $request){
        $subcategory_id = $request->subcategory_id;
        $subcategory = Subcategory::find($subcategory_id);
        return $subcategory->parametrs->toJson();

    }

    public function getRenderInput(Request $request){
        $parametr_id = $request->parametr_id;
        $parametr = Parametr::find($parametr_id);

        if($parametr->attr_type == 'ListValues'){
            $values = $parametr->values;
            $renderView =  view('provider.company.product.renderInputs.list', compact('parametr', 'values'))->render();
        }elseif($parametr->attr_type == 'List'){
            $values = $parametr->values;
            $renderView =  view('provider.company.product.renderInputs.listArray', compact('parametr', 'values'))->render();
        }elseif(($parametr->attr_type == 'CheckBoxGroup') || ($parametr->attr_type == 'CheckBoxGroupValues') || ($parametr->attr_type == 'ComboBox')){
            $values = $parametr->values;
            $renderView =  view('provider.company.product.renderInputs.combobox', compact('parametr', 'values'))->render();
        }elseif(($parametr->attr_type == 'Text') || ($parametr->attr_type == 'TextArea')){
            $renderView =  view('provider.company.product.renderInputs.textarea', compact('parametr'))->render();
        }elseif($parametr->attr_type == 'TextInput'){
            $renderView =  view('provider.company.product.renderInputs.inputtext', compact('parametr'))->render();
        }elseif($parametr->attr_type == 'Decimal'){
            $renderView =  view('provider.company.product.renderInputs.inputnumd', compact('parametr'))->render();
        }elseif($parametr->attr_type == 'Integer'){
            $renderView =  view('provider.company.product.renderInputs.inputnum', compact('parametr'))->render();
        }elseif($parametr->attr_type == 'CheckBox'){
            $renderView =  view('provider.company.product.renderInputs.checkbox', compact('parametr'))->render();
        }else{
            return 'false';
        }

        return $renderView;
    }

    public function getYourSelfInput(Request $request){
        $rend_key = $request->your_self_key;
        $rend_value = $request->your_self_value;

        $renderView =  view('provider.company.product.renderInputs.yourSelfInput', compact('rend_key', 'rend_value'))->render();

        return $renderView;
    }

    private function uploadImagesToGoogleDrive($array){

        $new_array = [];

        for($i=0; $i < count($array); $i++){
            $rest = substr($array[$i], 15);

            $filename = $rest;
            $filePath = public_path($array[$i]);
            $fileData = File::get($filePath);
            $flag = Storage::cloud()->put($filename, $fileData);

            $new_array[$i]['name'] = $filename;

            if($flag){
                $search_filename = $filename;
                $dir = '/';
                $recursive = false;
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($search_filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($search_filename, PATHINFO_EXTENSION))
                    ->first();

                $new_array[$i]['path_google'] = Storage::cloud()->url($file['path']);
            }
        }

        return json_encode($new_array);
    }

    private function deleteTrashImages($id){
        $all_user_images = TreshedImage::where('user_id', $id)->get();

        foreach ($all_user_images as $image){
            unlink($image->image_path);
            $image->delete();
        }
    }

    public function checkCodeProduct(Request $request){
        $code = Auth::user()->company->id.'-'.$request->product_code;

        $product = Product::where('code', $code)->get();

        if($product->count() != 0){
            if($code == $request->product_id){
                return 'true';
            }else{
                return 'false';
            }
        }else{
            return 'true';
        }

    }

    private function storeProductItems($flag, $product_id, $array_parametrs){
        if($flag == 'default'){
            foreach ($array_parametrs as $key => $value){
                if($key == 'ListValues'){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);
                        $parametr_v = Value::find($p_value);

                        $data = self::createProductsItemData('list', $parametr->attr_type, $parametr->id, $parametr_v->id);

                        self::storeProductsItemTrait($product_id, $parametr->name, $parametr_v->name, $data);
                    }
                }elseif(($key == 'CheckBoxGroup') || ($key == 'CheckBoxGroupValues') || ($key == 'ComboBox')){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);
                        $parametr_v = Value::find($p_value[0]);

                        $data = self::createProductsItemData('combo', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $parametr_v->name, $data);
                    }
                }elseif(($key == 'Text') || ($key == 'TextArea')){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);

                        $data = self::createProductsItemData('other', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $p_value, $data);
                    }
                }elseif($key == 'TextInput'){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);

                        $data = self::createProductsItemData('other', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $p_value, $data);
                    }
                }elseif($key == 'Decimal'){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);

                        $data = self::createProductsItemData('other', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $p_value, $data);
                    }
                }elseif($key == 'Integer'){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);

                        $data = self::createProductsItemData('other', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $p_value, $data);
                    }
                }elseif($key == 'CheckBox'){
                    foreach ($value as $p_key => $p_value){
                        $parametr = Parametr::find($p_key);

                        $data = self::createProductsItemData('other', $parametr->attr_type, $parametr->id, $p_value);

                        self::storeProductsItemTrait($product_id, $parametr->name, $p_value, $data);
                    }
                }elseif($key == 'List') {
                    foreach ($value as $p_key => $p_value) {
                        $parametr = Parametr::find($p_key);
                        $parametr_v = Value::find($p_value);
                        $values_id = [];
                        $data_new = [];
                        foreach ($parametr_v as $v) {
                            array_push($values_id, $v->id);
                            $data_new['values'][] = $v->name;
                            $data_new['values_id'][] = $v->id;
                        }


                        $data = [
                            'attr_type' => 'List',
                            'parametr_id' => $parametr->id,
                            'values_id' => $values_id
                        ];

                        $name_value = $data_new['values'][0];

                        self::storeProductsItemTrait($product_id, $parametr->name, $name_value, json_encode($data), json_encode($data_new));
                    }
                }
            }
        }elseif($flag == 'your_self'){
            foreach ($array_parametrs as $key => $value){
                $data = self::createProductsItemData('your_self', 'your_self', $key, $value);
                self::storeProductsItemTrait($product_id, $key, $value, $data);
            }
        }

    }

    private function createProductsItemData($flag, $attr_type, $parametr_id, $values_id){
        $data = [];
        if($flag == 'list'){
            $data['attr_type'] = $attr_type;
            $data['parametr_id'] = $parametr_id;
            $data['values_id'] = $values_id;
        }elseif($flag == 'combo'){
            $data['attr_type'] = $attr_type;
            $data['parametr_id'] = $parametr_id;
            $data['values_id'] = $values_id;
        }elseif($flag == 'other'){
            $data['attr_type'] = $attr_type;
            $data['parametr_id'] = $parametr_id;
            $data['value'] = $values_id;
        }elseif($flag == 'your_self'){
            $data['attr_type'] = $attr_type;
            $data['parametr'] = $parametr_id;
            $data['value'] = $values_id;
        }

        $resault = json_encode($data);
        return $resault;
    }

    private function storeProductsItemTrait($product_id, $item_name, $item_value, $item_data, $item_data_new=null){

        $products_item = ProductsItem::create([
            'product_id' => $product_id,
            'name' => $item_name,
            'value' => $item_value,
            'data' => $item_data,
            'data_new' => $item_data_new,
        ]);

    }

    public function changeProductStatusAvailable(Request $request, $id){
        $data = [];
        $blog = Product::find($id);
        $p = $blog;
        $company = Company::find($blog->company->id);
        if($blog->status_available == '1'){
            $blog->status_available = '0';
            $blog->save();
            $data['id'] = $id;
            $data['render'] = view('provider.company.product.layouts.layouts.statusProductBlock', compact('p', 'company'))->render();
            $data['status'] = 'no';
            return json_encode($data);
        }else{
            $blog->status_available = '1';
            $blog->save();
            $data['id'] = $id;
            $data['render'] = view('provider.company.product.layouts.layouts.statusProductBlock', compact('p', 'company'))->render();
            $data['status'] = 'ok';
            return json_encode($data);
        }
    }

    private function createProductCheckSpetial($company_id){
        $company = Company::find($company_id);
        if($company->block_bal == '0' && $company->block_new == '0'){
            return '1';
        }else{
            return '0';
        }
    }


    /**
     * страница для ввода пользователем слов для поискового запроса
     * отражает имя продукта и картинку
     * получает id продукта из роута (get - метод)
     * проходит проверка:
     * -на формат id (int),
     * -на совпадение пользователя и товаров принадлежащих его компании
     * чтобы избежать подмены в адресной строке id товара
     */
    public function getitem($id)
    {
        $id_company_user = \Auth::user()->company->id;

        //$id_item = $request->item_id;

        if(!$id_item = (int)$id){

            return redirect()->route('show_company')->with('danger','Неверный формат');
        }

        $item = Product::find($id_item);

      //принадлежность товара к компании пользователя
        if(!$item || $id_company_user !== $item->company_id){
            return redirect()->route('show_company')->with('danger','На чужой корешок не разивай роток!');
        }

          return view('provider.company.product.keywords',compact('item'));


    }

    /**
     * принимает слово введенное в форму (передача аяксом)
     * id продукта.
     *  Задача - записать в БД
     * TO DO на январь 2020г. поле words в таблице Products добавлено вручную без добавления в файл миграции
     * при переносе приложения не забудьте добавить это поле миграцию Products
     * параметры поля = (integer тип-text по умолчанию-null сравнение-utf8mb4_uncode_ci)
     */
    public function addWord(Request $request)
    {
        //валидация пришедшего слова на только буквы
        if(!self::isValidAddWord($request->key_word_user) ){
            return $eror[] ='notformat';
        }
        $words_arr = [];
        $product = Product::find($request->id_item);

        //при отсуствии слов в поле words пришедшее добавить в массив
        if($product->words == null){
            array_push($words_arr,$request->key_word_user);

        }else{
            //существующие слова соединить с пришедшим в массив
            $words_arr =json_decode($product->words,true);
            array_push($words_arr,$request->key_word_user);

        }

            $product->words = json_encode($words_arr);
            $product->save();
            return $words_arr;


    }

    /**
     * удаление слова из массива ключевых слов
     * аяксом приходит слово, через запрос uri получается id продукта
     * из базы находится продукт и сравнивается полученное слово с массивом ключевых которые уже есть
     * возращается ключ искомого слова в масиве и удаляется он, перезапись в БД и ответ редактированный массив
     */
    public function delWord(Request $request)
    {
        //валидация пришедшего слова на только буквы (на случай подмены в коде html)

        if(!self::isValidAddWord($request->word) ){
            return $eror[] ='notformat';
        }

        //через роут определяется id продукта
        $id_product = self::getIdProductfromUri();

        $product = Product::find($id_product);
        $words_arr =json_decode($product->words,true);

        //поиск искомого слова в наборе (внимание с типом!! объект и массив)
        $key = array_search($request->word,$words_arr);

        if($key != false || $key ===0){
           unset($words_arr[$key]);

             $product->words = json_encode($words_arr);
             $product->save();

            return $words_arr;
        }else{

            return $words_arr;
        }


    }

     public function isValidAddWord($word)
    {
       // только буквы и пробел между словами (5 слов лимит)
        $patern = "/^([a-zA-Zа-яА-ЯёЁЇїІіЄєҐґ0-9]{1,}+(\s)?){1,5}$/ui";
        return preg_match($patern,$word);

    }

    public function alldelWord(Request $request)
    {
        $product = Product::find($request->id_item);
        $words_arr =json_decode($product->words,true);
        $words_arr = [];

        $product->words = json_encode($words_arr);
        $product->save();

        return back();

    }

    /**
     * привязывает слова ко всем товарам той же подкатегории
     * к которой принадлежит продукт с которого осуществляется привязка
     * если у товара нет слов то просто добавляются указанные слова пользователем,
     * если же у продукта есть свой набор то добавляется к нему новые слова
     */
    public function subAddWord(Request $request)
    {
        $id_product = self::getIdProductfromUri();
        $product = Product::find($id_product);

        if(self::is_empty_words($product)){
            return back()->with('danger','Нет слов для привязки!');
        }

        $words_arr =json_decode($product->words,true);

        $subcategory_id = $product->subcategory_id;
        $company = $product->company_id;
        $products = Product::where('company_id',$company)->where('subcategory_id',$subcategory_id)->get();

        foreach($products as $item){
           if($item->words == null || $item->words =='[]'){
               $item->words = json_encode($words_arr);

           }else{
               $self_words = json_decode($item->words,true);
               $total_arr = array_merge($words_arr,$self_words);
               $result = array_unique($total_arr);

               $item->words = json_encode($result);
           }
           $item->save();

        }
        return redirect('/company/products')->with('success','Привязка слов выполнена успешно');
    }

    /**
     * определяет параметр id из пути(роут)
     */
    private function getIdProductfromUri()
    {
        $path = $_SERVER['HTTP_REFERER'];
         return $id_product = substr(strrchr($path, "/"), 1);
    }

    /**
     * очищает всю подкатегорию от ключевых слов
     */
    public function clearAllSubCatWords(Request $request)
    {
        $id_product = self::getIdProductfromUri();
        $product = Product::find($id_product);

        $words_arr = [];
        Product::where('company_id',$product->company_id)
                            ->where('subcategory_id',$product->subcategory_id)
                            ->update(['words' => json_encode($words_arr)]);

        return redirect('/company/products')->with('success','Подкатегория очищена успешно');
    }


    /**
     * проверяет есть ли ключевые слова у товара
     */
    private function is_empty_words($product)
    {
        if($product->words == null || $product->words =='[]'){
            return true;
        }else{
            return false;
        }
    }

	 /**
     * февраль 2020г
     * управление режимами автообновления xml файла пользователя
     * включение или выключение
     */
    public function autoUpdateBtn(Request $request)
    {
       $company_id = \Auth::user()->company_id;
       $company_set_autoupdate = Company::find($company_id);
       $setting_autoupdate = $company_set_autoupdate->update_auto;

        //при включении автообновления
       if($request->autoupdate_xml =='on'){

            if($setting_autoupdate == NULL){
                $setting_autoupdate = json_encode(['all','no_exit','']);
                $company_set_autoupdate->update_auto = $setting_autoupdate;
                $company_set_autoupdate->save();


                //dd( json_decode($setting_autoupdate));

            }

            $render_form_autoupdate = view('provider.company.external.autoupdate_form',compact('setting_autoupdate'))->render();

            return $render_form_autoupdate;

            //при выключении автообновления
       }else{

            $company_set_autoupdate->update_auto = NULL;
            $company_set_autoupdate->save();
            return '';
       }

    }


    /**
     * запись в БД настроек для автообновления xml файла
     */
    public function makeSettingAutoupdate(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $url = $request->url_xml;


        /**
         * валидация ссылки и запись данных
         * при успешном прохождении
         */
        if(self::valid_format_url($url)){
            return back()->with('danger','Недопустимые данные');
        }else{

        $flag_public = self::checkPublicPathForFileOrLinkXML($url);

                if($flag_public){

                    if(self::isXMLFileValid($url)){

                        if(isset($request->available_in_file) && isset($request->available_not_file)){

                            //валидация пришедших данных от пользователя
                            $rule_in_file = ['all','price','avai'];
                            $rule_not_file = ['no_exit','to_exit'];

                            if(in_array($request->available_in_file,$rule_in_file,true) && in_array($request->available_not_file,$rule_not_file,true)){

                                $company = Company::find($company_id);
                                $setting_autoupdate = json_decode($company->update_auto);
                                $setting_autoupdate[0] = $request->available_in_file;
                                $setting_autoupdate[1] = $request->available_not_file;
                                /**
                                 * если ссылка на файл(присланная от пользователя) есть в БД в autoupdates
                                 * то найти ее и вернуть id записи, чтобы записать его
                                 * в настройки автообновления
                                 */
                                if($url_xml_in_bd = Autoupdate::where('company_id',$company_id)->where('url_xml',$request->url_xml)->first() ){
                                    $id_url_xml = $url_xml_in_bd->id;
                                }else{
                                    $url_xml_in_bd =  Autoupdate::create([
                                        'url_xml' => $request->url_xml,
                                        'company_id' => $company_id
                                    ]);

                                    $id_url_xml = $url_xml_in_bd->id;
                                }

                                $setting_autoupdate[2] = $id_url_xml;

                                //$setting_autoupdate = [$request->available_in_file,$request->available_not_file,$request->url_xml];

                                $company->update_auto = json_encode($setting_autoupdate);
                                //dd('ok all write im bd');
                                $company->save();

                                return back()->with('success','Настройки сохранены');
                            }else{
                                return back()->with('danger','Данные не соответствуют');
                            }
                        }else{
                            return back()->with('danger','Данные не соответствуют');
                        }
                    }else{

                        return back()->with('danger','Файл не прошел валидацию, XML файл составлен не правильно или ссылка не является XML файлом!');
                    }
                }else{

                    return back()->with('danger','Ссылка на XML файл не доступна, убедитесь что к файлу есть публичный доступ!');
                }

            }


    }


    private function isXMLFileValid($xmlFilename, $version = '1.0', $encoding = 'utf-8')
    {
        $xmlContent = file_get_contents($xmlFilename);
        return self::isXMLContentValid($xmlContent, $version, $encoding);
    }


    private function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
    {
        if (trim($xmlContent) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument($version, $encoding);
        $doc->loadXML($xmlContent);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }

    private function checkPublicPathForFileOrLinkXML($public_path){
        $headers = @get_headers($public_path);
        if (preg_match("|200|", $headers[0])) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * проверка на требуемый формат ссылки, и недопустимость
     * определенных правил для загрузки файла (расширения, наличие тэгов)
     */
    private function valid_format_url($url)
    {

        $url = trim($url);

        if(preg_match('/^http+(s)?/i',$url) !== 1){
            return true;
        }

       $str_ext = substr(strrchr($url, "."), 1);
       $str = substr($str_ext,0,3);

        if( $str !=='xml' ){
            return true;
        }

        $arr_ext_file = ['.php','.com','.cer','.hxt','.htm','.asmx','.soap','.js','.ini','.bat','.cmd','.exe','.vbs','.msi','.jar','.phtml','.access'];

       foreach($arr_ext_file as $item){

            if(stristr($url, $item)){
                    return false;
            }
       }

       $pattern = '/[<>]/';
       if(preg_match($pattern,$url) ==1){
            return true;
       }else{
           return false;
       }
    }

}
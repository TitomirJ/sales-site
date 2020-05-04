<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\SearchModels\ProductSearch\ProductSearch;
use App\SearchModels\ProductSearchBuilder\ProductSearchBuilder;
use App\Company;
use App\Product;
use App\Category;
use App\Subcategory;
use App\Parametr;
use App\TreshedImage;
use App\ProductsItem;
use App\Value;
use App\Usetting;
use App\CompanyWarning;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\ReadConcern;


class ModerationProductsController extends Controller
{
    public function index(Request $request){

        $type_page = (isset($request->type)) ? $request->type : 'moderation';

        if($request->ajax()){

            if(isset($request->filter)){

                $other_queries = [];
                $exeption_request = $request->only('company_id', 'subcategory_id', 'name_like_persent', 'status_remod', 'product_id', 'code_like_persent', 'status_moderation_equally', 'status_available_equally', 'status_spacial_equally');
                $appends = [
                    'type' => $type_page,
                    'filter' => true
                ];
                $appends = array_merge($appends, $exeption_request);

                if ($type_page == 'moderation'){
                    array_push($other_queries, ['where', 'status_moderation', '=', '0']);
                }elseif ($type_page == 'chprice'){
                    array_push($other_queries, ['where', 'status_moderation', '<>', '0'], ['where', 'status_remod', '=', '2']);
                }

                $products_builder = ProductSearchBuilder::apply($exeption_request, $other_queries);
                $products = $products_builder->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends($appends);

                $render_products = view('adminAndModerator.moderation.product.index.blocks.'.$type_page, compact('products'))->render();
                return json_encode(['status' => 'success', 'typePage' => $type_page, 'render' => $render_products]);

            }else{

                if($type_page == 'all'){

                    $products = Product::withTrashed()->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'all']);

                }elseif ($type_page == 'moderation'){

                    $products = Product::where('status_moderation', '0')->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'moderation']);

                }elseif ($type_page == 'chprice'){

                    $products = Product::where('status_moderation', '<>', '0')->where('status_remod', '2')->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'chprice']);

                }else{
                    return json_encode(['status' => 'error', 'msg' => 'Страница не найдена!']);
                }

                $companies = Company::has('products')->orderBy('name', 'asc')->get();
                $subcat = Subcategory::has('products')->orderBy('name', 'asc')->get();
                $render_filter = view('adminAndModerator.moderation.product.index.filters.'.$type_page, compact('companies', 'subcat'))->render();

                $render_products = view('adminAndModerator.moderation.product.index.blocks.'.$type_page, compact('products'))->render();
                return json_encode(['status' => 'success', 'typePage' => $type_page, 'render' => $render_products, 'filter' => $render_filter]);

            }

        }else{
            if($type_page == 'all'){

                $products = Product::withTrashed()->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'all']);

            }elseif ($type_page == 'moderation'){

                $products = Product::where('status_moderation', '0')->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'moderation']);

            }elseif ($type_page == 'chprice'){

                $products = Product::where('status_moderation', '<>', '0')->where('status_remod', '2')->orderBy('created_at', 'desc')->with(['company', 'subcategory', 'category'])->simplePaginate(30)->appends(['type' => 'chprice']);

            }else{
                abort('404');
            }
            $companies = Company::has('products')->orderBy('name', 'asc')->get();
            $subcat = Subcategory::has('products')->orderBy('name', 'asc')->get();

            $render_filter = view('adminAndModerator.moderation.product.index.filters.'.$type_page, compact('companies', 'subcat'))->render();
            $render_products = view('adminAndModerator.moderation.product.index.blocks.'.$type_page, compact('products'))->render();

            return view('adminAndModerator.moderation.product.index.index', compact('render_products', 'render_filter', 'type_page'))->withTitle('Модерация товаров');

        }
    }

    public function index1(Request $request)
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

        if($user->isModerator()){
            $companies_array = [];

            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }

            $bilder_products_all = Product::whereIn('company_id', $companies_array);
            $bilder_products_moder = Product::where('status_moderation', '0')->whereIn('company_id', $companies_array);
            $bilder_products_chprice = Product::where('status_moderation', '<>', '0')->where('status_remod', '2')->whereIn('company_id', $companies_array);

            $all_products_all = $bilder_products_all->get();
            $all_products_all->load('company');
            $all_products_all->load('subcategory');
            $all_products_moder = $bilder_products_moder->get();
            $all_products_moder->load('company');
            $all_products_moder->load('subcategory');
            $all_products_chprice = $bilder_products_chprice->get();
            $all_products_chprice->load('company');
            $all_products_chprice->load('subcategory');

            $products_moder = $bilder_products_moder->paginate($usettings->n_par_1)->appends('type', '1');
            $products_chprice = $bilder_products_chprice->paginate($usettings->n_par_1)->appends('type', '2');
            $products_all = $bilder_products_all->paginate($usettings->n_par_1)->appends('type', '3');

        }else{
            //глобальный запрос по товарам(все)
            $bilder_all_products = Product::onlyTrashed()->orderBy('created_at', 'desc')->get();
            $bilder_all_products->load('company');
            $bilder_all_products->load('subcategory');
            $bilder_all_products->load('category');

            $collection_all_products = collect($bilder_all_products);

            $all_products_all = $collection_all_products->filter(function ($value, $key) {
                return $value->deleted_at == null;
            })->all();

            $all_products_moder = $collection_all_products->filter(function ($value, $key) {
                return $value->status_moderation == '0';
            })->all();

            $all_products_chprice = $collection_all_products->filter(function ($value, $key) {
                return ($value->status_moderation != '0' && $value->status_remod == '2');
            })->all();


            $products_moder = $this->paginateCollection($all_products_moder, $usettings->n_par_1, null, ['path' => '/admin/moderation/products'])->appends('type', '1');
            $products_chprice = $this->paginateCollection($all_products_chprice, $usettings->n_par_1, null, ['path' => '/admin/moderation/products'])->appends('type', '2');
            $products_all = $this->paginateCollection($all_products_all, $usettings->n_par_1, null, ['path' => '/admin/moderation/products'])->appends('type', '3');
        }

        $companies = Company::has('products')->get();
        $companies_all = $companies;//self::arrayCompaniesForSelect2($all_products_all);
        $companies_moder = $companies;//self::arrayCompaniesForSelect2($all_products_moder);
        $companies_chprice = $companies;//self::arrayCompaniesForSelect2($all_products_chprice);

        $subcat_moder = self::arraySubcatForSelect2($all_products_moder);
        $subcat_chprice = self::arraySubcatForSelect2($all_products_chprice);
        $subcat_all = self::arraySubcatForSelect2($all_products_all);

        $render_moder_block = view('adminAndModerator.moderation.product.index.layouts.productsModerBlock', compact('products_moder'));
        $render_chprice_block = view('adminAndModerator.moderation.product.index.layouts.productsChpriceBlock', compact('products_chprice'));
        $render_chprice_all = view('adminAndModerator.moderation.product.index.layouts.productsAllBlock', compact('products_all'));

        if($request->ajax()){
            if($request->type == '1'){
                return $render_moder_block;
            }elseif($request->type == '2'){
                return $render_chprice_block;
            }elseif($request->type == '3'){
                return $render_chprice_all;
            }
        }
        $array_count = [0,0];
        $array_count[0] = $products_moder->count();
        $array_count[1] = $products_chprice->count();

        return view('adminAndModerator.moderation.product.index.index', compact('render_chprice_all', 'render_moder_block', 'render_chprice_block', 'array_count', 'companies_all', 'companies_moder', 'companies_chprice', 'subcat_all', 'subcat_moder', 'subcat_chprice'))
            ->withTitle('Товары на модерации');
        //return view('adminAndModerator.moderation.product.index.index', compact('render_chprice_all', 'render_moder_block', 'render_chprice_block', 'array_count', 'companies_all', 'companies_moder', 'companies_chprice', 'subcat_all', 'subcat_moder', 'subcat_chprice'))->withTitle('Товары на модерации');
    }

    //Мой самописный пагинатор
    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function arrayCompaniesForSelect2($products){
        $array = [];
        foreach ($products as $product){
            if(!array_key_exists($product->company_id, $array)){
                $array[$product->company_id] = $product->company->name;
            }
        }
        return $array;
    }

    private function arraySubcatForSelect2($products){
        $array = [];
        foreach ($products as $product){
            if(!array_key_exists($product->subcategory_id, $array)){
                $array[$product->subcategory_id] = $product->subcategory->name;
            }
        }
        return $array;
    }

    public function filterProductsModaration(Request $request, $type){
        if($request->ajax()){
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

            $other_queries = [];
            $query_loads = ['company', 'subcategory'];
            $exeption_request = $request->only('company_id', 'subcategory_id', 'name_like_persent', 'status_remod', 'product_id', 'code_like_persent', 'status_moderation_equally', 'status_available_equally', 'status_spacial_equally');
            $appends = [
                'type' => $type
            ];
            $appends = array_merge($appends, $exeption_request);

            if($user->isModerator()){
                $companies_array = [];

                foreach ($user->companies as $c){
                    array_push($companies_array, $c->id);
                }

                array_push($other_queries, ['whereIn', 'company_id', null,  $companies_array]);

                if($type == 'moder'){

                    array_push($other_queries, ['where', 'status_moderation', '=', '0']);
                    $products_moder = ProductSearch::apply($exeption_request, $query_loads, $other_queries);
                    $products_moder = $this->paginateSearchModProduct($products_moder, $usettings->n_par_1, $type)
                        ->appends($appends);

                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsModerBlock', compact('products_moder'));
                }elseif($type == 'chprice'){

                    array_push($other_queries, ['where', 'status_moderation', '<>', '0'], ['where', 'status_remod', '=', '2']);
                    $products_chprice = ProductSearch::apply($exeption_request, $query_loads, $other_queries);


                    $products_chprice = $this->paginateSearchModProduct($products_chprice, $usettings->n_par_1, $type)
                        ->appends($appends);

                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsChpriceBlock', compact('products_chprice'));
                }elseif($type == 'all'){
                    $products_all = ProductSearch::apply($exeption_request, $query_loads, $other_queries);

                    $products_all = $this->paginateSearchModProduct($products_all, $usettings->n_par_1, $type)
                        ->appends($appends);

                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsAllBlock', compact('products_all'));
                }
            }else{
                if($type == 'moder'){

                    array_push($other_queries, ['where', 'status_moderation', '=', '0']);
                    $products_moder = ProductSearch::apply($exeption_request, $query_loads, $other_queries);


                    $products_moder = $this->paginateSearchModProduct($products_moder, $usettings->n_par_1, $type)
                        ->appends($appends);

                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsModerBlock', compact('products_moder'));

                }elseif($type == 'chprice'){

                    array_push($other_queries, ['where', 'status_moderation', '<>', '0'], ['where', 'status_remod', '=', '2']);
                    $products_chprice = ProductSearch::apply($exeption_request, $query_loads, $other_queries);


                    $products_chprice = $this->paginateSearchModProduct($products_chprice, $usettings->n_par_1, $type)
                        ->appends($appends);

                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsChpriceBlock', compact('products_chprice'));
                }elseif($type == 'all'){
                    $products_all = ProductSearch::apply($exeption_request, $query_loads, $other_queries);

                    $products_all = $this->paginateSearchModProduct($products_all, $usettings->n_par_1, $type)->appends($appends);


                    $render_block = view('adminAndModerator.moderation.product.index.layouts.productsAllBlock', compact('products_all'));

                }
            }

            return $render_block;
        }else{
            return redirect('admin/moderation/products');
        }
    }

    public function paginateSearchModProduct($items, $perPage = 15, $type, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('admin/moderation/products/'.$type.'/filter')]);
    }

//    private function deleteTrashedImages($user_id){
//        $all_user_images = TreshedImage::where('user_id', $user_id)->get();
//        if($all_user_images->count() > 0){
//            foreach ($all_user_images as $image){
//                unlink($image->image_path);
//                $image->delete();
//            }
//        }
//    }


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
        $user = Auth::user();
        if($user->isModerator()){
            $companies_array = [];
            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }
            $product = Product::withTrashed()->where('id', $id)->first();
            if(!in_array($product->company_id, $companies_array)){
                return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
            }
        }elseif($user->isAdmin()){
            $product = Product::withTrashed()->where('id', $id)->first();
        }else{
            return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
        }
        $product_items = ProductsItem::where('product_id', $product->id)->get();
        $images = json_decode($product->gallery);

        $product->load('company');
        $product->load('subcategory');
        $product->load('productsItems');
        return view('adminAndModerator.moderation.product.show', compact('product', 'product_items', 'images'))->withTitle('Просмотр товара');
    }


    public function edit($id)
    {
        //return view('adminAndModerator.moderation.product.technik');
        $user = Auth::user();


        if($user->isModerator()){
            $companies_array = [];
            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }
            $product = Product::find($id);
            if(!in_array($product->company_id, $companies_array)){
                return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
            }
        }elseif($user->isAdmin()){
            $product = Product::find($id);
        }else{
            return redirect('admin')->with('danger', 'В доступе отказано!')->withTitle('Сводка');
        }

        $array_image = json_decode($product->gallery);
        $array_dz_images = self::storageCloudFromS3Drive($array_image);

        $image = json_encode($array_dz_images, true);


        if($product->subcategory_id != null){

//            $subcategories = Subcategory::where('category_id', $product->category_id)->get();
            $subcategories = Subcategory::all();
            $subcategories->load('category');
            $subcategory = Subcategory::find($product->subcategory_id);
            $parametrs = $subcategory->parametrs;

            if($parametrs->count() > 0){
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('adminAndModerator.moderation.product.edit', compact('product',  'subcategories', 'parametrs', 'product_items', 'image'))->withTitle('Редактирование товара');
                }else{
                    return view('adminAndModerator.moderation.product.edit', compact('product',  'subcategories', 'parametrs', 'image'))->withTitle('Редактирование товара');
                }

            }else{
                if($product->productsItems->count() > 0){
                    $product_items = self::renderEditInputs($product->productsItems);
                    return view('adminAndModerator.moderation.product.edit', compact('product',  'subcategories', 'product_items', 'image'))->withTitle('Редактирование товара');
                }else{
                    return view('adminAndModerator.moderation.product.edit', compact('product',  'subcategories', 'image'))->withTitle('Редактирование товара');
                }
            }

        }else{

            if($product->productsItems->count() > 0){
                $product_items = self::renderEditInputs($product->productsItems);
                return view('adminAndModerator.moderation.product.edit', compact('product',  'product_items', 'image'))->withTitle('Редактирование товара');
            }else{

                return view('adminAndModerator.moderation.product.edit', compact('product',  'image'))->withTitle('Редактирование товара');
            }
        }
    }

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


    public function update(Request $request, $id)
    {

        //dd($request->all());
        if($request->isMethod('PUT')){
			
			//промоцена не может быть больше цены (апрель2020)
            if($request->price_promo > $request->price){
                return back()->with('danger','Промо цена не может быть больше цены!!');
            }
			
            $product = Product::find($id);

            $your_self_parametrs_array = $request->your_self_parametr['parametr'];
            $default_parametrs_array = $request->default_parametr['parametr'];

            $code = $product->company_id.'-'.$request->code;

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
            $product->status_moderation = (isset($request->status_mod)?'1':'0');
            $product->status_remod = '0';

            if(isset($request->status_mod)){
                $product->data_error = '';
            }

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


            return redirect('admin/moderation/products/'.$product->id)->with('success', 'Товар '.$product->name.' успешно изменен!')->withTitle($product->name);
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

    public function getSubcategoryOptions(Request $request){
        $subcategory_id = $request->subcategory_id;
        $subcategory = Subcategory::find($subcategory_id);
        return $subcategory->parametrs->toJson();

    }

    public function destroy($id)
    {
        //
    }


    //методы модерации товаров
        //подтверждение модерации товара
    public function successModerationProduct(Request $request){
        if(!Auth::user()->isAdminOrModerator()){
            return back()->with('danger', 'В доступе отказано!');
        }

        if($request->ajax()){
            $data = [];
            $product_id = $request->product_id;
            $product = Product::find($product_id);

            if($product->status_moderation != '0'){
                $data['status'] = 'error';
                $data['msg'] = 'Товар уже прошел модерацию, в доступе отказано!';
                return json_encode($data);
            }

            $product->status_moderation	= '1';
            $product->status_remod = '0';
            $product->data_error = '';
            $product->save();

            $data['status'] = 'success';
            $data['msg'] = 'Товар успешно прошел модерацию!';
            return json_encode($data);
        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }

        //возвращение товара компании с ошибками
    public function returnProductToCompanyAfterModeration(Request $request){

        if(!Auth::user()->isAdminOrModerator()){
            return back()->with('danger', 'В доступе отказано!');
        }

        if($request->ajax()){

            $data = [];
            $product_id = $request->product_id;
            $product = Product::find($product_id);

//            if($product->status_moderation != '0'){
//                $data['status'] = 'error';
//                $data['msg'] = 'Товар уже прошел модерацию, в доступе отказано!';
//                return json_encode($data);
//            }

            $validator = Validator::make($request->all(), [
                'long_error' => 'required|string|min:5'
            ]);

            if ($validator->fails()) {
                $data['status'] = 'validator';
                $data['fails'] = $validator->getMessageBag()->toArray();
                return json_encode($data);
            }else{
                $data_error = [];
                $data_error['short_error'] = $request->short_error;
                $data_error['long_error'] = $request->long_error;
                $json_data_error = json_encode($data_error);

                $product->status_moderation = '2';
                $product->status_remod = '0';
                $product->data_error = $json_data_error;
                $product->save();

                $data['status'] = 'success';
                $data['msg'] = 'Товар успешно отправлен поставщику на доработку!';
                return json_encode($data);
            }
        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }

        //блокировка товара модератором
    public function blockCompanyProduct(Request $request){

        if(!Auth::user()->isAdminOrModerator()){
            return back()->with('danger', 'В доступе отказано!');
        }

        if($request->ajax()){

            $data = [];
            $product_id = $request->product_id;
            $product = Product::find($product_id);

//            if($product->status_moderation != '0'){
//                $data['status'] = 'error';
//                $data['msg'] = 'Товар уже прошел модерацию, в доступе отказано!';
//                return json_encode($data);
//            }

            $validator = Validator::make($request->all(), [
                'long_error' => 'required|string|min:5'
            ]);

            if ($validator->fails()) {
                $data['status'] = 'validator';
                $data['fails'] = $validator->getMessageBag()->toArray();
                return json_encode($data);
            }else{
                $data_error = [];
                $data_error['short_error'] = $request->short_error;
                $data_error['long_error'] = $request->long_error;
                $json_data_error = json_encode($data_error);

                $product->status_moderation = '3';
                $product->status_remod = '0';
                $product->data_error = $json_data_error;
                $product->save();

                $inspector = Auth::user();
                self::sendProductToAdminForBlockCompany($request->all(), $product->company_id, $inspector->id);

                $data['status'] = 'success';
                $data['msg'] = 'Товар успешно заблокирован и отправлен администратору на рассмотрение!';
                return json_encode($data);
            }
        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }
    }

    private function sendProductToAdminForBlockCompany($request, $company_id, $inspector_id){
        CompanyWarning::updateOrCreate(
            ['type_warning' => '0', 'product_id' => $request['product_id']],
                [
                    'company_id' => $company_id,
                    'inspector_id' => $inspector_id,
                    'type_warning' => '0',
                    'desc_warning' => $request['long_error'],
                    'product_id' => $request['product_id'],
                    'confirm' => '0'
                ]
        );
    }

    public function successCheckPriceProduct(Request $request, $id){
        if($request->ajax()){
            $product = Product::find($id);
            $product->status_remod = '0';
            $product->save();

            return json_encode([
                'status' => 'success',
                'productId' => $product->id,
                'msg' => 'Новая цена товара подверждена!'
            ]);
        }else{
            abort('404');
        }
    }

    public function actionsWithProduct(Request $request, $id, $action){
        if($action == 'change_avail'){
            return self::changeAvailStatusProduct($id);
        }elseif($action == 'actions'){
            $group_action = $request->g_action;
            if($group_action == 'to_avail' || $group_action == 'to_notavail'){
                return self::groupActionAvailProduct($request, $group_action);
            }elseif($group_action == 'chmarket'){
                return self::groupActionChangeMarketProduct($request);
            }

        }
    }

    private function changeAvailStatusProduct($id){
        $data = [];
        $blog = Product::find($id);
        if($blog->status_available == '1'){
            $blog->status_available = '0';
            $blog->save();
            $data['status'] = 'success';
            $data['action'] = 'to_noavail';
            $data['pName'] = $blog->name;
            return json_encode($data);
        }else{
            $blog->status_available = '1';
            $blog->save();
            $data['status'] = 'success';
            $data['action'] = 'to_avail';
            $data['pName'] = $blog->name;
            return json_encode($data);
        }
    }

    private function groupActionAvailProduct(Request $request, $action){
        if(is_array($request->product_id) && count($request->product_id) > 0) {
            if ($action == 'to_avail') {
                Product::whereIn('id', $request->product_id)->update(['status_available' => '1']);
                $data['status'] = 'success';
                $data['action'] = 'to_avail';
                $data['pIds'] = $request->product_id;
            } elseif ($action == 'to_notavail') {
                Product::whereIn('id', $request->product_id)->update(['status_available' => '0']);
                $data['status'] = 'success';
                $data['action'] = 'to_noavail';
                $data['pIds'] = $request->product_id;
            }
        }else{
            $data['status'] = 'fail';
            $data['action'] = $action;
            $data['msg'] = 'Действие не выполнимо, нет выбраных товаров!';
        }
        return json_encode($data);
    }

    private function groupActionChangeMarketProduct(Request $request){

        if(is_array($request->product_id) && count($request->product_id) > 0){
            $company = Company::find($request->company_id);
            Product::whereIn('id', $request->product_id)->update([
                'rozetka_on' => (isset($request->rozetka_on))?'1':'0',
                'prom_on' => (isset($request->prom_on))?'1':'0',
                'zakupka_on' => (isset($request->zakupka_on))?'1':'0'
            ]);
            $data['status'] = 'success';
            $data['action'] = 'chmarket';
            $data['markets'] = [
                'rozetka' => (isset($request->rozetka_on) && $company->rozetka_on == '1') ? true : false,
                'prom' => (isset($request->prom_on) && $company->prom_on == '1') ? true : false,
                'zakupka' => (isset($request->zakupka_on) && $company->zakupka_on == '1') ? true : false
            ];
            $data['pIds'] = $request->product_id;
        }else{
            $data['status'] = 'fail';
            $data['action'] = 'chmarket';
            $data['msg'] = 'Действие не выполнимо, нет выбраных товаров!';
        }
        return json_encode($data);
    }
}
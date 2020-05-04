<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Functions\StaticFunctions as SF;
use App\Functions\RozetkaApi;
use App\Functions\PromApi;
use App\SearchModels\CompanySearch\CompanySearch;
use App\SearchModels\TransactionSearch\TransactionSearch;
use App\SearchModels\ProductSearch\ProductSearch;
use App\SearchModels\OrderSearch\OrderSearch;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use DB;
use Cache;
use App\User;
use App\Subcategory;
use App\SubcategoriesOption;
use App\Parametr;
use App\Value;
use App\Company;
use App\Transaction;
use App\Usetting;
use App\Product;
use App\Order;
use App\TreshedImage;
use App\ProductsItem;
use App\CompanyWarning;
use App\Marketplace;
use App\TariffDeposite;
use App\TariffAboniment;
use App\PromExternal;
use App\PromCategory;
use App\PromProduct;

class AdminCompanyController extends Controller
{
    private function usettingTrait($user){
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

    public function balanceIndex(){

        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        $transactions->load('company');


        return view('admin.balance.index', compact('transactions'));
    }

    public function companiesIndex(Request $request){
//        \DB::listen(function($query){
//            dump($query->sql);
//        });
        $user = Auth::user();
        $pagination = 10;

        if($request->user()->isModerator()){
            $companies_array = [];
            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }
            $collection_company = Company::whereIn('id', $companies_array)->orderBy('created_at', 'desc');
        }else{
            $collection_company = Company::orderBy('created_at', 'desc');
        }


        if(!$request->ajax()){
            $count_companies = $collection_company->count();
            $usettings = self::usettingTrait($user);
            $pagination = $usettings->n_par_1;
        }

        $companies = $collection_company->paginate($pagination);
        $companies->load('products:id,company_id,status_moderation,deleted_at');
        $companies->load('orders:id,company_id,status');
        $companies->load('users:id,company_id');

        if($request->ajax()){
            return view('admin.company.layouts.indexCompany.itemCompany', compact('companies'))->render();
        }

        return view('admin.company.index', compact('companies',  'count_companies'))->withTitle('Компании');
    }

    public function filterCompaniesIndex(Request $request){
        if($request->ajax()){
            $user = Auth::user();
            $usettings = self::usettingTrait($user);

            $query_request = $request->only('name_like_percent', 'company_online', 'responsible_phone_like_percent', 'company_status_block');
            $loads = ['products:id,company_id,status_moderation,deleted_at', 'orders:id,company_id,status', 'users:id,company_id'];
            if($request->user()->isModerator()){
                $companies_array = [];
                foreach ($user->companies as $c){
                    array_push($companies_array, $c->id);
                }
                $default_queries = [['orderBy', 'created_at', null, 'desc'],['whereIn', 'id', null,  $companies_array]];
            }else{
                $default_queries = [['orderBy', 'created_at', null, 'desc']];
            }


            $collection_companies = CompanySearch::apply($query_request, $loads, $default_queries);
            $companies = $this->paginateFilterCompaniesIndex($collection_companies, $usettings->n_par_1)->appends($query_request);


            return view('admin.company.layouts.indexCompany.itemCompany', compact('companies'))->render();
        }else{
            return 'Тут вам делать нечего!';
        }
    }

    public function paginateFilterCompaniesIndex($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('admin/filter/companies')]);
    }

    public function companyIndex(Request $request, $id){
//        \DB::listen(function($query){
//            dump($query->sql);
//        });
        $user = Auth::user();

        if($request->user()->isModerator()){
            $companies_array = [];
            foreach ($user->companies as $c){
                array_push($companies_array, $c->id);
            }

            if(!in_array($id, $companies_array)){
              return back()->with('danger', 'Такой компании не существует или ответсвенный другой модератор!');
            }
        }

        $usettings = self::usettingTrait($user);

        if($request->ajax()){
            $data = [];
            $company = Company::find($id);
            if($request->type == 'products'){
                $products = Product::withTrashed()->where('company_id', $id)->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends($request->only('type'));
                $products->load('subcategory:id,name,commission');
                $products->load('orders:id,product_id');

                return view('admin.company.layouts.showCompany.products', compact( 'products', 'company'))->render();
            }elseif($request->type == 'orders'){
                $orders = Order::where('company_id', $id)->orderBy('created_at', 'desc')->paginate($usettings->n_par_1)->appends($request->only('type'));
                $orders->load('product:id,name,gallery');
                $orders->load('marketplace:id,name,image_path');

                return view('admin.company.layouts.showCompany.orders', compact( 'orders', 'company'))->render();
            }else{

            }
        }
        $company = Company::find($id);

        $transactions = Transaction::where('company_id', $id)->orderBy('created_at', 'desc')->get();

        $bilder_products = Product::withTrashed()->where('company_id', $id)->orderBy('created_at', 'desc');
        $all_company_products = $bilder_products->get();
        $all_company_products->load('subcategory');
        $products = $bilder_products->paginate($usettings->n_par_1)->appends('type', 'products');
        $products->load('subcategory:id,name,commission');
        $products->load('orders:id,product_id');


        $bilder_orders = Order::where('company_id', $id)->orderBy('created_at', 'desc');
        $all_company_orders = $bilder_orders->get();

        $orders = $bilder_orders->paginate($usettings->n_par_1)->appends('type', 'orders');
        $orders->load('product:id,name,gallery');
        $orders->load('marketplace:id,name,image_path');

        $marketplaces = Marketplace::all();

        return view('admin.company.show', compact('company', 'transactions', 'products', 'all_company_products', 'orders', 'all_company_orders', 'marketplaces'))->withTitle($company->name);
    }

    public function companyIndexFilter(Request $request, $id, $type){
        if($request->ajax()){

            $user = Auth::user();
            $usettings = self::usettingTrait($user);

            $company_id = $id;
            $company = Company::find($company_id);

            $default_queries = [['where', 'company_id', '=', $company_id]];

            if($type == 'transactions'){
                array_push($default_queries, ['orderBy', 'created_at', null, 'desc']);
                $query_request = $request->only('type_transaction', 'transaction_dpk_interval');
                $transactions = TransactionSearch::apply($query_request, null, $default_queries);

                return view('admin.company.layouts.showCompany.transactionsCompany', compact('company', 'transactions'))->render();
            }elseif($type == 'products'){
                $query_request = $request->only('product_id', 'name_like_persent', 'subcategory_id', 'price_like', 'product_subcat_commission_like', 'status_moderation_equally', 'product_dpk_interval_create');

                $loads  = ['subcategory', 'orders'];

                $collection_products  = ProductSearch::apply($query_request, $loads, $default_queries, (isset($request->status_moderation_equally))?(($request->status_moderation_equally == 'deleted') ? true : false) : false);

                $query_request = array_merge($query_request, ['type' => $type]);
                $products = $this->paginateFilterCompanyShow($collection_products,  $usettings->n_par_1, $company->id, $type)->appends($query_request);

                return view('admin.company.layouts.showCompany.products', compact('products', 'company'))->render();
            }elseif($type == 'orders'){
                $query_request = $request->only('order_id_equally', 'marketplace_id_equally', 'status_equally', 'order_dpk_interval_create', 'name_like_percent', 'total_sum_equally', 'customer_name_like_percent', 'customer_email_like_percent', 'customer_phone_like_percent');

                $loads  = ['product', 'marketplace'];

                $collection_orders  = OrderSearch::apply($query_request, $loads, $default_queries, false);

                $query_request = array_merge($query_request, ['type' => $type]);
                $orders = $this->paginateFilterCompanyShow($collection_orders,  $usettings->n_par_1, $company->id, $type)->appends($query_request);

                return view('admin.company.layouts.showCompany.orders', compact('orders', 'company'))->render();
            }
        }else{
            abort('404');
        }
    }

    public function paginateFilterCompanyShow($items, $perPage = 15, $company_id, $type, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('admin/company/'.$company_id.'/filter/'.$type)]);
    }

    public function recalculationCompanyBalance(Request $request, $id){
        SF::recalculationBalanceCompany($id);//перерасчет баланса
        SF::checkCompanyBalance($id);//блокировка или разблокировка баланса
        $count_changed_products = self::comboFunctionsProductsSpetial($id);

        return back()->with('success', 'Перерасчет баланса компании прошел успешно!');
    }

    private function comboFunctionsProductsSpetial($company_id){
        $flag = SF::checkCompanyToBlockProductsSpetial($company_id);
        $resault = SF::changeProductsSpetialStatus($company_id, $flag);

        return $resault;
    }

    public function companySearch(Request $request){
        $company_id = $request->company_id;
        return redirect('admin/company/'.$company_id);
    }


    /* Удаление компании и всех данных по ней*/
    public function companyDelete($id){
        $company = Company::find($id);


        //удаление ЮМЛ ссылок, категорий и товаров
        self::deleteExternalsItems($company->externals);
        //Удаление транзакций компании
        self::deleteTransactions($company->id);
        //удаление изображений на Амазоне
        self::deleteCompanyProductsImagesFromAmazonS3($company->id);
        //удаление заказов
        self::deleteOrders($company->id);
        //удаление опций товаров
        self::deleteProductsItems($company->id);
        //удаление товаров
        self::deleteProducts($company->id);
        //удаление треш изображений
        self::deleteTrashImages($company->id);
        //удаление личных настроек пользователей
        self::deleteUserPrivatSetting($company->id);
        //удаление пользователей компании
        self::deleteUserCompany($company->id);
        //удаление копании
        Company::where('id', $company->id)->delete();

        return back()->with('success', 'Удаление компании прошло успешно!');
    }

    private function deleteExternalsItems($externals){
        foreach ($externals as $external){
            PromCategory::where('external_id', $external->id)->delete();

            PromProduct::where('external_id', $external->id)->delete();

            PromExternal::where('id', $external->id)->delete();
        }
    }

    private function deleteTransactions($company_id){
        Transaction::where('company_id', $company_id)->delete();
    }

    private function deleteCompanyProductsImagesFromAmazonS3($company_id){
        $products = Product::withTrashed()->where('company_id', $company_id)->get();
        foreach ($products as $product){
             $array = json_decode($product->gallery);
            for($i=0; $i<count($array);$i++){
                $file_name = $array[$i]->name;
                Storage::disk('s3')->delete($file_name);
            }
        }
    }

    private function deleteProductsItems($company_id){
        $products = Product::withTrashed()->where('company_id', $company_id)->get();

        foreach ($products as $product){
            ProductsItem::where('product_id', $product->id)->delete();
        }
    }

    private function deleteOrders($company_id){
        Order::where('company_id', $company_id)->delete();
    }

    private function deleteProducts($company_id){
        Product::withTrashed()->where('company_id', $company_id)->forceDelete();
    }

    private function deleteTrashImages($company_id){
        $users = User::where('company_id', $company_id)->get();
        foreach ($users as $user){
            $all_user_images = TreshedImage::where('user_id', $user->id)->get();

            foreach ($all_user_images as $image){
                unlink($image->image_path);
                $image->delete();
            }
        }
    }

    private function deleteUserPrivatSetting($company_id){
        $users = User::where('company_id', $company_id)->get();
        foreach ($users as $user){
            Usetting::where('user_id', $user->id)->delete();
        }
    }

    private function deleteUserCompany($company_id){
        $users = User::where('company_id', $company_id)->get();
        foreach ($users as $user){
            User::where('id', $user->id)->delete();
        }
    }

    public function companyWarnings(Request $request){

        $callback = function($query){
            $query->where('blocked', '0');
        };

        $warnings = CompanyWarning::where('confirm', '0')->whereHas('company', $callback)->with(['company' => $callback])->paginate(20);
        $warnings->load('company');
        $warnings->load('product');
        $warnings->load('order');
        $warnings->load('inspector');
        return view('admin.company.warnings', compact('warnings'))->withTitle('Замечания по компаниям');
    }

    public function showModalAction(Request $request, $id){
        if($request->ajax()){
            $data=[];
            $company_id = $id;
            $type = $request->type;
            $warning = $request->warning;

            $data['status'] = 'success';
            if($type == 'ignor'){
                $data['title'] = 'Игнорировать?';
            }elseif($type == 'block'){
                $data['title'] = 'Заблокировать компанию?';
            }

            $data['render'] = view('admin.company.layouts.warningCompany.modalContent', compact('company_id', 'type', 'warning'))->render();

            return json_encode($data);
        }
    }

    public function actionModalAction(Request $request, $id){
        if($request->ajax()){
            $company_warning = CompanyWarning::find($request->warning_id);
            $company_warning->confirm = '1';
            $company_warning->save();

            $data = [];
            $action = $request->action;
            $data['status'] = 'success';

            if($action == 'ignor'){
                $data['action'] = 'ignor';
                $data['warningId'] = $company_warning->id;
                $data['msg'] = 'Жалоба проигнорирована и удалена!';

            }elseif($action == 'block'){
                $company = Company::find($id);
                $company->blocked = '1';
                $company->save();

                self::removeAllProductsBlockedCompany($company->id);

                $data['action'] = 'block';
                $data['companyId'] = $company->id;
                $data['msg'] = 'Компания '.$company->name.' заблокирована, а ее товары удалены!';
            }

            return json_encode($data);
        }
    }

    private function removeAllProductsBlockedCompany($id){
        Product::where('company_id', $id)->delete();
    }
    /* Удаление компании и всех данных по ней (end)*/

    public function companyEdit(Request $request, $id){
        $type = $request->type;

        if(View::exists('admin.company.layouts.editCompany.blocks.'.$type)){

            $company = Company::find($id);
            $company->load('products');

            if($request->ajax()){
                if($type == 'info' || $type == 'settings'){
                    return view('admin.company.layouts.editCompany.blocks.'.$type, compact('company'))->render();
                }elseif($type == 'transactions'){
                    $transactions = Transaction::where('company_id', $id)->orderBy('created_at', 'desc')->get();
                    $tarif_ab = TariffAboniment::all();
                    return view('admin.company.layouts.editCompany.blocks.'.$type, compact('company', 'transactions', 'tarif_ab'))->render();
                }

            }else{

                if($type == 'info' || $type == 'settings'){
                    $render_block = view('admin.company.layouts.editCompany.blocks.'.$type, compact('company'))->render();
                }elseif($type == 'transactions'){
                    $transactions = Transaction::where('company_id', $id)->orderBy('created_at', 'desc')->get();
                    $tarif_ab = TariffAboniment::all();

                    $render_block = view('admin.company.layouts.editCompany.blocks.'.$type, compact('company', 'transactions', 'tarif_ab'))->render();
                }

                return view('admin.company.edit', compact('company', 'type', 'render_block'));
            }

        }else{
            abort('404');
        }
    }

    public function loadTypeCompanyForm(Request $request){
        if($request->ajax()){
            $type_company = $request->type_company;

            return view('admin.company.layouts.editCompany.blocks.layouts.renderLegalBlock', compact('type_company'))->render();
        }else{
            abort('404');
        }
    }

    public function companyUpdate(Request $request, $id){
        if($request->method()  == 'POST') {
            $company = Company::find($id);
            if($request->action == 'info'){
                $legal_data = json_encode($request->legal_data);

                $company->name = $request->name;
                $company->link = $request->link;
                $company->responsible = $request->responsible;
                $company->responsible_phone = $request->responsible_phone;
                $company->info = $request->info;
                $company->type_company = $request->type_company;
                $company->data = $legal_data;
                $company->save();
            }elseif($request->action == 'settings'){

                if($company->block_bal == '0'){
                    SF::changeProductsSpetialStatus($company->id, true);
                }

                $company->balance_limit = $request->balance_limit;
                $company->ab_from = null;
                $company->ab_to = $request->ab_to;
                $company->block_ab = '0';
                $company->block_new = '0';
                $company->rozetka_on = (isset($request->rozetka_on))?'1':'0';
                $company->prom_on = (isset($request->prom_on))?'1':'0';
                $company->zakupka_on = (isset($request->zakupka_on))?'1':'0';
                $company->save();

                SF::recalculationBalanceCompany($id);//перерасчет баланса
                SF::checkCompanyBalance($id);//блокировка или разблокировка баланса
                $count_changed_products = self::comboFunctionsProductsSpetial($id);

            }else{
                return back()->with('danger', 'Не верно указана задача!');
            }

            return back()->with('success', 'Данные успешно изменены!');
        }else{
            return redirect('/')->with('danger', 'В доступе отказано!');
        }
    }

    public function goProductsToMarketOrOut(Request $request, $id){
        if($request->method()  == 'POST'){
            $action = $request->action;
            $company_id = $id;
            if($action == 'move'){

                DB::table('products')
                    ->where('company_id', $company_id)
                    ->update(['status_spacial' => '1']);

                return back()->with('info', 'Товары отправлено принудительно на маркетплейсы!');
            }elseif($action == 'out'){

                DB::table('products')
                    ->where('company_id', $company_id)
                    ->update(['status_spacial' => '0']);

                return back()->with('info', 'Товары выведенно принудительно из маркетплейсов!');
            }else{
                abort('404');
            }
        }else{
            abort('404');
        }
    }

    public function changeTariffPlanCompany(Request $request){
        $company = Company::find($request->company_id);
        $company->tariff_plan = $request->tariff_plan;
        $company->save();

        return back()->with('success', 'Тарифный план компании "'.$company->name.'" успешно изменен!');
    }

	 /**
     * поиск и удаление дублирующихся товаров
     */
    public function clons($id)
    {

        $clons_product = [];
        $clons_notdel = [];
        $count_results = 0;
        $company_id = $id;

        $results = DB::select("SELECT `code`,`company_id`
        FROM `products` WHERE `company_id` = {$id}
        GROUP BY `code`,`company_id`
        HAVING COUNT(`code`)>1 ");

        if(count($results)>0){

        foreach($results as $res){
            //echo $res->code.'<br>';
            $clons = Product::where('company_id',$id)->where('code',$res->code)->get();

            $count_results += count($clons);

            $clons_product[$res->code] = $clons;


        }

        return view('admin.company.layouts.showCompany.clons', compact('clons_product','count_results','company_id'));
    }else{

        return back()->with('success','Дубликатов не найдено');
    }

    }


    public function all_delclons(Request $request)
    {

        //var_dump( count($request->id_clon) );die();
        if(!isset($request->id_clon)){

            return 'Не выбраны дубликаты!';

        }else{

            if($request->count_clons == count($request->id_clon)){

                return 'Нельзя удалять все товары!';

            }else{
                $arr_clons = [];

               foreach($request->id_clon as $item){

                $product = Product::find($item);

                array_push($arr_clons,$product->code);
                $product->delete();

               }
                 return $arr_clons;
                }
        }




    }

}
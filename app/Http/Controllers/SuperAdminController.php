<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Psr7\Stream;
use Intervention\Image\Facades\Image;
use App\User;
use App\Company;
use App\Product;
use App\ProductsItem;
use App\PromProduct;



class SuperAdminController extends Controller
{

    public function agents(Request $request){
        return view('superAdmin.agent.index.index')->withTitle('Агент');
    }


    public function adminDelete(Request $request, $id){
        if($request->user()->isSuperAdmin()){
            $user = User::find($id);
            if($user){
                $user->delete();
                return redirect()->route('admin_personnel_index')->with('success', 'Удаление успешно выполнено!');
            }else{
                return redirect()->route('admin_personnel_index')->with('danger', 'Действие невыполнимо, такой пользователь отсутсвует или уже удален!');
            }
        }else{
            return redirect()->route('admin_personnel_index')->with('danger', 'В доступе отказано!');
        }

    }

    public function personnelUp(Request $request, $id){
        if($request->user()->isSuperAdmin()){
            $user = User::find($id);
            if($user) {
                if($user->isSuperAdmin()) {

                    return redirect()->route('admin_personnel_index')->with('danger', 'Действие невыполнимо, такой пользователь уже Старший Администратор!');
                }elseif ($user->isAdmin()) {

                    DB::table('users_roles')->where('role_id', '=', '4')->delete();

                    DB::insert('insert into users_roles (user_id, role_id) values (?, ?)', [$user->id, 4]);

                    return redirect()->route('admin_personnel_index')->with('success', $user->getFullName().', успешно повышен до Старшего Администратора!');

                } elseif ($user->isModerator()) {

                    $companies = Company::where('moderator_id', $user->id)->get();

                    if($companies->count() > 0){
                        return redirect()->route('admin_personnel_index')->with('danger', 'За данным модератором закреплены компании, создайте новый акаунт для Админа!');
                    }

                    DB::table('users_roles')->where('user_id', '=', $user->id)->update(['role_id' => 1]);

                    return redirect()->route('admin_personnel_index')->with('success', $user->getFullName().', успешно повышен до Администратора сайта!');
                } else {
                    return redirect()->route('welcome')->with('danger',
                        'Действие не выполнимо, данный пользователь не является ни администратором, ни модератором сайта!');
                }
            }else{
                return redirect()->route('admin_personnel_index')->with('danger', 'Действие невыполнимо, такой пользователь отсутсвует или уже удален!');
            }
        }else{
            return redirect()->route('admin_personnel_index')->with('danger', 'В доступе отказано!');
        }

    }

    public function personnelDown(Request $request, $id){
        if($request->user()->isSuperAdmin()){

            $user = User::find($id);

            if($user) {

                if($user->isModerator()){
                    return redirect()->route('admin_personnel_index')->with('danger', 'Ниже уже некуда, пользователь является модератором!');
                }elseif($user->isAdmin()){

                    DB::table('users_roles')->where('user_id', '=', $user->id)->update(['role_id' => 2]);

                    return redirect()->route('admin_personnel_index')->with('success', $user->getFullName().', успешно понижен до Модератора сайта!');
                }else{
                    return redirect()->route('admin_personnel_index')->with('danger', 'В доступе отказано!');
                }

            }else{
                return redirect()->route('admin_personnel_index')->with('danger', 'Действие невыполнимо, такой пользователь отсутсвует или уже удален!');
            }
        }else{
            return redirect()->route('admin_personnel_index')->with('danger', 'В доступе отказано!');
        }
    }

    public function forseDeleteProductsWithImageFromAmazonAndProductItems($company_id){
        dd('проверь функцию, вносил изменения!');
        //$company = Company::find($company_id);
        $products = Product::withTrashed()->where('company_id', $company_id)->limit(100)->get();

        self::deleteCompanyProductsImagesFromAmazonS3($products);
        self::deleteProductsItems($products);
        self::deleteProducts($products);

        return back()->with('danger', 'Все товары удалены, надеюсь ты знаеш что делаешь?!');
    }

    private function deleteCompanyProductsImagesFromAmazonS3($products){

        foreach ($products as $product){
            $array = json_decode($product->gallery);
            for($i=0; $i<count($array);$i++){
                $file_name = $array[$i]->name;
                Storage::disk('s3')->delete($file_name);
            }
        }
    }

    private function deleteProductsItems($products){

        foreach ($products as $product){
            ProductsItem::where('product_id', $product->id)->delete();
        }
    }

    private function deleteProducts($products){
        $products->forceDelete();
    }

    //forceDelete products
    public function forceDeleteProduct(Request $request, $id){
        $product = Product::find($id);
        $array = json_decode($product->gallery);
        for($i=0; $i<count($array);$i++){
            $file_name = $array[$i]->name;
            Storage::disk('s3')->delete($file_name);
        }
        ProductsItem::where('product_id', $id)->delete();
        Product::where('id', $id)->forcedelete();
        return back()->with('success', 'Товар успешно удален!');
    }
	
	//info autoupdates companies( март 2020г.)
	public function infoUpdateAuto()
    {
        $companies = Company::where('update_auto','!=',NULL)->get();
      
        return view('admin.company.layouts.info_update_auto',compact('companies'));
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Company;
use App\User;
use App\Product;
use App\Order;

class ProviderDirectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('providerAndDirector');
    }

    public function showProfileCompany(Request $request){

        $user_id = $request->user()->id;
        if($user_id == Auth::user()->id){
            $company = Company::find(Auth::user()->company->id);
            return view('provider.director.companyProfile', compact('company'));
        }else{
            return redirect('/')->with('danger', 'В доступе отказано!');
        }
    }

    public function changeProfileCompany(Request $request){

        if($request->method()  == 'POST') {

            $company_id = Auth::user()->company->id;
            $company = Company::find($company_id);
            $legal_data = json_encode($request->legal_data);

            $company->name = $request->name;
            $company->link = $request->link;
            $company->responsible = $request->responsible;
            $company->responsible_phone = $request->responsible_phone;
            $company->info = $request->info;
            $company->type_company = $request->type_company;
            $company->data = $legal_data;
            $company->save();

            return back()->with('success', 'Данные успешно изменены!');
        }else{
            return redirect('/')->with('danger', 'В доступе отказано!');
        }
    }

    public function renderFormLegalCompany(Request $request){
        if($request->ajax()){
            $type_company = $request->type_company;

            return view('provider.director.layouts.renderLegalForm', compact('type_company'))->render();
        }else{
            abort('404');
        }
    }

    public function managerDelete(Request $request, $id){

        if(Auth::user()->isProviderAndDirector()){
            if(isset($request->responsible_id)){
                $check_user_id = $request->responsible_id;
                $user = User::find($check_user_id);
                if($user->company->id == Auth::user()->company->id) {
                    Product::withTrashed()->where('user_id', $id)->update(['user_id' => $check_user_id]);
                    Order::where('user_id', $id)->update(['user_id' => $check_user_id]);
                    $deleted_user = User::find($id);

                    $check_count_products = $deleted_user->products->count();

                    if ($check_count_products <= 0) {
                        $deleted_user->delete();

                        return back()->with('success', 'Удаление сотрудника прошло успешно!')->withTitle('Сотрудники');
                    } else {
                        return back()
                            ->with('danger', 'Удаление сотрудника невозможно, на сотруднике зарегистрированы товары!')
                            ->withTitle('Сотрудники');
                    }
                }else{
                    return back()
                        ->with('danger', 'Вы не можете удалить сотрудника другой компании!')
                        ->withTitle('Сотрудники');
                }
            }else{
                $deleted_user = User::find($id);
                if($deleted_user->products->count() <= 0) {
                    if ($deleted_user->company->id == Auth::user()->company->id) {
                        $deleted_user->delete();

                        return back()->with('success', 'Удаление сотрудника прошло успешно!')->withTitle('Сотрудники');
                    } else {
                        return back()
                            ->with('danger', 'Удаление сотрудника невозможно, на сотруднике зарегистрированы товары!')
                            ->withTitle('Сотрудники');
                    }
                }else{
                    return back()
                        ->with('danger', 'Вы не можете удалить сотрудника другой компании!')
                        ->withTitle('Сотрудники');
                }
            }
        }else{
            return back()->with('danger', 'В доступе отказано!');
        }

    }
}

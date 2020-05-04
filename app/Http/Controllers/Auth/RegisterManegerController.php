<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\RegisterController as RegFasade;
use Illuminate\Support\Facades\DB;
use App\Mail\SendNewManagerReg;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class RegisterManegerController extends Controller
{
    public function showFormCreateNewManeger(){
        return view('provider.director.addNewManagerForm')->withTitle('Добавить сотрудника');
    }

    public function createNewManeger(Request $request){

        $data = $request->all();
        $company_id = $request->user()->company->id;

        if($request->user()->isProviderAndDirector()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'max:255',
            ]);

            if ($validator->fails()) {
                return redirect('company/add/manager')
                    ->withErrors($validator)
                    ->withInput();
            }

            $gen_pas = RegFasade::generateString();

            $new_maneger = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'company_id' => $company_id,
                'password' => bcrypt($gen_pas),
            ]);

            $manager_id = $new_maneger->id;

            DB::insert('insert into users_roles (user_id, role_id) values (?, ?)', [$manager_id, 3]);

            DB::insert('insert into users_jobs (user_id, job_id) values (?, ?)', [$manager_id, 2]);

            $director = $request->user();
            $company = $request->user()->company;
            $user = $new_maneger;
            $password = $gen_pas;

            Mail::to($new_maneger->email)->send(new SendNewManagerReg($director, $company, $user, $password));

            return redirect('/company')->with('success', 'Содрудник зарегистрирован, письмо с паролем отравлено!');
        }else{
            return redirect('/home')->with('danger', 'У Вас нет прав на добавление нового сотрудника!');
        }

    }
}

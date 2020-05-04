<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\SendNewUserReg;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'legal_person' => 'required|string|max:500',
            'link' => 'max:180',
            'responsible' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:255',
            'info' => 'required|string',
        ]);
    }


    public function showRegFormCompany(Request $request)
    {
        if(!$request->user()->isProvider() && !$request->user()->isAdmin()  && !$request->user()->isModerator()){
            return view('user.regFormCompany');
        }else{
            if($request->user()->isProvider()){
                return redirect('/welcome')->with('warning', 'Вы не можете создать компанию. Вы зарегестрированы в компании '.$request->user()->company->name.'.');
            }elseif ($request->user()->isAdmin()){
                return redirect('/admin')->with('warning', 'Администратор не может создать компанию.');
            }elseif ($request->user()->isModerator()){
                return redirect('/admin')->with('warning', 'Модератор не может создать компанию.');
            }

        }

    }

    public function createCompany(Request $request)
    {

        
        $user_id = $request->user()->id;

        if(!$request->user()->company){

            $moderator_id = self::getIdModeratorForCompany();

            $days = 7;
            $index_day = 86400;
            $time_delimit = $days*$index_day;

            $first_aboniment = date('Y-m-d H:i:s', time()+$time_delimit);

            $legal_data = json_encode($request->legal_data);

            $company = Company::create([
                'user_id' => $user_id,
                'name' => $request->name,
                'legal_person' => $request->legal_person,
                'link' => $request->link,
                'responsible' => $request->responsible,
                'responsible_phone' => $request->responsible_phone,
                'ab_to' => $first_aboniment,
                'moderator_id' => $moderator_id,
                'info' => $request->info,
                'type_company' => $request->type_company,
                'data' => $legal_data,
                'block_ab' => '0',
                'block_bal' => '1',
                'block_new' => '1'
            ]);

            $user = User::find($user_id);
            $user->company_id = $company->id;
            $user->save();

            DB::insert('insert into users_roles (user_id, role_id) values (?, ?)', [$user_id, 3]);

            DB::insert('insert into users_jobs (user_id, job_id) values (?, ?)', [$user_id, 1]);

            return redirect()->route('show_company')->with('success', 'Компания '.$company->name.', успешно создана!');

        }else{
            return redirect('/home')->with('danger', 'Вы не можете создать еще одну компанию!');
        }
    }

    private function getIdModeratorForCompany(){
        $role_moderator = Role::find(2);
        $moderators = $role_moderator->users;
        $array = [];
        foreach ($moderators as $m){
            array_push($array, $m->id);
        }
       $rand_int = rand ( 0 , count($array)-1);
       return $array[$rand_int];
    }

    public function loadTypeCompanyForm(Request $request){
        if($request->ajax()){
            $type_company = $request->type_company;

            return view('user.layouts.regCompanyLegalInfoForms', compact('type_company'))->render();
        }else{
            abort('404');
        }
    }

    public function showProfileUser(Request $request){
        if(Auth::check()){

            $user_id = $request->user()->id;

            if($user_id == Auth::user()->id){
                if(Auth::user()->isAdmin() || Auth::user()->isModerator()){
                    return view('admin.adminProfile');
                }else{
                    return view('provider.company.companyUserProfile');
                }
            }else{
                return redirect('/')->with('danger', 'Вы не можете зайти в личный кабинет другого пользователя!');
            }

        }else{
            return redirect('/')->with('danger', 'Вы не зарегистрированы!');
        }
    }

    public function changeProfileUser(Request $request){

        $user_id = $request->user()->id;

        if(Hash::check($request->password, Auth::user()->password)){
            if($user_id == Auth::user()->id){
                if(Auth::user()->email == $request->email){
                    $validator = Validator::make($request->all(), [
                        'name' => 'max:255',
                        'surname' => 'max:255',
                        'phone' => 'max:255',
                        'password' => 'required|min:6|same:password',
                    ]);
                }else{
                    $validator = Validator::make($request->all(), [
                        'name' => 'max:255',
                        'surname' => 'max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'phone' => 'max:255',
                        'password' => 'required|min:6|same:password',
                    ]);
                }


                if ($validator->fails()) {
                    return redirect('/user/profile')
                        ->withErrors($validator)
                        ->withInput();
                }else{
                    $user = User::find($user_id);

                    $user->name = $request->name;
                    $user->surname = $request->surname;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->save();
                }

                return back()->with('success', 'Профиль успешно изменен!');
            }else{
                return redirect('/')->with('danger', 'Ошибка, попытка изменения личных данных другого пользователя!');
            }
        }else{
            return back()->withInput()->with('danger', 'Пароль указан не верно!')->with('password', 'is-invalid');
        }


    }

    public function changePasswordUser(Request $request){

        if(Auth::Check()){

            $request_data = $request->All();
            $validator = $this->admin_credential_rules($request_data);

            if($validator->fails()){

                return redirect()->back()->withInput()->with('errorsArray', $validator->getMessageBag()->toArray());

            }else{

                $current_password = Auth::User()->password;
                if(Hash::check($request_data['current_password'], $current_password)){

                    $new_password = $request_data['password'];
                    $user_id = Auth::User()->id;
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($new_password);
                    $obj_user->save();

                    return redirect()->back()->with('success', 'Пароль успешно изменен!');

                }else{

                    $error = array('current_password' => ['Введите правильно старый пароль!']);
                    return redirect()->back()->with('errorsArray', $error);

                }
            }
        }else{
            return redirect()->to('/');
        }
    }

    public function admin_credential_rules(array $data)
    {
        $messages = [
            'current_password.required' => 'Пожалуйста введите старый пароль!',
            'password.required' => 'Пожалуйста введите новый пароль!',
            'same' => 'Пароли не совпадают!',
            'min' => 'Пароль не меньше :min символов!'
        ];

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|min:6|same:password',
            'password_confirmation' => 'required|min:6|same:password',
        ], $messages);

        return $validator;
    }

}

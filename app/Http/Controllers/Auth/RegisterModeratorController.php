<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\RegisterController as RegFasade;
use Illuminate\Support\Facades\DB;
use App\Mail\SendNewModeratorReg;
use Illuminate\Support\Facades\Mail;

class RegisterModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create(){
        return view('admin.personnel.create')->withTitle('Добавить сотрудника');
    }

    public function store(Request $request){

        if($request->method('post')){

            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:30',
                'surname' => 'required|string|max:40',
                'email' => 'required|string|email|max:160|unique:users',
                'phone' => 'max:30',
            ]);

            if ($validator->fails()) {
                return redirect('admin/personnel/create')
                    ->with('errorsArray', $validator->getMessageBag()->toArray())
                    ->withInput();
            }

            $gen_pas = RegFasade::generateString();

            $new_moderator = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt($gen_pas),
            ]);

            $moderator_id = $new_moderator->id;

            DB::insert('insert into users_roles (user_id, role_id) values (?, ?)', [$moderator_id, 2]);

            $user = $new_moderator;
            $password = $gen_pas;

            Mail::to($new_moderator->email)->send(new SendNewModeratorReg($user, $password));

            return redirect('/admin/personnel')->withTitle('Сотрудники сайта')->with('success', 'Содрудник зарегистрирован, письмо с паролем отравлено!');

        }else{
            Session::flash('danger', 'Ошибка сервера, поставленная задача не выполнена!');
            return redirect('/admin')->withTitle('Сводка');
        }
    }
}

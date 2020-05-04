<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ApiProviderController extends Controller
{
    public function index(Request $request){
        if(!Auth::guest()){
            $user =  Auth::user();

            $data = [];

            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['surname'] = $user->surname;
            $data['email'] = $user->email;
            $phone = $user->phone;
            $phone = preg_replace('/[^0-9]/', '', $phone);
            $data['phone'] = $phone;


            return response()->json($data);
        }else{
            abort('405');
        }

    }

    public function update(Request $request, $id){
        if(!Auth::guest()){
            $auth_user =  Auth::user();
            $user = User::find($id);
            if($auth_user->id == $user->id){
                $user->name=$request->name;
                $user->surname=$request->surname;
                $user->email=$request->email;
                $user->phone=$request->phone;
                $user->save();

                return 'true';
            }else{
                abort('404');
            }
        }else{
            abort('405');
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use App\Company;

class AdminUserController extends Controller
{
    public function index(Request $request){

        $companies = Company::find(14);
        $companies->load('products');
        $collection_users = User::all();
        $collection = collect($collection_users);

        $guests = $collection->filter(function ($item, $key) {
            if($item->isProvider() || $item->isAdminOrModerator()){
                return false;
            }else{
                return true;
            }
        });
        $guests = $guests->sortBy('created_at');
        $guests_count = $guests->count();

        $providers = $collection->filter(function ($item, $key) {
            if($item->isProvider()){
                return true;
            }
        });
        $providers_count = $providers->count();

        $personnel = $collection->filter(function ($item, $key) {
            if($item->isAdminOrModerator()){
                return true;
            }
        });
        $personnel_count = $personnel->count();

        if($request->ajax()){
            $data = [];
            if($request->type == 'guest'){
                $guests = $this->paginate($guests)->appends('type', $request->type);
                $data['status'] = 'success';
                $data['render'] = view('admin.users.layouts.guest.layouts.userItem', compact('guests'))->render();
            }elseif ($request->type == 'provider'){
                $providers = $this->paginate($providers)->appends('type', $request->type);
                $data['status'] = 'success';
                $data['render'] = view('admin.users.layouts.provider.layouts.userItem', compact('providers'))->render();
            }elseif ($request->type == 'personnel'){
                $personnel = $this->paginate($personnel)->appends('type', $request->type);
                $data['status'] = 'success';
                $data['render'] = view('admin.users.layouts.personnel.layouts.userItem', compact('personnel'))->render();
            }else{
                $data['status'] = 'error';
            }

            return json_encode($data);
        }

        $guests = $this->paginate($guests);
        $providers = $this->paginate($providers);
        $personnel = $this->paginate($personnel);
        return view('admin.users.index', compact('guests', 'guests_count', 'providers', 'providers_count', 'personnel', 'personnel_count', 'companies'))->withTitle('Пользователи сайта');
    }


    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('/admin/moderation/users')]);
    }

    public function deleteGuest(Request $request, $id){
        $user = User::find($id);
        if($user->isAdminOrModerator() || $user->isProvider()){
            return back()->with('danger', 'Удаление поставщиков или персонала сайта невозможно!');
        }else{
            $user->delete();
            return back()->with('success', 'Удаление пользователя с эл. адресом: '.$user->email.' прошло успешно!');
        }
    }
}

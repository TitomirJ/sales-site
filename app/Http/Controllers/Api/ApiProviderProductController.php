<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Company;
use App\Product;

class ApiProviderProductController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        // self::checkProvider($user);

        $products = Product::where('company_id', $user->company_id)->get();
        $data = [];
        $count = 0;
        foreach ($products as $product){
            $data[$count]['id'] = $product->id;
            $data[$count]['name'] = $product->name;
            $data[$count]['code'] = $product->code;
            $data[$count]['price'] = $product->price;
            $data[$count]['old_price'] = $product->old_price;
            $data[$count]['status_available'] = $product->status_available;
            $data[$count]['status_moderation'] = $product->status_moderation;
            $data[$count]['status_spacial'] = $product->status_spacial;

            $json_array = json_decode($product->gallery);
            $data[$count]['gallery'] = $json_array[0]->public_path;
            $count++;
        }

        return response()->json($data);
    }

    public function show(Request $request, $id){

        $user = Auth::user();
        //self::checkProvider($user);

        $product = Product::find($id);
        $data = [];

        $data['id'] = $product->id;
        $data['name'] = $product->name;
        $data['code'] = $product->code;
        $data['price'] = $product->price;
        $data['old_price'] = $product->old_price;
        $data['status_available'] = $product->status_available;
        $data['status_moderation'] = $product->status_moderation;
        $data['status_spacial'] = $product->status_spacial;

        $json_array = json_decode($product->gallery);
        $data['gallery'] = $json_array[0]->public_path;

        if($user->company_id == $product->company_id){
            return response()->json($data);
        }
    }

    public function chengeStatusAvailProduct(Request $request){
        $id = $request->product_id;
        $user = Auth::user();
        $product = Product::find($id);

        if($user->company_id == $product->company_id){
            if($product->status_available == '1'){
                $product->status_available = '0';
                $product->save();
                return response()->json([
                    'available' => false
                ]);
            }else{
                $product->status_available = '1';
                $product->save();
                return response()->json([
                    'available' => true
                ]);
            }
        }
    }

    private function checkProvider($user){
        if(!$user->isProvider()){
            return response()->json([
                'status' => 'danger',
                'message' => 'У Вас нет созданной компании!'
            ], 200);
        }
    }
}

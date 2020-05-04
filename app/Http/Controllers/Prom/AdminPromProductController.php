<?php

namespace App\Http\Controllers\Prom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PromProduct;
use App\Product;

class AdminPromProductController extends Controller
{
    public function index(Request $request){
        $products = PromProduct::where('upload', '0')->orderBy('id', 'desc')->simplePaginate(10);
        $products->load('external.company');

        return view('admin.prom.products.index', compact('products'));
    }

    public function productsExternalActions(Request $request, $id, $action){
        if($action == 'reupload'){
            $product = PromProduct::find($id);
            $product->confirm = '1';
            $product->save();

            return redirect()->back()->with('success', 'Товар:('.$product->name.') повторно отправлен на проверку!');
        }else{
            return redirect()->back()->with('danger', 'Это Тимур, куда полез!? Вообще офигел, куда полез!');
        }

    }
}

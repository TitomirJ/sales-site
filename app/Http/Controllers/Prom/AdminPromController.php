<?php

namespace App\Http\Controllers\Prom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PromExternal;
use App\PromCategory;
use App\PromProduct;
use App\Company;

class AdminPromController extends Controller
{
    public function index(Request $request){
        $not_upload_external_count = PromExternal::where('is_unload', '0')->count();
        $extenals = PromExternal::orderBy('created_at', 'desc')->paginate(20);
        $extenals->load('company');
        $count_products = PromProduct::where('upload', '0')->count();

        return view('admin.prom.index', compact('not_upload_external_count', 'extenals', 'count_products' ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderIntegrationController extends Controller
{
    public function index(Request $request){
        return back()->with('warning', 'Интеграция в стадии разработки!');
        return view('provider.company.integration.index')->withTitle('Интеграции');
    }
}

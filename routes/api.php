<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Api\Auth\RegistController@reg');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');
    // profile
    Route::resource('profile', 'Api\ApiProviderController');
    //products
    Route::get('products', 'Api\ApiProviderProductController@index');
    Route::get('products/{id}', 'Api\ApiProviderProductController@show');
    Route::post('product/avil', 'Api\ApiProviderProductController@chengeStatusAvailProduct');
    //orders
    Route::resource('orders', 'Api\ApiProviderOrderController');
    //orders
    Route::get('brief', 'Api\ApiProviderOrderController@brief');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* АПИ запросы для модуля*/
Route::get('module/check_balance/company', 'ApiHerokuController@recheckBalanceCompanyForModuleApi');
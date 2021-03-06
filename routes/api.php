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


Route::group(['middleware' => 'cors', 'as' => 'api.'], function(){
    
    Route::post('access_token', 'Api\AuthController@accessToken')->name('access_token');
    Route::post('refresh_token', 'Api\AuthController@refreshToken')->name('refresh_token');
    
    Route::group(['middleware' => 'auth:api'], function(){
        Route::resource('bancos', 'Api\BancosController', ['only' => ['index']]);
        Route::get('contas_bancarias/lists', 'Api\ContaBancariasController@lists')->name('bank_accounts.list');
        Route::resource('contas_bancarias', 'Api\ContaBancariasController', ['except' => ['create', 'edit']]);
        Route::resource('category_revenues', 'Api\CategoryRevenuesController', ['except' => ['create', 'edit']]);
        Route::resource('category_expenses', 'Api\CategoryExpensesController', ['except' => ['create', 'edit']]);
        Route::resource('bill_pays', 'Api\BillPaysController', ['except' => ['create', 'edit']]);
        Route::post('logout', 'Api\AuthController@logout')->name('logout');
        Route::get('user', function (Request $request) {
            $user = $request->user('api');
            return $user;
        })->middleware('auth:api')->name('user');
    });
});


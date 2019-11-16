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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login')->name('api.authenticate');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register')->name('api.register');
});

Route::group(['middleware' => ['jwt.auth'],'prefix' => 'customer'], function ($router){
    Route::post('create','CustomerController@create')->name('customer.create');
    Route::get('all','CustomerController@all')->name('customer.all');
    Route::post('update/{customer}','CustomerController@update')->name('customer.update');
    Route::get('show/{customer}','CustomerController@show')->name('customer.show');
    Route::post('delete/{customer}','CustomerController@delete')->name('customer.delete');
});

/*
Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::get('customers', 'CustomersController@all')->name('customers.index');
    Route::get('customers/{id}', 'CustomersController@get')->name('customers.show');
    Route::post('customers/new', 'CustomersController@new')->name('customers.create');
    Route::put('customers/update/{customer}', 'CustomersController@new')->name('customers.update');
    Route::put('customers/update/{customer}', 'CustomersController@new')->name('customers.update');
});
*/


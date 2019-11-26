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
    Route::put('update/{customer}','CustomerController@update')->name('customer.update');
    Route::get('show/{customer}','CustomerController@show')->name('customer.show');
    Route::post('delete/{customer}','CustomerController@delete')->name('customer.delete');
    Route::get('findUser', 'CustomerController@search')->name('customer.search');
});

Route::group(['middleware' => ['jwt.auth'],'prefix' => 'user'], function ($router){
    Route::post('create','UserController@create')->name('user.create');
    Route::get('all','UserController@all')->name('user.all');
    Route::put('update/{user}','UserController@update')->name('user.update');
    Route::get('show/{user}','UserController@show')->name('user.show');
    Route::post('delete/{user}','UserController@delete')->name('user.delete');
});

Route::group(['middleware' => ['jwt.auth'],'prefix' => 'profile'], function ($router){
    Route::get('/','ProfileController@profile')->name('user.profile');
    Route::put('/','ProfileController@update')->name('user.profile');
});

Route::group(['middleware' => ['jwt.auth'],'prefix' => 'product'], function ($router){
    Route::post('create','ProductController@create')->name('product.create');
    Route::get('all','ProductController@all')->name('product.all');
    Route::put('update/{user}','ProductController@update')->name('product.update');
    Route::get('show/{user}','ProductController@show')->name('product.show');
    Route::post('delete/{user}','ProductController@delete')->name('product.delete');
});

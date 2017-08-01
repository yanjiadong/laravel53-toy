<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

//后台路由管理
Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
    Route::get('login','LoginController@index')->name('admin.login.index');
    Route::post('logout','LoginController@logout');
    Route::get('/login/captcha/{tmp}','LoginController@captcha');
    Route::post('login','LoginController@login');

    Route::get('index','IndexController@index')->name('admin.index.index');
    Route::get('setting','IndexController@setting')->name('admin.index.setting');
    Route::post('setting','IndexController@update_setting');

    //test
    Route::get('test','LoginController@test');
});

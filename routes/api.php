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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['namespace' => 'Api'], function () {
    Route::get('/index','IndexController@index');

    //获取手机验证码
    Route::post('/index/get_telephone_code','IndexController@get_telephone_code');
    //验证手机验证码
    Route::post('/index/bind_telephone','IndexController@bind_telephone');
});

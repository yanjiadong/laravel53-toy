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
    Route::get('/category/{category_id}/{tag_id}','IndexController@category');
    Route::get('/good/{good_id}','GoodController@info');

    Route::post('/address/add','UserController@add_address');
    Route::post('/address/edit','UserController@edit_address');
    Route::post('/address/info/{id}','UserController@get_address');
    Route::delete('/address/delete','UserController@delete_address');

    //获取手机验证码
    Route::post('/index/get_telephone_code','IndexController@get_telephone_code');
    //验证手机验证码
    Route::post('/index/bind_telephone','IndexController@bind_telephone');

    //获取省市区
    Route::get('/index/get_area/{fid?}','IndexController@get_area');

    Route::get('/test','IndexController@test');


    //快递100订阅请求
    Route::post('/express_info/index','ExpressInfoController@index');
    //快递100回调请求
    Route::post('/express_info/callback','ExpressInfoController@callback')->name('api.express_info.callback');

});

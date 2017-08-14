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
    Route::post('/index/goods','IndexController@goods');

    Route::get('/category/{category_id}/{tag_id}','IndexController@category');
    Route::post('/category/goods','IndexController@category_goods');

    Route::get('/good/{good_id}','GoodController@info');

    //加入玩具箱
    Route::post('/cart/add','CartController@add');
    Route::delete('/cart/delete','CartController@delete');
    //获取玩具箱
    Route::post('/cart/index','CartController@index');
    //选中时判断玩具的库存
    Route::post('/cart/select_good','CartController@select_good');

    //点击寄这个玩具给我
    Route::post('/order/add_order','OrderController@add_order');
    //提交订单
    Route::post('/order/submit_order','OrderController@submit_order');

    //客户收货地址
    Route::post('/address/add','UserController@add_address');
    Route::post('/address/edit','UserController@edit_address');
    Route::post('/address/info/{id}','UserController@get_address');
    Route::delete('/address/delete','UserController@delete_address');

    //获取快递公司列表
    Route::get('/express/list','IndexController@get_express_list');

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

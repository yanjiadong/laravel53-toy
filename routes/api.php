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

    Route::get('/category/{category_id}/{brand_id}','IndexController@category');
    Route::post('/category/goods','IndexController@category_goods');

    Route::get('/good/{good_id}','GoodController@info');

    //加入玩具箱
    Route::post('/cart/add','CartController@add');
    Route::post('/cart/delete','CartController@delete');
    //获取玩具箱
    Route::post('/cart/index','CartController@index');
    //选中时判断玩具的库存
    Route::post('/cart/select_good','CartController@select_good');

    //点击寄这个玩具给我
    Route::post('/order/add_order','OrderController@add_order');
    //提交订单
    Route::post('/order/submit_order','OrderController@submit_order');
    //订单列表
    Route::post('/order/order_list','OrderController@order_list');
    //订单详情
    Route::post('/order/order_info','OrderController@order_info');

    //确认收货
    Route::post('/order/confirm_order','OrderController@confirm_order');
    //可寄回更换详情
    Route::post('/order/order_can_back','OrderController@order_can_back');
    Route::post('/order/order_back','OrderController@order_back');
    //归还详情
    Route::post('/order/order_back_list','OrderController@order_back_list');

    //客户收货地址
    Route::post('/address/index','UserController@address_list');
    Route::post('/address/add','UserController@add_address');
    Route::post('/address/edit','UserController@edit_address');
    Route::post('/address/info/{id}','UserController@get_address');
    Route::post('/address/delete','UserController@delete_address');

    //获取会员卡列表
    Route::post('/user/vip_cards','UserController@vip_cards');

    //获取押金明细
    Route::post('/user/deposit_list','UserController@deposit_list');
    //用户中心
    Route::post('/user/center','UserController@center');
    //获取用户优惠券列表
    Route::post('/user/coupon_list','UserController@coupon_list');

    Route::post('/user/choose_coupon','UserController@choose_coupon');

    Route::post('/user/cash','UserController@cash');
    Route::post('/user/cash_list','UserController@cash_list');

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
    //根据单号查询物流公司
    Route::post('/express_info/com','ExpressInfoController@com');

    //获取物流公司
    Route::post('/index/get_express_list','IndexController@get_express_list');
});

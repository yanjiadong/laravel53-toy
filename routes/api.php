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
    /**
     * ==============以下是新版接口================
     */
    //获取接口首页
    Route::get('/index2','IndexController@index2');

    //订单详情
    Route::post('/order/order_detail','OrderController@order_detail');

    //商品详情
    Route::post('/good/detail','GoodController@detail');

    //用户中心
    Route::post('/user/user_center','UserController@user_center');
    //获取用户芝麻信息
    Route::post('/user/zhima_info','UserController@zhima_info');

    //获取玩具箱
    Route::post('/cart/cart_list','CartController@cart_list');

    //点击寄这个玩具给我
    Route::post('/order/add_order_new','OrderController@add_order_new');
    Route::post('/order/submit_order_new','OrderController@submit_order_new');

    //确认收货
    Route::post('/order/confirm_order','OrderController@confirm_order');
    //申请提现
    Route::post('/order/apply_money','OrderController@apply_money');
    //订单列表
    Route::post('/order/get_order_list','OrderController@get_order_list');
    //获取押金列表
    Route::post('/order/get_money_list','OrderController@get_money_list');

    //计算每日价格
    Route::post('/good/get_day_price','GoodController@get_day_price');
    /**
     * ===========================================
     */
    Route::get('/index','IndexController@index');
    Route::post('/index/goods','IndexController@goods');
    Route::post('/index/banners','IndexController@banners');
    Route::post('/index/categories','IndexController@categories');

    //首页运营活动
    Route::post('/index/activities','IndexController@activities');

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

    //查看订单物流信息
    Route::post('/order/logistics_detail','OrderController@logistics_detail');


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

    //判断用户芝麻授权情况
    Route::post('/user/zhima','UserController@zhima');

    //获取用户优惠券列表
    Route::post('/user/coupon_list','UserController@coupon_list');
    Route::post('/user/user_coupon_list','UserController@user_coupon_list');
    //金币兑换优惠券
    Route::post('/user/user_coupon_exchange','UserController@user_coupon_exchange');

    //我的推荐
    Route::post('/user/my_recommend','UserController@my_recommend');

    Route::post('/user/choose_coupon','UserController@choose_coupon');
    Route::post('/user/del_choose_coupon','UserController@del_choose_coupon');

    Route::post('/user/cash','UserController@cash');
    Route::post('/user/is_can_cash','UserController@is_can_cash');
    Route::post('/user/cash_list','UserController@cash_list');

    //获取购物车数量和租用中的订单数量
    Route::post('/user/get_cart_order_num','UserController@get_cart_order_num');

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
    //根据快递单号主动获取物流信息
    Route::post('/express_info/get_info','ExpressInfoController@get_info');

    //获取物流公司
    Route::post('/index/get_express_list','IndexController@get_express_list');

    //获取聚合数据快递公司编码接口  仅供后台快递公司信息中的编码
    Route::get('/express_info/get_juhe_coms','ExpressInfoController@get_juhe_coms');
    //获取聚合数据快递信息
    Route::post('/express_info/get_juhe_info','ExpressInfoController@get_juhe_info');

    //暂时测试使用 顺丰下单回调接口
    Route::any('/express_info/shunfeng_back','ExpressInfoController@shunfeng_back');
});

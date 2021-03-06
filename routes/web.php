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

//默认首页
Route::get('/', 'Wechat2\IndexController@index');

//Auth::routes();

Route::get('/home', 'HomeController@index');

//旧版微信路由管理
Route::group(['prefix' => 'wechat','namespace' => 'Wechat'], function () {
    Route::any('/index/index','IndexController@index')->name('wechat.index.index');
    Route::any('/index/category/{category_id?}/{brand_id?}','IndexController@category')->name('wechat.index.category');
    Route::any('/index/good/{good_id}','IndexController@good')->name('wechat.index.good');

    //查看购物车
    Route::any('/index/cart','IndexController@cart')->name('wechat.index.cart');

    Route::any('/index/getOpenId','IndexController@getOpenId');

    //成为会员
    Route::any('/index/choose_vip','IndexController@choose_vip');
    Route::any('/index/pay_vip_card/{vip_card_id}','IndexController@pay_vip_card');
    Route::post('/index/pay_vip_card_callback','IndexController@pay_vip_card_callback');

    //提交订单
    //Route::any('/index/submit_order/{good_id}','IndexController@submit_order');
    Route::any('/index/children_interesting_compilation','IndexController@children_interesting_compilation');

    //支付订单
    Route::any('/index/pay_order/{order_code}','IndexController@pay_order');

    Route::any('/index/order_list','IndexController@order_list');
    Route::any('/index/order_success/{order_code}','IndexController@order_success');
    Route::any('/index/order_detail/{order_code}','IndexController@order_detail');

    Route::any('/index/order_return_detail/{page?}','IndexController@order_return_detail');
    Route::any('/index/order_return_detail1','IndexController@order_return_detail1');
    Route::any('/index/fill_logistics/{order_code?}','IndexController@fill_logistics');
    Route::any('/index/logistics_detail/{order_code?}','IndexController@logistics_detail');
    Route::any('/index/logistics_info','IndexController@logistics_info');

    Route::get('/user/center','UserController@center')->name('wechat.user.center');
    Route::get('/user/help','UserController@help')->name('wechat.user.help');
    Route::get('/user/deposit','UserController@deposit')->name('wechat.user.deposit');
    Route::get('/user/deposit_success/{vip_card_pay_id}','UserController@deposit_success');

    Route::get('/user/cash','UserController@cash')->name('wechat.user.cash');
    Route::get('/user/deposit_list','UserController@deposit_list')->name('wechat.user.deposit_list');
    Route::any('/user/share_open/{user_id}','UserController@share_open');
    Route::any('/user/share','UserController@share');

    Route::any('/user/choose_coupon','UserController@choose_coupon');
    Route::any('/user/user_coupon','UserController@user_coupon')->name('wechat.user.user_coupon');

    //test
    Route::any('/index/test','IndexController@test');

    //芝麻认证模块
    Route::any('/index/zmxy','ZhimaController@zmxy');
    Route::any('/index/zmxy/index','ZhimaController@index');
    Route::any('/index/zmxy/info','ZhimaController@info');
    Route::any('/index/zmxy/test','ZhimaController@test');

});

//后台路由管理
Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
    Route::get('login','LoginController@index')->name('admin.login.index');
    Route::post('logout','LoginController@logout');
    Route::get('/login/captcha/{tmp}','LoginController@captcha');
    Route::post('login','LoginController@login');

    Route::get('index','IndexController@index')->name('admin.index.index');
    Route::get('setting','IndexController@setting')->name('admin.index.setting');
    Route::post('setting','IndexController@update_setting');

    Route::resource('categorys', 'CategoryController');

    Route::resource('brands', 'BrandController');
    Route::post('brands/get_brands_by_id','BrandController@get_brands_by_id');

    Route::resource('tags', 'TagController');


    Route::resource('goods', 'GoodController');
    Route::post('goods/action','GoodController@action')->name('goods.action');
    Route::post('goods/sort_action','GoodController@sort_action')->name('goods.sort_action');
    Route::post('goods/store_action','GoodController@store_action')->name('goods.store_action');
    Route::post('goods/new_action','GoodController@new_action')->name('goods.new_action');
    Route::post('goods/hot_action','GoodController@hot_action')->name('goods.hot_action');
    Route::post('goods/get_discount','GoodController@get_discount')->name('goods.get_discount');

    Route::resource('category_tags', 'CategoryTagController');
    Route::post('category_tags/get_tags_by_id','CategoryTagController@get_tags_by_id');

    Route::resource('banners', 'BannerController');

    Route::get('province','AreaController@province')->name('admin.areas.province');
    Route::get('province/add','AreaController@add_province')->name('admin.areas.add_province');
    Route::post('province/store','AreaController@store_province')->name('admin.areas.store_province');
    Route::get('province/edit/{id}','AreaController@edit_province')->name('admin.areas.edit_province');
    Route::post('province/update','AreaController@update_province')->name('admin.areas.update_province');
    Route::post('province/del','AreaController@del_province')->name('admin.areas.del_province');

    Route::get('city/{fid}','AreaController@city')->name('admin.areas.city');
    Route::get('city/add/{fid}','AreaController@add_city')->name('admin.areas.add_city');
    Route::post('city/store','AreaController@store_city')->name('admin.areas.store_city');
    Route::get('city/edit/{id}','AreaController@edit_city')->name('admin.areas.edit_city');
    Route::post('city/update','AreaController@update_city')->name('admin.areas.update_city');
    Route::post('city/del','AreaController@del_city')->name('admin.areas.del_city');

    Route::get('area/{fid}','AreaController@area')->name('admin.areas.area');
    Route::get('area/add/{fid}','AreaController@add_area')->name('admin.areas.add_area');
    Route::post('area/store','AreaController@store_area')->name('admin.areas.store_area');
    Route::get('area/edit/{id}','AreaController@edit_area')->name('admin.areas.edit_area');
    Route::post('area/update','AreaController@update_area')->name('admin.areas.update_area');
    Route::post('area/del','AreaController@del_area')->name('admin.areas.del_area');

    Route::resource('activitys', 'ActivityController');
    Route::resource('vip_cards', 'VipCardController');
    Route::resource('coupons', 'CouponController');
    Route::resource('expresses', 'ExpressController');

    Route::get('system_config','SystemConfigController@index')->name('admin.system_config');
    Route::post('system_config/store','SystemConfigController@store')->name('admin.system_config.store');

    Route::get('wechat_config','SystemConfigController@wechat')->name('admin.wechat_config');
    Route::post('wechat_config/store','SystemConfigController@wechat_store')->name('admin.-.store');

    //订单管理
    Route::get('order/index','OrderController@index')->name('admin.order.index');
    Route::post('order/send','OrderController@send')->name('admin.order.send');
    Route::post('order/verify','OrderController@verify')->name('admin.order.verify');
    Route::post('order/action','OrderController@action')->name('admin.order.action');
    Route::post('order/confirm','OrderController@confirm')->name('admin.order.confirm');
    Route::post('order/remark','OrderController@remark')->name('admin.order.remark');
    Route::post('order/update_express','OrderController@update_express')->name('admin.order.update_express');
    Route::get('order/show/{id}','OrderController@show')->name('admin.order.show');

    //修改订单
    Route::post('order/update','OrderController@update')->name('admin.order.update');

    //押金列表
    Route::get('order/money','OrderController@money')->name('admin.order.money');
    //确认押金退款
    Route::post('order/confirm_money','OrderController@confirm_money')->name('admin.order.confirm_money');

    //押金模块
    Route::resource('vip_card_pays', 'VipCardPayController');
    Route::post('vip_card_pay/action','VipCardPayController@action')->name('admin.vip_card_pay.action');

    //用户管理
    Route::get('user/index','UserController@index')->name('admin.user.index');
    Route::get('user/recommend','UserController@recommend')->name('admin.user.recommend');
    Route::post('user/action','UserController@action')->name('admin.user.action');
    //删除用户
    Route::post('user/destroy','UserController@destroy')->name('admin.user.destroy');

    Route::post('upload/{size?}','CommonController@upload');

    Route::get('crontab/index','CrontabController@index')->name('admin.crontabs.index');
    Route::get('user_open_time/index','UserController@get_user_open_times')->name('admin.user_open_times.index');
    //test
    Route::get('test','LoginController@test');
});

//引入新版微信端路由
require __DIR__.'/wechat/web.php';

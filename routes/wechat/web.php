<?php

//微信公众号后台验证
Route::any('wechat/index/valid','Wechat\IndexController@valid');
//微信公众号创建菜单
Route::any('wechat/index/menu','Wechat\IndexController@menu');

//测试新版支付
Route::any('wechat2/index/pay_test','Wechat2\IndexController@pay_test')->name('wechat2.index.pay_test');

//提交订单页面
Route::get('wechat2/index/submit_order/{good_id}','Wechat2\IndexController@submit_order')->name('wechat2.index.submit_order');

//每日运行的脚本
Route::any('wechat/crontab/index','Wechat\CrontabController@index');
Route::any('wechat/crontab/check_order','Wechat\CrontabController@check_order');
Route::any('wechat/crontab/check_order_express','Wechat\CrontabController@check_order_express');

//新版微信路由管理
Route::group(['prefix' => 'wechat2','namespace' => 'Wechat2'], function () {
    //首页
    Route::any('/index/index','IndexController@index')->name('wechat2.index.index');

    //分类页面
    Route::get('/index/category/{category_id?}/{brand_id?}','IndexController@category')->name('wechat2.index.category');

    //商品详情
    Route::get('/index/good/{good_id}','IndexController@good')->name('wechat2.index.good');

    //查看购物车
    Route::get('/index/cart','IndexController@cart')->name('wechat2.index.cart');

    //订单列表
    Route::get('/index/order_list','IndexController@order_list')->name('wechat2.index.order_list');

    //订单详情
    Route::get('/index/order_detail/{order_code}','IndexController@order_detail')->name('wechat2.index.order_detail');

    //支付成功
    Route::get('/index/pay_success/{order_code}','IndexController@pay_success')->name('wechat2.index.pay_success');

    //归还详情
    Route::get('/index/order_return_detail','IndexController@order_return_detail')->name('wechat2.index.order_return_detail');

    //使用优惠券
    //Route::get('/index/choose_coupon','IndexController@choose_coupon')->name('wechat2.index.choose_coupon');

    //查看物流信息
    Route::get('/index/logistics_detail/{order_code}','IndexController@logistics_detail')->name('wechat2.index.logistics_detail');
    //提交归还信息
    Route::get('/index/logistics_info','IndexController@logistics_info')->name('wechat2.index.logistics_info');
    //提交归还后
    Route::get('/index/logistics_info_return','IndexController@logistics_info_return')->name('wechat2.index.logistics_info_return');

    //用户中心
    Route::get('/user/user_center','UserController@user_center')->name('wechat2.user.user_center');
    //我的押金
    Route::get('/user/my_deposit','UserController@my_deposit')->name('wechat2.user.my_deposit');
    //我的邀请
    Route::get('/user/my_recommend','UserController@my_recommend')->name('wechat2.user.my_recommend');
    //押金明细
    Route::get('/user/deposit_list','UserController@deposit_list')->name('wechat2.user.deposit_list');
    //提现成功页面
    Route::get('/user/cash_success/{order_code}','UserController@cash_success')->name('wechat2.user.cash_success');

    //优惠券
    Route::get('/user/user_coupon','UserController@user_coupon')->name('wechat2.user.user_coupon');
    //分享页面
    Route::get('/user/share','UserController@share')->name('wechat2.user.share');
    //分享后打开的页面
    Route::get('/user/share_open','UserController@share_open')->name('wechat2.user.share_open');
    //帮助页面
    Route::get('/user/help','UserController@help')->name('wechat2.user.help');

    //微信授权 采用easywechat扩展包
    Route::any('/index/oauth','IndexController@oauth')->name('wechat2.index.oauth');
    Route::any('/index/oauth_callback','IndexController@oauth_callback')->name('wechat2.index.oauth_callback');

    Route::any('/index/share_open_oauth_callback','UserController@share_open_oauth_callback')->name('wechat2.index.share_open_oauth_callback');

    //支付回调函数
    Route::any('/pay_notify','IndexController@pay_notify');

    //芝麻认证模块
    Route::any('/index/zmxy','ZhimaController@zmxy');  //最后成功回调页
    Route::any('/index/zmxy/index','ZhimaController@index');  //芝麻认证首页
    Route::any('/index/zmxy/info','ZhimaController@info');   //芝麻认证授权页

    Route::any('/index/zmxy/face','ZhimaController@face');
    Route::any('/index/zmxy/test','ZhimaController@test');

    //测试测试
    Route::any('/index/test','IndexController@test');
});
<?php

//微信公众号后台验证
Route::any('wechat/index/valid','Wechat\IndexController@valid');
//微信公众号创建菜单
Route::any('wechat/index/menu','Wechat\IndexController@menu');

//测试新版支付
Route::any('wechat/index/pay_test','Wechat2\IndexController@pay_test')->name('wechat2.index.pay_test');

//提交订单页面
Route::get('wechat/index/submit_order/{good_id}','Wechat2\IndexController@submit_order')->name('wechat2.index.submit_order');

//新版微信路由管理
Route::group(['prefix' => 'wechat2','namespace' => 'Wechat2'], function () {
    //首页
    Route::any('/index/index','IndexController@index')->name('wechat2.index.index');

    //微信授权 采用easywechat扩展包
    Route::any('/index/oauth','IndexController@oauth')->name('wechat2.index.oauth');
    Route::any('/index/oauth_callback','IndexController@oauth_callback')->name('wechat2.index.oauth_callback');

    //支付回调函数
    Route::any('/pay_notify','IndexController@pay_notify');

    //芝麻认证
    Route::any('/index/zmxy/face','ZhimaController@face');
    Route::any('/index/zmxy/test','ZhimaController@test');
});
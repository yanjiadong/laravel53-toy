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

    //用户中心
    Route::get('/user/user_center','UserController@user_center')->name('wechat2.user.user_center');
    //我的押金
    Route::get('/user/my_deposit','UserController@my_deposit')->name('wechat2.user.my_deposit');
    //押金明细
    Route::get('/user/deposit_list','UserController@deposit_list')->name('wechat2.user.deposit_list');

    //微信授权 采用easywechat扩展包
    Route::any('/index/oauth','IndexController@oauth')->name('wechat2.index.oauth');
    Route::any('/index/oauth_callback','IndexController@oauth_callback')->name('wechat2.index.oauth_callback');

    //支付回调函数
    Route::any('/pay_notify','IndexController@pay_notify');

    //芝麻认证模块
    Route::any('/index/zmxy','ZhimaController@zmxy');  //最后成功回调页
    Route::any('/index/zmxy/index','ZhimaController@index');  //芝麻认证首页
    Route::any('/index/zmxy/info','ZhimaController@info');   //芝麻认证授权页

    Route::any('/index/zmxy/face','ZhimaController@face');
    Route::any('/index/zmxy/test','ZhimaController@test');
});
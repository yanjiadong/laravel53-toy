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

    Route::resource('categorys', 'CategoryController');

    Route::resource('tags', 'TagController');

    Route::resource('goods', 'GoodController');
    Route::post('goods/action','GoodController@action')->name('goods.action');

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

    Route::post('upload/{size?}','CommonController@upload');
    //test
    Route::get('test','LoginController@test');
});

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
//注册登录功能实现
Auth::routes();

//首页展示
Route::get('/', function () {
    return view('welcome');
});

//登录成功页面，可跳转至/all概览页面
Route::get('/home',function () {
    return view('home');
});

//概览展示：应用总数；设备总数。
//并且可以点击进去观看详细数据
Route::get('/all','allController@index');

//网关管理数据
Route::group(['middleware' => 'auth', 'namespace' => 'gateway', 'prefix' => 'gateway'], function () {
    Route::get('/', 'gatewayController@index');//网关首页展示
    Route::get('/register', 'gatewayController@register');//网关注册
    Route::post('/register', 'gatewayController@store');//注册数据存储及跳转至首页展示
    Route::get('/{input}','gatewayController@input');//进入二级展示页面（overview）
    Route::get('/{input}/traffic/list','gatewayController@trafficList');//二级页面之数据（列表）
    Route::get('/{input}/traffic/graph','gatewayController@trafficGraph');//二级页面之数据（趋势图）
    Route::get('/{input}/setting','gatewayController@setting');//二级页面之型号设置（更改网关设置数据）
    Route::get('/{input}/setting/frequencyPlan','gatewayController@settingFrequency');//二级页面之频段设置
    Route::get('/{input}/setting/type','gatewayController@settingType');//二级页面之类型设置
    Route::get('/{input}/setting/location','gatewayController@settingLocation');//二级页面之地理位置设置
    Route::post('/{input}/setting','gatewayController@settingPost');//二级页面之设置之存储并跳转至二级页面overview
    Route::post('/{input}/setting/frequencyPlan','gatewayController@settingFrequencyPost');
    Route::post('/{input}/setting/type','gatewayController@settingTypePost');
    Route::post('/{input}/setting/location','gatewayController@settingLocationPost');
    Route::post('/delete','gatewayController@deletePost');//网关删除并跳转至网关首页
});

//应用管理数据
Route::group(['middleware' => 'auth', 'namespace' => 'client', 'prefix' => 'client'], function () {
    Route::get('/', 'clientController@index');//应用首页 modal实现应用注册并在该页面展示
    Route::post('/', 'clientController@store');//注册数据存储并跳转至首页
    Route::get('/{input}', 'clientController@input');//二级页面之overview
    Route::get('/{input}/device', 'clientController@device');//二级页面之该应用下的所有注册的设备
    Route::get('/{input}/setting', 'clientController@setting');//二级页面之应用设置修改之appName
    Route::post('/{input}/setting', 'clientController@settingPost');//二级页面之应用设置修改返回二级页面
    Route::post('/delete','clientController@deletePost');//应用删除返回应用首页
});

//设备管理数据
Route::group(['middleware' => 'auth', 'namespace' => 'device', 'prefix' => 'device'], function () {
    Route::match(['get', 'post'], '/', 'deviceController@index');//设备管理首页
    Route::post('/register', 'deviceController@register');//注册后台处理
    Route::get('/{input}', 'deviceController@input');//转至该设备下具体数据展示
    Route::get('/{input}/data', 'deviceController@data');//设备的上行数据页面
//    Route::get('/{input}/data/uplink', 'deviceController@upLink'); //设备应用数据页面，暂未使用
    Route::get('/{input}/data/downlink', 'deviceController@downLink'); //设备下行数据页面
//    Route::post('/{input}/data/downlink', 'deviceController@downLinkPost');//设备下行数据存储数据库
    Route::get('/{input}/setting', 'deviceController@setting');//设备更改设置页面
    Route::post('/{input}/setting', 'deviceController@settingPost');//设置修改的存储
    Route::get('/{input}/setting/appeui', 'deviceController@settingAppEUI');
    Route::post('/{input}/setting/appeui', 'deviceController@settingAppEUIPost');
    Route::post('/{input}/setting/autoDevEUI', 'deviceController@settingAutoDevEUI');
    Route::post('/{input}/delete','deviceController@deletePost');//删除设备(input是AppEUI，应用管理下删除)
    Route::post('/delete','deviceController@deleteDevice');//删除设备（设备管理中删除）
});

Route::get('/help',function () {
    $email='gaojia@bupt.edu.cn';
    return view('overview')->with(['email'=>$email]);
});

Route::get('/help/gateway',function () {
    $email='gaojia@bupt.edu.cn';
    return view('gateway')->with(['email'=>$email]);
});
Route::get('/help/client',function () {
    $email='gaojia@bupt.edu.cn';
    return view('client')->with(['email'=>$email]);
});
Route::get('/help/device',function () {
    $email='gaojia@bupt.edu.cn';
    return view('device')->with(['email'=>$email]);
});

Route::post('/help',function () {
    $email='gaojia@bupt.edu.cn';
    return view('overview')->with(['email'=>$email]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


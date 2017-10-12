<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//第一节：路由的基本使用
//基本路由
Route::get('/test', function () {
    return 'hello get';
});

Route::post('/test', function () {
    return 'hello post';
});

Route::put('/test', function () {
    return 'hello put';
});

Route::delete('/test', function () {
    return 'hello delete';
});

//多重路由
Route::match(['get','post','put'], '/fun', function() {
	return url();
});

//带参数的路由
//可选参数的路由，
Route::get('/demo/{name}/{id?}', function($name, $id = null){
	return 'hello '.$id;
})->where('id', '[0-9]+');


//第二节：控制器
//基本控制器
Route::get('/demo1', 'DemoController@demo');

//请求和响应
Route::get('/request', 'admin\DemoController@request');
Route::get('/response', 'admin\DemoController@response');

//后台
Route::resource('/users', 'admin\UserController');

// 文件上传
Route::get('/uploads', 'admin\UploadsController@index');
Route::post('/uploads', 'admin\UploadsController@doUploads');

//登录
Route::get('/admin/login', 'admin\LoginController@index');
Route::post('/admin/login', 'admin\LoginController@dologin');
Route::get('/admin/captcha/{tmp}', 'admin\LoginController@captcha');

//路由群组
Route::group(['prefix' => 'admin','middleware' => 'login'],function(){
	Route::get('index', 'admin\AdminController@index');
	Route::get('demo111', function(){
		return 1111111;
	});
});


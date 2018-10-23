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

Route::get('/getOpenid', 'WeiXin\WeiXinController@getOpenid');

Route::get('/actionGetCode', 'WeiXin\WeiXinController@actionGetCode');

Route::get('/actionGettoken', 'WeiXin\WeiXinController@actionGettoken');

Route::get('/actionsubscribe', 'WeiXin\WeiXinController@actionsubscribe');

Route::get('/getAccessToken', 'WeiXin\WeiXinController@getAccessToken');


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

Route::get('/','PagesController@root')->name('root');
// 用户身份验证相关的路由
// 用户注册相关路由
// 密码重置相关路由
// Email 认证相关路由
Auth::routes();



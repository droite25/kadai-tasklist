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
// 元々あった奴
Route::get('/', 'TasksController@index');
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::resource('tasks', 'TasksController');

// とりあえず追加した奴、ユーザー登録用
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// とりあえず追加した奴、ログイン認証用
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// Route::get('home', 'TasksController@index');
// とりあえず追加した奴
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', 'TasksController');
});

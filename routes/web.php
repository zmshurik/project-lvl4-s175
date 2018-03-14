<?php

use Symfony\Component\HttpKernel\Tests\Fragment\RoutableFragmentRendererTest;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController', ['except' => [
    'create', 'store', 'show'
]]);
Route::get('user/profile/changepwd', 'UserController@changePwdShow')->name('user.changepwd');
Route::patch('user/profile/changepwd', 'UserController@changePwdStore')->name('user.storepwd');

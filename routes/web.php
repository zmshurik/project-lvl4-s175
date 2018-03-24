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
Route::prefix('user/account')->group(function () {
    Route::resource('password', 'PasswordController', ['only' => [
        'index', 'store'
    ]]);
});

Route::resource('taskStatuses', 'TaskStatusController', ['except' => [
    'create', 'show'
]]);

Route::resource('tasks', 'TaskController', ['except' => ['show']]);

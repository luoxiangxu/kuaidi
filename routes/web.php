<?php

use Illuminate\Support\Facades\Route;
use App\User;

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

Route::get('/homepage',function(){
    return view('homepage');
})->middleware('verified')->middleware('auth');

Auth::routes();
Auth::routes(['verify' => true]);


Route::get('/logout',function(){ auth()->logout();return redirect('/');});


Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('verified')->middleware('auth')->prefix('user')->group(function(){

    Route::get('profile',function(){
        return view('user.profile');
    });

    Route::get('shopping',function(){
        return view('user.shopping');
    });

    Route::get('order',function(){
        return view('user.order');
    });

    Route::get('topuprecord',function(){
        return view('user.topuprecord');
    });

});

Route::middleware('verified')->middleware('administrator')->prefix('admin')->group(function(){

    Route::get('userpage',function(){
        return view('admin.userpage');
    });

    Route::get('orderrecord',function(){
        return view('admin.orderrecord');
    });

    Route::get('order',function(){
        return view('admin.order');
    });

    Route::get('arrivedorder',function(){
        return view('admin.arrivedorder');
    });

    Route::get('topup',function(){
        return view('admin.topup');
    });
});


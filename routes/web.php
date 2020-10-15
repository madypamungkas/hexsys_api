<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('layout.app');
// });

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['role:Super Admin']], function () {
        Route::group(['middleware' => ['role:Super Admin'],'prefix' => 'admin'], function(){
            Route::resource('user', 'UserController')->except('destroy');
            Route::resource('component', 'ComponentController')->except('destroy');
            Route::resource('instansi', 'InstansiController')->except('destroy');
            Route::resource('ambulan', 'AmbulanController')->except('destroy');
        });
    });
    Route::get('my-profile', 'UserController@myProfile')->name('profile.index');
    Route::put('my-profile', 'UserController@updateProfile')->name('profile.update-profil');
    Route::put('my-profile/password', 'UserController@updatePassword')->name('profile.update-password');

    Route::group(['middleware' => ['role:Super Admin'],'prefix' => 'table'], function () {
        Route::group(['middleware' => ['role:Super Admin']], function(){
            Route::get('data-user', 'UserController@getData');
            Route::get('data-component', 'ComponentController@getData');
            Route::get('data-instansi', 'InstansiController@getData');
            Route::get('data-instansi/update-status/{id}', 'InstansiController@updateStatus')->name('instansi.updateStatus');
            Route::get('data-ambulan', 'AmbulanController@getData');
            Route::get('data-ambulan/update-status/{id}', 'AmbulanController@updateStatus')->name('ambulan.updateStatus');
        });
    });

    Route::group(['middleware' => ['role:Super Admin'],'prefix' => 'delete'], function () {
        Route::group(['middleware' => ['role:Super Admin']], function(){
            Route::get('data-user/{id}', 'UserController@destroy')->name('user.destroy');
            Route::get('data-component/{id}', 'ComponentController@destroy')->name('component.destroy');
            Route::get('data-instansi/{id}', 'InstansiController@destroy')->name('instansi.destroy');
            Route::get('data-ambulan/{id}', 'AmbulanController@destroy')->name('ambulan.destroy');
        });
    });
});


Route::group(['middleware' => ['auth','role:Super Admin']], function () {
      Route::get('/', function(){
        if (Auth::user()->hasAnyRole(['Super Admin'])) {
            return redirect()->route('home');
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
      });
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

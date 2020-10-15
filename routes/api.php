<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('register', 'API\Auth\RegisterController@create');
Route::middleware('api')->post('login','API\Auth\LoginController@login');

Route::group(['middleware'=>['auth:api']], function(){
    // profile
    Route::post('/logout','API\UserController@logout');
    Route::get('/profile','API\UserController@show');
    Route::post('/profile/update','API\UserController@update');
    Route::post('/password/update','API\UserController@updatePassword');

    // instansi
    Route::get('/instansi','API\InstansiController@list');
    Route::get('/instansi/{id}','API\InstansiController@show');

    // ambulan
    Route::resource('ambulan', 'API\AmbulanController');
});

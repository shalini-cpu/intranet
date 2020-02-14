<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/// Login & Register
Route::group(['prefix'=>'v1'],function(){
    Route::post('login', 'ApiAuthController@login');
    Route::post('register', 'ApiAuthController@register');
});


/** ONLY FOR DEV **/
header("Access-Control-Allow-Origin: *");
/** ONLY FOR DEV **/

Route::group(['middleware' => 'auth.jwt', 'prefix' => 'v1'], function ($router) {
    Route::any('logout', 'ApiAuthController@logout');
    Route::post('me', 'ApiAuthController@me');

    // Users CRUD
    Route::resource('/users', 'UserController');
});

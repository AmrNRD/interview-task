<?php

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


Route::group([
            'prefix' => 'auth',

            'namespace'=>'Auth',

            'guard'=>'api',

            ], function () {

             Route::post('login', 'AuthController@login');

             Route::post('login/provider', 'AuthController@loginWithProvider');

             Route::post('signup', 'AuthController@signup');

             Route::group(['middleware' => 'auth:api'], function () {
                Route::get('/profile', 'AuthController@profile');
                });
             });


            Route::group(['namespace' => 'Auth', 'middleware' => 'api', 'prefix' => 'password'], function () {

            Route::post('create', 'PasswordResetController@create');

            Route::get('find/{token}', 'PasswordResetController@find');

            Route::post('reset', 'PasswordResetController@reset');

            });
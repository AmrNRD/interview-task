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


Route::middleware(['auth'])->group(function () {
		Route::resource('/carts','CartController');
		Route::post('/multi-delete/{cart}','CartController@destroy')->name('carts.multi-delete');

		Route::resource('/cart-items','CartItemController');
		Route::post('/multi-delete/{cartItem}','CartItemController@destroy')->name('cart-items.multi-delete');

});

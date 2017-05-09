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

Route::group(['prefix' => 'products'], function () {

    Route::get('/', 'ProductController@index')->name('getAllProducts');
    Route::post('bind', 'ProductController@bindVoucher')->name('bindVoucher');
    Route::post('unbind', 'ProductController@unbindVoucher')->name('unbindVoucher');
    Route::post('store', 'ProductController@store')->name('createProduct');
    Route::post('{product}', 'ProductController@buy')->name('buyProduct');
});

Route::group(['prefix' => 'voucher'], function () {

    Route::post('store', 'VoucherController@store')->name('createVoucher');
});

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


Auth::routes();

Route::middleware('auth')->prefix('/panel')->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('panel');
    Route::resource('/slider', \App\Http\Controllers\Admin\SliderController::class)->parameter('slider', 'id');
    Route::post('/slider/index/{id}' , [\App\Http\Controllers\Admin\SliderController::class , 'ajaxIndex'])->name('ajax-index');
    Route::resource('/category' , \App\Http\Controllers\Admin\CategoryController::class)->except('create')->parameter('category' , 'title');
    Route::resource('/product' , \App\Http\Controllers\Admin\ProductController::class)->parameter('product' , 'title');
    Route::get('/product/create/{id}' , [\App\Http\Controllers\Admin\ProductController::class , 'create'])->name('product.create');
});

Route::get('/', [\App\Http\Controllers\IndexController::class , 'index'])->name('index');

Route::get('/shop', function () {
    return view('front.shop');
})->name('shop');

Route::get('/showProduct', function () {
    return view('front.showProduct');
})->name('showProduct');

Route::get('/checkOut', function () {
    return view('front.checkOut');
})->name('checkOut');

Route::get('/cart', function () {
    return view('front.cart');
})->name('cart');




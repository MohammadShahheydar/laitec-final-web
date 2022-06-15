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
    Route::get('/product/create/{title}' , [\App\Http\Controllers\Admin\ProductController::class , 'create'])->name('product.create');
    Route::resource('/banner' , \App\Http\Controllers\Admin\BannerController::class)->parameter('banner' , 'title');
});

Route::get('/', [\App\Http\Controllers\IndexController::class , 'index'])->name('index');

Route::get('/shop', [\App\Http\Controllers\ShopController::class , 'index'] )->name('shop');

Route::get('/product/{title}', [\App\Http\Controllers\ShopController::class , 'show'])->name('shop.show');

Route::get('/category/{title}' , [\App\Http\Controllers\ShopController::class , 'showCategory'])->name('category.show');

Route::get('/checkOut', function () {
    return view('front.checkOut');
})->name('checkOut');

Route::get('/cart', function () {
    return view('front.cart');
})->name('cart');




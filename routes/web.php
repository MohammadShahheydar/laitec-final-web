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



Route::middleware('auth')->prefix('/panel')->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
        ->name('panel');

    Route::resource('/slider', \App\Http\Controllers\Admin\SliderController::class)
        ->parameter('slider', 'id');

    Route::post('/slider/index/{id}', [\App\Http\Controllers\Admin\SliderController::class, 'ajaxIndex'])
        ->name('ajax-index');

    Route::resource('/category', \App\Http\Controllers\Admin\CategoryController::class)
        ->except('create')->parameter('category', 'title');
    Route::put('/category/{title}/restore' , [\App\Http\Controllers\Admin\CategoryController::class , 'restore'])
        ->name('category.restore');
    Route::delete('/category/{title}/force-delete' , [\App\Http\Controllers\Admin\CategoryController::class , 'forceDelete'])
        ->name('category.force-delete');

    Route::resource('/product', \App\Http\Controllers\Admin\ProductController::class)
        ->parameter('product', 'title');
    Route::put('/product/{title}/restore' , [\App\Http\Controllers\Admin\ProductController::class , 'restore'])
        ->name('product.restore');
    Route::delete('/product/{title}/force-delete' , [\App\Http\Controllers\Admin\ProductController::class , 'forceDelete'])
        ->name('product.force-delete');

    Route::get('/product/create/{title}', [\App\Http\Controllers\Admin\ProductController::class, 'create'])
        ->name('product.create');

    Route::resource('/banner', \App\Http\Controllers\Admin\BannerController::class)
        ->parameter('banner', 'title');

    Route::resource('/authorize', \App\Http\Controllers\Admin\AuthorizeController::class)
        ->middleware('Admin')->parameter('authorize', 'id')->except('store', 'create');

});

Auth::routes();

Route::middleware('guest')->group(function () {

    Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');

    Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');

    Route::get('/product/{title}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');

    Route::get('/category/{title}', [\App\Http\Controllers\ShopController::class, 'showCategory'])->name('shop.category.show');

    Route::get('/checkOut', function () {
        return view('front.checkOut');
    })->name('checkOut');

    Route::get('/cart', function () {
        return view('front.cart');
    })->name('cart');
});

Route::post('/test/test' , function () {
    dd('logout');
})->name('loglog')->middleware('auth');





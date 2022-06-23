<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;


Route::prefix('admin')->name('admin.')->middleware(['auth','is_admin'])->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('index');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});
Route::middleware('auth')->group(function(){
    Route::post('add-to-cart',[CartController::class,'add_to_cart'])->name('add_to_cart');
    Route::get('/remove-cart{id}',[CartController::class,'remove_cart'])->name('remove_cart');
    Route::get('/cart',[CartController::class,'cart'])->name('site.cart');
    Route::post('/update-cart',[CartController::class,'update_cart'])->name('update_cart');
    Route::get('/checkout',[CartController::class,'checkout'])->name('site.checkout');
    Route::get('/checkout/thanks',[CartController::class,'checkout_thanks'])->name('site.checkout_thanks');
});
    Route::get('/',[SiteController::class,'index'])->name('site.index');
    Route::get('/category{id}',[SiteController::class,'category'])->name('site.category');
    Route::get('/product{id}',[SiteController::class,'product'])->name('site.product');
    Route::get('/shop',[SiteController::class,'shop'])->name('site.shop');
    Route::post('/add-review',[SiteController::class,'add_review'])->name('site.add_review');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


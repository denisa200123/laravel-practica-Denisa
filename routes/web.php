<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LanguageController;

Route::middleware(['setLocale'])->group(function () {
    Route::get('/', [CartController::class, 'home'])->name('home');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/add', [CartController::class, 'addCart'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('admin');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('admin');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('admin');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('admin');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('admin');
    Route::delete('/products/{product}', [ProductController::class, 'delete'])->name('products.destroy')->middleware('admin');

    Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form')->middleware('admin');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy')->middleware('admin');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('admin');

    Route::post('/set-language', [LanguageController::class, 'setLanguage'])->name('set.language');
});

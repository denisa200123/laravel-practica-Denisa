<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::resource('products', ProductController::class)->except(['index']);

Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

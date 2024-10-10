<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::resource('products', ProductController::class)->except(['index']);

Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

Route::post('/checkout', [ProductController::class, 'processCheckout'])->name('checkout.process');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/edit/page', [AdminController::class, 'editPage'])->name('edit.page');
Route::post('/edit/product/{id}/page', [AdminController::class, 'editProductPage'])->name('edit.product.page');
Route::post('/edit/product/{id}', [AdminController::class, 'editProduct'])->name('edit.product');

Route::delete('/delete/{id}', [AdminController::class, 'deleteProduct'])->name('delete.product');

Route::get('/add', [AdminController::class, 'addProduct'])->name('add.product');

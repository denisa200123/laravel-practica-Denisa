<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::resource('products', ProductController::class)->except(['index']);

Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

Route::post('/checkout', [ProductController::class, 'processCheckout'])->name('checkout.process');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show')->middleware('admin');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('admin');

Route::get('/edit/page', [AdminController::class, 'editPage'])->name('edit.page')->middleware('admin');
Route::post('/edit/product/{id}/page', [AdminController::class, 'editProductPage'])->name('edit.product.page')->middleware('admin');
Route::put('/edit/product/{id}', [AdminController::class, 'editProduct'])->name('edit.product')->middleware('admin');

Route::delete('/delete/{id}', [AdminController::class, 'deleteProduct'])->name('delete.product')->middleware('admin');

Route::get('/add/page', [AdminController::class, 'addProductPage'])->name('add.page')->middleware('admin');
Route::post('/add/product', [AdminController::class, 'addProduct'])->name('add.product')->middleware('admin');

Route::post('/set-language', [LanguageController::class, 'setLanguage'])->name('set.language');

// redirect user to the main page if they access the route using a GET method instead of POST, PUT, or DELETE.

Route::get('/cart/clear', function () { return redirect('/'); });
Route::get('/checkout', function () { return redirect('/'); });
Route::get('/edit/product/{id}/page', function () { return redirect('/'); });
Route::get('/edit/product/{id}', function () { return redirect('/'); });
Route::get('/delete/{id}', function () { return redirect('/'); });
Route::get('/add/product', function () { return redirect('/'); });
Route::get('/set-language', function () { return redirect('/'); });

<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [ShopController::class, 'cart'])->name('cart.index');
Route::patch('/cart/update/{productId}', [ShopController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [ShopController::class, 'removeCart'])->name('cart.remove');

Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [ShopController::class, 'placeOrder'])->name('checkout.place');

Route::get('/orders/{order}/confirmation', [ShopController::class, 'confirmation'])->name('order.confirmation');
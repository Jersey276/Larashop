<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'apiIndex'])->name('api.users.index');
Route::get('/users/{user}', [UserController::class, 'apiView'])->name('api.users.view');
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'apiIndex')->name('api.products.index');
    Route::get('/{product}', 'apiView')->name('api.products.view');
    Route::post('/', 'apiStore')->name('api.products.store');
    Route::put('/{product}', 'apiUpdate')->name('api.products.update');
});
Route::controller(ShippingMethodController::class)->prefix('shipping')->group(function () {
    Route::get('/', 'apiIndex')->name('api.shipping.index');
    Route::get('/{shippingMethod}', 'apiView')->name('api.shipping.view');
    Route::post('/', 'apiStore')->name('api.shipping.store');
    Route::put('/{shippingMethod}', 'apiUpdate')->name('api.shipping.update');
});
Route::get('/addresses', [AddressController::class, 'apiIndex'])->name('api.addresses.index');
Route::get('/orders', [OrderController::class, 'apiIndex'])->name('api.orders.index');
Route::prefix('categories')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/', 'apiIndex')->name('api.categories.index');
        Route::get('/{category}', 'apiView')->name('api.categories.view');
        Route::post('/', 'apiStore')->name('api.categories.store');
        Route::put('/{category}', 'apiUpdate')->name('api.categories.update');
    });
});


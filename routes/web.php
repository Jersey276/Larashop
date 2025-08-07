<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\CheckIsUser;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Admin Routes
Route::middleware(['auth', 'verified', CheckIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('admin.dashboard');
    Route::prefix('categories')->controller(CategoryController::class)->group(function () {
        Route::get('', 'adminIndex')->name('admin.categories.index');
        Route::get('add', 'adminAdd')->name('admin.categories.add');
        Route::get('{category}/edit', 'adminEdit')->name('admin.categories.edit');
    });
    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('', 'adminIndex')->name('admin.products.index');
        Route::get('add', 'adminAdd')->name('admin.products.add');
        Route::get('{product}/edit', 'adminEdit')->name('admin.products.edit');
    });
    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('', 'adminIndex')->name('admin.orders.index');
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'adminIndex'])->name('admin.users.index');
        Route::get('/{user}', [UserController::class, 'adminView'])->name('admin.users.view');
    });
    //Route::get('/settings', [SettingsController::class, 'adminIndex'])->name('admin.settings.index');
});
// Customer Routes
Route::middleware([CheckIsUser::class])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('home');
    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/{name}', 'index')->name('products.index');
    });
    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/{product}', 'view')->name('products.view');
    });
});
Route::middleware('auth', 'verified')->group(function () {
    Route::prefix('profile', function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

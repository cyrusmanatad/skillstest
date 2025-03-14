<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Datatable\ProductDatatable;
use App\Http\Datatable\UserDatatable;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
    ->name('customer.dashboard');
    
    Route::get('/products', [CustomerDashboardController::class, 'products'])
    ->name('product.list');

    Route::get('/product', [CustomerDashboardController::class, 'formView'])
    ->name('product.form');
    
    Route::post('/product', [CustomerDashboardController::class, 'create'])
    ->name('product.create');

    Route::get('/product/{productId}/', [CustomerDashboardController::class, 'edit'])
    ->name('product.edit');
    
    Route::put('/product/{productId}/', [CustomerDashboardController::class, 'update'])
    ->name('product.update');
    
    Route::delete('/product/{productId}/', [CustomerDashboardController::class, 'destroy'])
    ->name('product.destroy');

    // Customer Product only
    Route::post('/customer-products', [ProductDatatable::class, 'customer'])->name('dt.customer.products');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

        Route::get('/products', [AdminDashboardController::class, 'products'])
        ->name('admin.product.list');

        Route::get('/product', [AdminDashboardController::class, 'formView'])
        ->name('admin.product.form');

        Route::post('/product', [AdminDashboardController::class, 'create'])
        ->name('admin.product.create');

        Route::get('/product/{productId}/', [AdminDashboardController::class, 'edit'])
        ->name('admin.product.edit');
        
        Route::put('/product/{productId}/', [AdminDashboardController::class, 'update'])
        ->name('admin.product.update');
        
        Route::delete('/product/{productId}/', [AdminDashboardController::class, 'destroy'])
        ->name('admin.product.destroy');

        Route::get('/users', [AdminDashboardController::class, 'users'])
        ->name('user.list');

        Route::get('/user/{user}/products', [AdminDashboardController::class, 'userProducts'])
        ->name('user.product.list');
    });
    Route::post('/users', [UserDatatable::class, 'datatable'])->name('dt.users');

    // All products including customers products
    Route::post('/products', [ProductDatatable::class, 'admin'])->name('dt.admin.products');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
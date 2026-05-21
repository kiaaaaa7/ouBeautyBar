<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| USER ROUTES — harus login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/bukti-bayar', [OrderController::class, 'uploadPaymentProof'])->name('orders.upload-proof');
    Route::post('/pesanan/{order}/batal', [OrderController::class, 'cancel'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES — harus login + is_admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.orders.index'))->name('dashboard');

    // Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Produk
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Foto produk
    Route::delete('/product-images/{image}', [AdminProductController::class, 'destroyImage'])->name('product-images.destroy');
    Route::post('/product-images/{image}/primary', [AdminProductController::class, 'setPrimaryImage'])->name('product-images.primary');

    // Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{order}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES — bawaan Laravel Breeze
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
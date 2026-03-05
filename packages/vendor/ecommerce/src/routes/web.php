<?php 

use Illuminate\Support\Facades\Route;
use Vendor\Ecommerce\Controllers\ProductController;

Auth::routes();
Route::middleware(['auth', 'web'])->group(function () {
    Route::prefix('ecommerce')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/statistics', [ProductController::class, 'statistics'])->name('products.statistics');
        Route::get('/products/export/{format}', [ProductController::class, 'export'])->name('products.export');
        Route::post('/products/{id}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    });
});
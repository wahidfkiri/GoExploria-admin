<?php 

use Illuminate\Support\Facades\Route;
use Vendor\Ecommerce\Controllers\ProductController;
use Vendor\Ecommerce\Controllers\PaymentController;

Auth::routes();
Route::middleware(['auth', 'web'])->group(function () {
    Route::prefix('ecommerce')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/statistics', [ProductController::class, 'statistics'])->name('products.statistics');
        Route::get('/products/export/{format}', [ProductController::class, 'export'])->name('products.export');
        Route::post('/products/{id}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        // Dans routes/web.php
        Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image');
        // Routes supplémentaires pour la gestion avancée
        Route::delete('products/{product}/force', [ProductController::class, 'forceDestroy'])->name('products.force-destroy');
        Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    });
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');
    Route::post('/{payment}/note', [PaymentController::class, 'addNote'])->name('payments.add-note');
    Route::get('/{payment}/receipt', [PaymentController::class, 'downloadReceipt'])->name('payments.receipt');
    Route::post('/{payment}/send-receipt', [PaymentController::class, 'sendReceipt'])->name('payments.send-receipt');
    Route::get('/payments/statistics', [PaymentController::class, 'statistics'])->name('payments.statistics');
});
});
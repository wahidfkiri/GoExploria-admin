<?php 

use Illuminate\Support\Facades\Route;
use Vendor\Administration\Controllers\SliderController;

Auth::routes();

Route::middleware(['auth','web'])->group(function () {
// Routes pour les sliders
Route::prefix('sliders')->group(function () {
    Route::get('/', [SliderController::class, 'index'])->name('sliders.index');
    Route::post('/', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/{id}', [SliderController::class, 'show'])->name('sliders.show');
    Route::put('/{id}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    
    // Routes supplémentaires
    Route::post('/{id}/restore', [SliderController::class, 'restore'])->name('sliders.restore');
    Route::delete('/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('sliders.force-delete');
    Route::post('/{id}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
    Route::post('/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');
    Route::get('/statistics', [SliderController::class, 'statistics'])->name('sliders.statistics');
    Route::get('/{id}/preview', [SliderController::class, 'preview'])->name('sliders.preview');
});
});
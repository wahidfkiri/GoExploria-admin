<?php

use Illuminate\Support\Facades\Route;
use Vendor\Users\Controllers\UserController;


Auth::routes();

Route::middleware(['auth','web'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::post('/users/{user}/update-roles', [UserController::class, 'updateRoles'])->name('users.update-roles');
Route::post('/users/bulk-update', [UserController::class, 'bulkUpdate'])->name('users.bulk-update');
Route::get('/users/statistics', [UserController::class, 'statistics'])->name('users.statistics');
Route::get('/api/roles', [UserController::class, 'getRoles'])->name('api.roles');
});

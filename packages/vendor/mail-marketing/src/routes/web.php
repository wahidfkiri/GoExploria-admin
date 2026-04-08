<?php 

use Illuminate\Support\Facades\Route;
use Vendor\MailMarketing\Controllers\MailMarketingController;

Route::middleware(['web'])
    ->namespace('Vendor\MailMarketing\Http\Controllers')
    ->group(function () {
        Route::prefix('mail-marketing')->group(function () {
            Route::get('/', [MailMarketingController::class, 'index'])->name('mail-marketing.index');
        });
    });
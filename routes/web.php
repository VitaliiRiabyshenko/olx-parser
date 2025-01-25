<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerifyEmailController;

Route::get('/', [HomeController::class, 'index'])->name('user-parser.index');
Route::post('/', [HomeController::class, 'store'])->name('user-parser.store');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerifyEmailController::class, 'index'])->name('verify-email-index');
    Route::post('/email/send', [VerifyEmailController::class, 'send'])->name('verify-email-send');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])->name('verify-email');
});
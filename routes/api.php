<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('reset', [\App\Http\Controllers\ResetController::class, 'reset'])->name('config.reset');

    Route::get('balance', [\App\Http\Controllers\BalanceController::class, 'show'])->name('balance.show');
});
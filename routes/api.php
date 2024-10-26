<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('reset', [\App\Http\Controllers\ResetController::class, 'reset'])->name('config.reset');

});
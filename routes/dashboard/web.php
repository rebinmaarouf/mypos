<?php

use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('index');
});

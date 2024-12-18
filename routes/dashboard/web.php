<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\LogoutController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/index', [DashboardController::class, 'index'])->name('index');
            Route::resource('users', UserController::class)->except('show');
        });
    }
);

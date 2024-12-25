<?php

use App\Http\Controllers\dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\LogoutController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(), // This will set the locale for each route based on the current locale
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            // Dashboard Index
            Route::get('/index', [DashboardController::class, 'index'])->name('index');

            // User routes, excluding 'show' route
            Route::resource('users', UserController::class)->except('show');

            // Category routes, excluding 'show' route
            Route::resource('categories', CategoryController::class)->except('show');
            //product routes
            Route::resource('products', 'ProductController')->except(['show']);
        });
    }
);

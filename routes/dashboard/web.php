<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ClientController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\WelcomeController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\OrderController as OrderController;
use App\Http\Controllers\dashboard\Client\OrderController as OrderClienController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(), // This will set the locale for each route based on the current locale
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            // Dashboard Index
            Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

            // User routes, excluding 'show' route
            Route::resource('users', UserController::class)->except(['show']);
            // Category routes, excluding 'show' route
            Route::resource('categories', CategoryController::class)->except(['show']);
            //product routes
            Route::resource('products', ProductController::class)->except(['show']);
            //client routes
            Route::resource('clients', ClientController::class)->except(['show']);
            Route::resource('clients.orders', OrderClienController::class)->except(['show']);

            //order routes
            Route::resource('orders', OrderController::class);
            Route::get('/orders/{order}/products', [OrderController::class, 'products'])->name('orders.products');
        });
    }
);

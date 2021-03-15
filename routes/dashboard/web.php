<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ClientController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){
    Route::get('/index', [DashboardController::class, 'index'])->name('index');

    //user routes
    Route::resource('users', 'UserController', ['except'=>['show']]);

    // category routes
    Route::resource('categories', 'CategoryController', ['except'=>['show']]);

    // product routes
    Route::resource('products', 'ProductController', ['except'=>['show']]);
    
    // client routes
    Route::resource('clients', 'ClientController', ['except'=>['show']]);


});
<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;


Route::prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/index', [DashboardController::class, 'index'])->name('index');

    Route::resource('users', 'UserController', ['except'=>['show']]);
});
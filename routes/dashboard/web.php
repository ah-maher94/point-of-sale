<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){
    Route::get('/index', [DashboardController::class, 'index'])->name('index');

    Route::resource('users', 'UserController', ['except'=>['show']]);
});
<?php

use App\Http\Controllers\Dashboard\DashboardController;


Route::prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/index', [DashboardController::class, 'index'])->name('index');
});
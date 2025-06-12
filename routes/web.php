<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home.index');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('category', CategoryController::class);
    Route::resource('video', VideoController::class);
});

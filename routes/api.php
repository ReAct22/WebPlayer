<?php

use App\Http\Controllers\api\BarangController;
use App\Http\Controllers\api\CategorisController;
use App\Http\Controllers\api\PlaylistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/playlist', [PlaylistController::class, 'index']);
Route::get('/categoris/{id}', [CategorisController::class, 'index']);
Route::get('/barangs', [BarangController::class, 'index']);

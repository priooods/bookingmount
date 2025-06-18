<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PendakianController;
use App\Http\Controllers\SopController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainController::class);
Route::get('/', [BerandaController::class, 'index']);
Route::resource('berita', NewsController::class);
Route::resource('sop', SopController::class);
Route::resource('panduan', PanduanController::class);
Route::resource('pendakian', PendakianController::class);

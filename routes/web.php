<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModernArt\AuthController as ModernArtAuthController;
use App\Http\Controllers\ModernArt\HomeController as ModernArtHomeController;
use App\Http\Controllers\ModernArt\SettingController as ModernArtSettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// UserController
Route::get('/profile', [UserController::class, 'index'])->middleware('auth');

// HomeController
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get("/home/detail-transaction/{date}", [HomeController::class, 'detailTransactionInDate'])->middleware('auth');

// SettingController
Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');

// ReportController
Route::get('/report', [ReportController::class, 'index'])->middleware('auth');



/* theme modern art */
Route::get('/register/modern-art', [ModernArtAuthController::class, 'register'])->middleware('guest');

Route::get('/modern-art', [ModernArtHomeController::class, 'index'])->middleware('auth');

Route::get('/setting/modern-art', [ModernArtSettingController::class, 'index'])->middleware('auth');
/* end theme modern art */

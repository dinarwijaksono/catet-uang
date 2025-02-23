<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// HomeController
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get("/home/detail-transaction/{date}", [HomeController::class, 'detailTransactionInDate'])->middleware('auth');

// SettingController
Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');

// ReportController
Route::get('/report', [ReportController::class, 'index'])->middleware('auth');

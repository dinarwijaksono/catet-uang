<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');

// HomeController
Route::get('/', [HomeController::class, 'index'])->middleware('auth');

// SettingController
Route::get('/setting', [SettingController::class, 'index']);

// ReportController
Route::get('/report', [ReportController::class, 'index']);

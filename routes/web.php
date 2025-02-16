<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// AuthController
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');

// HomeController
Route::get('/', [HomeController::class, 'index']);

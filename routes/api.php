<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Middleware\HasTokenMiddleware;
use App\Http\Middleware\MissingTokenMiddelware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/register', [AuthController::class, 'register'])->middleware(MissingTokenMiddelware::class);
Route::post('/login', [AuthController::class, 'login'])->middleware(MissingTokenMiddelware::class);


// CategoryController
Route::post('/category', [CategoryController::class, 'create'])->middleware([HasTokenMiddleware::class]);
Route::get('/category/get-all', [CategoryController::class, 'getAll'])->middleware([HasTokenMiddleware::class]);
Route::put('/category', [CategoryController::class, 'update'])->middleware([HasTokenMiddleware::class]);
Route::delete('/category', [CategoryController::class, 'delete'])->middleware([HasTokenMiddleware::class]);

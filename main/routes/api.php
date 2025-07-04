<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\CategoryControllerApi;
use App\Http\Middleware\HasTokenMiddleware;
use App\Http\Middleware\MissingTokenMiddelware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/register', [AuthControllerApi::class, 'register'])->middleware(MissingTokenMiddelware::class);
Route::post('/login', [AuthControllerApi::class, 'login'])->middleware(MissingTokenMiddelware::class);
Route::get('/user', [AuthControllerApi::class, 'findByToken'])->middleware([HasTokenMiddleware::class]);
Route::delete('/logout', [AuthControllerApi::class, 'logout'])->middleware(HasTokenMiddleware::class);

// CategoryController
Route::post('/category', [CategoryControllerApi::class, 'create'])->middleware(HasTokenMiddleware::class);
Route::get('/category/get-all', [CategoryControllerApi::class, 'getAll'])->middleware(HasTokenMiddleware::class);
Route::get('/category/{code}', [CategoryControllerApi::class, 'getCategory'])->middleware(HasTokenMiddleware::class);

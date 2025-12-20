<?php

use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\CategoryControllerApi;
use App\Http\Controllers\Api\FileFormatControllerApi;
use App\Http\Controllers\Api\TransactionControllerApi;
use App\Http\Controllers\Api\UploadFileControllerApi;
use App\Http\Middleware\HasTokenMiddleware;
use App\Http\Middleware\MissingTokenMiddelware;
use Illuminate\Support\Facades\Route;

// AuthController
Route::post('/register', [AuthControllerApi::class, 'register'])->middleware(MissingTokenMiddelware::class);
Route::post('/login', [AuthControllerApi::class, 'login'])->middleware(MissingTokenMiddelware::class);
Route::get('/user', [AuthControllerApi::class, 'findByToken'])->middleware([HasTokenMiddleware::class]);
Route::delete('/logout', [AuthControllerApi::class, 'logout'])->middleware(HasTokenMiddleware::class);

// CategoryController
Route::post('/category', [CategoryControllerApi::class, 'create'])->middleware(HasTokenMiddleware::class);
Route::get('/category/get-by-type/{type}', [CategoryControllerApi::class, 'getByType'])->middleware(HasTokenMiddleware::class);
// Route::get('/category/{code}', [CategoryControllerApi::class, 'getCategory'])->middleware(HasTokenMiddleware::class);
Route::get('/category/get-all', [CategoryControllerApi::class, 'getAll'])->middleware(HasTokenMiddleware::class);
Route::delete('/category/{code}', [CategoryControllerApi::class, 'delete'])->middleware(HasTokenMiddleware::class);

// TransactionCategory
Route::post('/transaction', [TransactionControllerApi::class, 'create'])->middleware(HasTokenMiddleware::class);
Route::get('/transaction/get-by-date/{date}', [TransactionControllerApi::class, 'getByDate'])->middleware(HasTokenMiddleware::class);
Route::get('/transaction/get-summary-income-spending', [TransactionControllerApi::class, 'getSummaryIncomeSpending'])->middleware(HasTokenMiddleware::class);
Route::get('/transaction/get-period', [TransactionControllerApi::class, 'getPeriods'])->middleware(HasTokenMiddleware::class);
Route::get('/transaction/all/{page}', [TransactionControllerApi::class, 'getAllPaging'])->middleware(HasTokenMiddleware::class);
Route::get('/transaction/{code}', [TransactionControllerApi::class, 'getByCode'])->middleware(HasTokenMiddleware::class);
Route::put('/transaction/{code}', [TransactionControllerApi::class, 'updateTransaction'])->middleware(HasTokenMiddleware::class);
Route::delete('/transaction/{code}', [TransactionControllerApi::class, 'delete'])->middleware(HasTokenMiddleware::class);

// FileFormat
Route::post('/file/csv-format-download', [FileFormatControllerApi::class, 'downloadCsv'])->middleware(HasTokenMiddleware::class);
Route::post('/file/csv-upload', [UploadFileControllerApi::class, 'uploadCsv'])->middleware(HasTokenMiddleware::class);

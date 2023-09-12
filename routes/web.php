<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\OnlyLoginMiddleware;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class,'home']);

Route::get('/login', [LoginController::class,'loginForm']);
Route::post('/login', [LoginController::class,'postLogin']);
Route::get('/logout', [LoginController::class,'logout']);
Route::get('/product', [ProductController::class,'showAllProducts'])->middleware("only");
Route::get('/product/{productCode}', [ProductController::class,'getProduct'])->middleware("only");
Route::post('/transaction', [TransactionController::class,'createTransactionHeader'])->middleware("only");
Route::get('/transaction/print', [TransactionController::class,'print'])->middleware("only");

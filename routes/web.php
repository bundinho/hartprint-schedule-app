<?php

use App\Http\Controllers\OrderController;
use App\Http\Middleware\OrderResolverMiddleware;
use App\Http\Middleware\OrderValidateMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/orders', [OrderController::class, 'store'])->middleware([OrderValidateMiddleware::class, OrderResolverMiddleware::class]);

Route::get('/orders/create', [OrderController::class, 'create']);

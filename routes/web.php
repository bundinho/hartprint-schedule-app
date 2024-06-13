<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/orders', [OrderController::class, 'store']);

Route::get('/orders/create', [OrderController::class, 'create']);

Route::get('/schedule', [ScheduleController::class, 'index']);


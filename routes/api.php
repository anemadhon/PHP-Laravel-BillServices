<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('bills', \App\Http\Controllers\BillController::class)->only(['index', 'show', 'store']);
Route::put('payments/{payment}', \App\Http\Controllers\PaymentController::class)->name('payments.update');

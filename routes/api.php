<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AnimalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('duenos', DuenoController::class);
Route::apiResource('animales', AnimalController::class);

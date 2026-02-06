<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AnimalController;

Route::apiResource('duenos', DuenoController::class);
Route::apiResource('animales', AnimalController::class);

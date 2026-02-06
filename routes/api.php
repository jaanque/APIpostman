<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\AnimalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas API para la aplicación.
|
*/

// Rutas para la gestión de Dueños (CRUD completo: index, store, show, update, destroy)
Route::apiResource('duenos', DuenoController::class);

// Rutas para la gestión de Animales (CRUD completo: index, store, show, update, destroy)
Route::apiResource('animales', AnimalController::class);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacaController;
use App\Http\Controllers\ProductorController;
 
use App\Http\Controllers\ProduccionLecheController;
Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('vacas', VacaController::class);
Route::apiResource('productores',ProductorController::class);
Route::apiResource('produccion-leche', ProduccionLecheController::class);

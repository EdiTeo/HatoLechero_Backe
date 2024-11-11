<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\VacaController;
use App\Http\Controllers\ProductorController;
 
use App\Http\Controllers\ProduccionLecheController;
Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('vacas', VacaController::class);
Route::apiResource('productores',ProductorController::class);
Route::apiResource('produccion-leche', ProduccionLecheController::class);
=======

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
>>>>>>> 8e067eff3492b4990e7506d24cf9716d21790751

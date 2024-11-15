<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoresController;
use App\Http\Controllers\VacaController;
use App\Http\Controllers\ProduccionLecheController;
use App\Http\Controllers\HistorialMedicoController;
use App\Http\Controllers\ReproduccionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/productor', [ProductoresController::class, 'index']);
Route::get('/vaca', [VacaController::class, 'index']);
Route::get('/produccionLeche', [ProduccionLecheController::class, 'index']);
Route::get('/reproduccion', [ReproduccionController::class, 'index']);
Route::post('/vacas', [VacaController::class, 'store']);
Route::get('/vacas/contar-por-etapa-y-estado', [VacaController::class, 'contarPorEtapaDeCrecimientoYEstadoReproductivo']);
Route::put('/vacas/{vaca_id}', [VacaController::class, 'update']);
Route::delete('/vacas/{vaca_id}', [VacaController::class, 'destroy']);

Route::get('/vacas/{vaca_id}/historial', [HistorialMedicoController::class, 'obtenerHistorialPorVaca']);
Route::post('/historial-medico', [HistorialMedicoController::class, 'agregarDiagnostico']);




Route::get('/test', function () {
    return response()->json(['message' => 'API is workingsssssss!']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

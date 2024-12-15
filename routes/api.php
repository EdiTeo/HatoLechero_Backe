<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoresController;
use App\Http\Controllers\VacaController;
use App\Http\Controllers\ProduccionLecheController;
use App\Http\Controllers\HistorialMedicoController;
use App\Http\Controllers\ReproduccionController;
use App\Http\Controllers\AlertaHatoController;
use App\Http\Controllers\AuthController;
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
Route::get('/historial-medico/vacas-en-tratamiento-hoy', [HistorialMedicoController::class, 'obtenerVacasEnTratamientoHoy']);


Route::post('/reproducciones', [ReproduccionController::class, 'store']);
Route::get('vaca/{vacaId}/inseminacion-pendiente', [ReproduccionController::class, 'obtenerInseminacionPendiente']);
Route::put('reproducciones/{reproduccion_id}', [ReproduccionController::class, 'actualizarParto']);
Route::get('/vacas-preñadas', [ReproduccionController::class, 'contarVacasPrenadas']);

Route::get('/produccion-leche/hoy', [ProduccionLecheController::class, 'getProduccionHoy']);
Route::get('/produccion-leche/mes-actual', [ProduccionLecheController::class, 'getProduccionMensual']);
Route::post('/produccion-leche', [ProduccionLecheController::class, 'store']);
Route::get('produccion-leche/mes', [ProduccionLecheController::class, 'getProduccionMensual1']);
Route::get('/produccion-leche/fecha', [ProduccionLecheController::class, 'getProduccionPorFecha']);

Route::get('/alertas/productor/{productor_id}', [AlertaHatoController::class, 'getAlertasByProductorId']);
Route::post('alertas', [AlertaHatoController::class, 'store']);


Route::get('/test', function () {
    return response()->json(['message' => 'API is workingsssssss!']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
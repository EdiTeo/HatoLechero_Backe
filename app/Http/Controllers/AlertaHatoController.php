<?php

namespace App\Http\Controllers;

use App\Models\AlertaHato;
use Illuminate\Http\Request;

class AlertaHatoController extends Controller
{
    // Mostrar una lista de todas las alertas
    // Guardar una nueva alerta
public function store(Request $request)
{
    $request->validate([
        'productor_id' => 'required|exists:productores,productor_id',
        'fecha_alerta' => 'required|date',
        'tipo_alerta' => 'required|string|max:255',
        'nota' => 'nullable|string',
    ]);

    $alerta = new AlertaHato();
    $alerta->productor_id = $request->productor_id;
    $alerta->fecha_alerta = $request->fecha_alerta;
    $alerta->tipo_alerta = $request->tipo_alerta;
    $alerta->nota = $request->nota;
    $alerta->save();

    return response()->json($alerta, 201);
}
// Obtener alertas por productor_id
public function getAlertasByProductorId($productor_id)
{
    $alertas = AlertaHato::where('productor_id', $productor_id)->get();

    return response()->json($alertas);
}


}

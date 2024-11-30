<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HistorialMedico;

class HistorialMedicoController extends Controller
{
    public function index(){
        return HistorialMedico::all();
    }
    public function obtenerHistorialPorVaca($vaca_id)
{
    // Obtener los tratamientos de la vaca específica
    $tratamientos = HistorialMedico::where('vaca_id', $vaca_id)
                    ->where('tipo', 'tratamiento')
                    ->get();

    // Obtener las vacunaciones de la vaca específica
    $vacunaciones = HistorialMedico::where('vaca_id', $vaca_id)
                    ->where('tipo', 'vacunación')
                    ->get();

    return response()->json([
        'tratamientos' => $tratamientos,
        'vacunaciones' => $vacunaciones
    ]);
}
public function agregarDiagnostico(Request $request)
    {
        // Validación de los datos entrantes
        $validated = $request->validate([
            'vaca_id' => 'required|exists:vacas,vaca_id',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:tratamiento,vacunación,fallecimiento',
            'medicamento' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'dias_tratamiento' => 'required|integer',  // Días de tratamiento
            'notas' => 'nullable|string',
        ]);

        // Calcular la fecha de fin a partir de los días de tratamiento
        $fecha_inicio = Carbon::parse($validated['fecha_inicio']);
        $fecha_fin = $fecha_inicio->addDays($validated['dias_tratamiento'])->toDateString();

        // Crear un nuevo historial médico
        $historial = new HistorialMedico();
        $historial->vaca_id = $validated['vaca_id'];
        $historial->descripcion = $validated['descripcion'];
        $historial->tipo = $validated['tipo'];
        $historial->medicamento = $validated['medicamento'];
        $historial->fecha_inicio = $validated['fecha_inicio'];
        $historial->fecha_fin = $fecha_fin;
        $historial->notas = $validated['notas'];
        $historial->save();

        return response()->json(['message' => 'Diagnóstico agregado exitosamente', 'data' => $historial], 201);
    }
    public function obtenerVacasEnTratamientoHoy()
{
    // Fecha actual
    $fechaHoy = Carbon::today();

    // Contar las vacas en tratamiento
    $vacasEnTratamiento = HistorialMedico::where('tipo', 'tratamiento')
        ->whereDate('fecha_inicio', '<=', $fechaHoy)
        ->whereDate('fecha_fin', '>=', $fechaHoy)
        ->count();

    return response()->json([
        'vacas_en_tratamiento' => $vacasEnTratamiento
    ]);
}

}

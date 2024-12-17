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
                    ->get()
                    ->map(function($tratamiento) {
                        // Modificar las fechas para que solo se incluya la fecha (sin la hora)
                        $tratamiento->fecha_inicio = Carbon::parse($tratamiento->fecha_inicio)->toDateString();
                        $tratamiento->fecha_fin = Carbon::parse($tratamiento->fecha_fin)->toDateString();
                        return $tratamiento;
                    });

    // Obtener las vacunaciones de la vaca específica
    $vacunaciones = HistorialMedico::where('vaca_id', $vaca_id)
                    ->where('tipo', 'vacunación')
                    ->get()
                    ->map(function($vacunacion) {
                        // Modificar las fechas para que solo se incluya la fecha (sin la hora)
                        $vacunacion->fecha_inicio = Carbon::parse($vacunacion->fecha_inicio)->toDateString();
                        $vacunacion->fecha_fin = Carbon::parse($vacunacion->fecha_fin)->toDateString();
                        return $vacunacion;
                    });

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
    $fecha_inicio = Carbon::parse($validated['fecha_inicio'])->toDateString(); // Formato 'YYYY-MM-DD'
    $fecha_fin = Carbon::parse($validated['fecha_inicio'])->addDays($validated['dias_tratamiento'])->toDateString(); // Formato 'YYYY-MM-DD'

    // Crear un nuevo historial médico
    $historial = new HistorialMedico();
    $historial->vaca_id = $validated['vaca_id'];
    $historial->descripcion = $validated['descripcion'];
    $historial->tipo = $validated['tipo'];
    $historial->medicamento = $validated['medicamento'];
    $historial->fecha_inicio = $fecha_inicio;  // Guardar solo la fecha
    $historial->fecha_fin = $fecha_fin;        // Guardar solo la fecha
    $historial->notas = $validated['notas'];
    $historial->save();

    return response()->json(['message' => 'Diagnóstico agregado exitosamente', 'data' => $historial], 201);
}

    public function obtenerVacasEnTratamientoHoy($productor_id)
{
    // Fecha actual
    $fechaHoy = Carbon::today();

    // Obtener las vacas en tratamiento para el productor específico
    $vacasEnTratamiento = HistorialMedico::where('tipo', 'tratamiento')
        ->whereDate('fecha_inicio', '<=', $fechaHoy)
        ->whereDate('fecha_fin', '>=', $fechaHoy)
        ->whereHas('vaca', function($query) use ($productor_id) {
            $query->where('productor_id', $productor_id); // Filtra las vacas por productor_id
        })
        ->with('vaca') // Suponiendo que tienes una relación de 'vaca' en el modelo HistorialMedico
        ->get();

    // Obtener los nombres de las vacas en tratamiento
    $nombresVacasEnTratamiento = $vacasEnTratamiento->pluck('vaca.nombre'); // Suponiendo que 'nombre' es el campo en el modelo Vaca

    return response()->json([
        'vacas_en_tratamiento' => $vacasEnTratamiento->count(),
        'nombres_vacas_en_tratamiento' => $nombresVacasEnTratamiento
    ]);
}



}

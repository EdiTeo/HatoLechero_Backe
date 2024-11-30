<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reproduccion;
use Carbon\Carbon; // Importa la clase Carbon para trabajar con fechas

class ReproduccionController extends Controller
{
    public function index()
    {
        return Reproduccion::all();
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'vaca_id' => 'required|exists:vacas,vaca_id',
            'fecha_inseminacion' => 'required|date',
            'raza_toro' => 'required|string|max:255',
        ]);

        try {
            // Calcular las fechas
            $fechaInseminacion = Carbon::parse($validatedData['fecha_inseminacion']);
            $fechaEstimadaParto = $fechaInseminacion->copy()->addMonths(9); // Parto 9 meses después
            $fechaRevision = $fechaInseminacion->copy()->addMonths(3); // Revisión 3 meses después
            $fechaSecado = $fechaInseminacion->copy()->addMonths(7); // Secado 7 meses después

            // Crear el registro en la base de datos
            $reproduccion = Reproduccion::create([
                'vaca_id' => $validatedData['vaca_id'],
                'fecha_inseminacion' => $validatedData['fecha_inseminacion'],
                'fecha_estimada_parto' => $fechaEstimadaParto,
                'fecha_revision' => $fechaRevision,
                'fecha_secado' => $fechaSecado,
                'raza_toro' => $validatedData['raza_toro'],
            ]);

            // Retornar la respuesta con los datos creados
            return response()->json([
                'message' => 'Reproducción registrada con éxito.',
                'data' => $reproduccion,
            ], 201);
        } catch (\Exception $e) {
            // Manejar errores inesperados
            return response()->json([
                'message' => 'Ocurrió un error al registrar la reproducción.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // ReproduccionController.php

public function obtenerInseminacionPendiente($vacaId)
{
    // Buscar la inseminación pendiente para la vaca con estado_parto = null
    $reproduccion = Reproduccion::where('vaca_id', $vacaId)
        ->whereNull('estado_parto')  // Aseguramos que la inseminación está pendiente
        ->first();

    // Si no hay una inseminación pendiente
    if (!$reproduccion) {
        return response()->json([
            'mensaje' => 'No hay inseminación pendiente para esta vaca.'
        ], 404);
    }

    // Si hay una inseminación pendiente, devolvemos la información
    return response()->json([
        'reproduccion_id' => $reproduccion->reproduccion_id,
        'mensaje' => 'Inseminación pendiente encontrada.'
    ]);
}
public function actualizarParto(Request $request, $reproduccion_id)
{
    // Valida los datos de entrada
    $validated = $request->validate([
        'fecha_real_parto' => 'required|date',
        'estado_parto' => 'required|in:normal,prematuro,aborto',  // Agrega más valores si es necesario
    ]);

    try {
        // Encuentra el registro de reproducción por ID
        $reproduccion = Reproduccion::findOrFail($reproduccion_id);

        // Actualiza los campos
        $reproduccion->fecha_real_parto = $validated['fecha_real_parto'];
        $reproduccion->estado_parto = $validated['estado_parto'];

        // Guarda los cambios
        $reproduccion->save();

        return response()->json(['mensaje' => 'Parto actualizado correctamente.'], 200);

    } catch (\Exception $e) {
        return response()->json(['mensaje' => 'Ocurrió un error al actualizar los detalles del parto.', 'error' => $e->getMessage()], 500);
    }
}

public function contarVacasPrenadas()
{
    // Contamos las vacas asociadas a reproducciones que no tengan fecha_real_parto ni estado_parto
    $vacasPreñadas = Reproduccion::whereNull('fecha_real_parto')
                                ->whereNull('estado_parto')
                                ->count();

    // Devolvemos la cantidad de vacas preñadas como respuesta JSON
    return response()->json(['vacas_preñadas' => $vacasPreñadas]);
}




}

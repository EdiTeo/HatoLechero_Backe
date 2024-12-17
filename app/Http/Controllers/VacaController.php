<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaca;

class VacaController extends Controller
{
    public function index($productor_id)
{
    // Filtrar las vacas por productor_id
    $vacas = Vaca::where('productor_id', $productor_id)->get();

    return response()->json($vacas);
}

    public function store(Request $request)
{
    try {
        // Validar los datos
        $validated = $request->validate([
            'productor_id' => 'required|exists:productores,productor_id',
            'nombre' => 'required|string|max:100',
            'etapa_de_crecimiento' => 'required|in:ternero,juvenil,adulto,cria',
            'estado_reproductivo' => 'required|in:gestante,no_gestante,en_lactancia,seco',
            'raza' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:activa,inactiva',
        ]);
    
        // Insertar los datos usando Eloquent
        $vaca = Vaca::create($validated);
    
        return response()->json([
            'message' => 'Vaca registrada exitosamente',
            'data' => $vaca,
        ], 201);
    
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'error' => 'Datos inválidos',
            'details' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Ocurrió un error al registrar la vaca',
            'details' => $e->getMessage(),
        ], 500);
    }
    
}
public function contarPorEtapaDeCrecimientoYEstadoReproductivo($productor_id)
{
    try {
        // Conteo por etapa de crecimiento filtrado por productor_id
        $conteoEtapas = Vaca::select('etapa_de_crecimiento', \DB::raw('count(*) as total'))
            ->where('productor_id', $productor_id)  // Filtrar por productor_id
            ->groupBy('etapa_de_crecimiento')
            ->get();

        // Conteo por estado reproductivo con los nombres de las vacas filtrado por productor_id
        $conteoEstadosReproductivos = Vaca::select('estado_reproductivo', \DB::raw('count(*) as total'))
            ->where('productor_id', $productor_id)  // Filtrar por productor_id
            ->groupBy('estado_reproductivo')
            ->get()
            ->map(function($item) use ($productor_id) {
                // Obtener los nombres de las vacas para el estado reproductivo actual filtrado por productor_id
                $nombresVacas = Vaca::where('estado_reproductivo', $item->estado_reproductivo)
                    ->where('productor_id', $productor_id)  // Filtrar por productor_id
                    ->pluck('nombre'); // Pluck nos da una colección con los nombres de las vacas

                // Añadir los nombres de las vacas al resultado
                $item->nombres_vacas = $nombresVacas;
                return $item;
            });

        // Verifica el contenido antes de enviarlo
        \Log::info("Conteo de etapas: ", $conteoEtapas->toArray());
        \Log::info("Conteo de estados reproductivos: ", $conteoEstadosReproductivos->toArray());

        return response()->json([
            'etapas' => $conteoEtapas,
            'estados_reproductivos' => $conteoEstadosReproductivos
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function update(Request $request, $vaca_id)
{
    try {
        // Validar los datos que se van a actualizar
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'etapa_de_crecimiento' => 'required|in:ternero,juvenil,adulto,cria',
            'estado_reproductivo' => 'required|in:gestante,no_gestante,en_lactancia,seco',
            'raza' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'estado' => 'required|in:activa,inactiva',
        ]);

        // Buscar la vaca por su ID
        $vaca = Vaca::findOrFail($vaca_id);

        // Actualizar los datos de la vaca
        $vaca->update($validated);

        // Devolver la respuesta exitosa
        return response()->json([
            'message' => 'Vaca actualizada exitosamente',
            'data' => $vaca,
        ], 200);
    } catch (\Exception $e) {
        // Manejar el error y devolver la respuesta
        return response()->json([
            'error' => 'Ocurrió un error al actualizar la vaca',
            'details' => $e->getMessage(),
        ], 500);
    }
}
public function destroy($vaca_id)
{
    try {
        // Buscar la vaca por su ID
        $vaca = Vaca::findOrFail($vaca_id);

        // Eliminar la vaca
        $vaca->delete();

        // Respuesta exitosa
        return response()->json([
            'message' => 'Vaca eliminada exitosamente',
        ], 200);
    } catch (\Exception $e) {
        // Manejar el error y devolver la respuesta
        return response()->json([
            'error' => 'Ocurrió un error al eliminar la vaca',
            'details' => $e->getMessage(),
        ], 500);
    }
}



}

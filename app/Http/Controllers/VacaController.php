<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaca;

class VacaController extends Controller
{
    public function index(){
        return Vaca::all();
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
            'fecha_nacimiento' => 'required|date',
            'estado' => 'required|in:activa,inactiva',
        ]);

        // Crear la vaca y guardarla en la base de datos
        $vaca = Vaca::create($validated);

        // Devolver la respuesta exitosa
        return response()->json([
            'message' => 'Vaca registrada exitosamente',
            'data' => $vaca,
        ], 201);
    } catch (\Exception $e) {
        // Manejar el error y devolver la respuesta
        return response()->json([
            'error' => 'Ocurrió un error al registrar la vaca',
            'details' => $e->getMessage(),
        ], 500);
    }
}
public function contarPorEtapaDeCrecimientoYEstadoReproductivo()
{
    try {
        // Conteo por etapa de crecimiento
        $conteoEtapas = Vaca::select('etapa_de_crecimiento', \DB::raw('count(*) as total'))
            ->groupBy('etapa_de_crecimiento')
            ->get();

        // Conteo por estado reproductivo
        $conteoEstadosReproductivos = Vaca::select('estado_reproductivo', \DB::raw('count(*) as total'))
            ->groupBy('estado_reproductivo')
            ->get();

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

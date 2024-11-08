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
public function contarPorEtapaDeCrecimiento()
{
    $conteoEtapas = Vaca::select('etapa_de_crecimiento', \DB::raw('count(*) as total'))
        ->groupBy('etapa_de_crecimiento')
        ->get();

    return response()->json([
        'data' => $conteoEtapas
    ]);
}


}

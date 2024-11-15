<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaca;
use Illuminate\Support\Facades\DB;

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
            $conteoEtapas = Vaca::select('etapa_de_crecimiento', DB::raw('count(*) as total'))
                ->groupBy('etapa_de_crecimiento')
                ->get();

            return response()->json([
                'data' => $conteoEtapas
            ]);
        }
        //ver
    public function show($id)
        {
            $vaca = Vaca::find($id);

            if ($vaca) {
                return response()->json($vaca);
            } else {
                return response()->json(['error' => 'Vaca no encontrada'], 404);
            }
    }

    //Actualizar datos de una vaca 
    public function update(Request $request, $id)
    {
        $vaca = Vaca::find($id);

        if (!$vaca) {
            return response()->json(['error' => 'Vaca no encontrada'], 404);
        }

        try {
            $validated = $request->validate([
                'productor_id' => 'exists:productores,productor_id',
                'nombre' => 'string|max:100',
                'etapa_de_crecimiento' => 'in:ternero,juvenil,adulto,cria',
                'estado_reproductivo' => 'in:gestante,no_gestante,en_lactancia,seco',
                'raza' => 'string|max:50',
                'fecha_nacimiento' => 'date',
                'estado' => 'in:activa,inactiva',
            ]);

            $vaca->update($validated);

            return response()->json([
                'message' => 'Vaca actualizada exitosamente',
                'data' => $vaca,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al actualizar la vaca',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    //Para eliminar
    public function destroy($id)
    {
        $vaca = Vaca::find($id);

        if (!$vaca) {
            return response()->json(['error' => 'Vaca no encontrada'], 404);
        }

        try {
            $vaca->delete();

            return response()->json(['message' => 'Vaca eliminada exitosamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al eliminar la vaca',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
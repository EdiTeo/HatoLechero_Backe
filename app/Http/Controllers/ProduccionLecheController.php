<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produccion_Leche;
use Illuminate\Support\Facades\DB;

class ProduccionLecheController extends Controller
{
    public function index(){
        return Produccion_Leche::all();
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'productor_id' => 'required|exists:productores,productor_id',
        'cantidad_animales' => 'required|integer|min:1',
        'cantidad_litros' => 'required|numeric|min:0',
        'fecha_produccion' => 'required|date',
        'tipo_ordeño' => 'required|in:mañana,tarde,ambos',
    ]);
    

    Produccion_Leche::create($validatedData);

    return response()->json(['message' => 'Datos guardados correctamente']);
}
public function getProduccionHoy()
{
    // Obtener la fecha actual
    $fechaHoy = now()->toDateString();

    // Recuperar todos los registros de producción de leche para hoy
    $produccionHoy = Produccion_Leche::whereDate('fecha_produccion', $fechaHoy)->get();

    if ($produccionHoy->isEmpty()) {
        return response()->json([
            'fecha' => $fechaHoy,
            'total_leche' => 0,
            'total_animales' => 0,
        ]);
    }

    // Buscar si existe un registro con tipo de ordeño "ambos"
    $produccionAmbos = $produccionHoy->where('tipo_ordeño', 'ambos')->first();

    if ($produccionAmbos) {
        // Si existe "ambos", usar esos valores directamente
        $totalLeche = $produccionAmbos->cantidad_litros;
        $totalAnimales = $produccionAmbos->cantidad_animales;
    } else {
        // Si no existe "ambos", combinar registros de "mañana" y "tarde"
        $produccionManana = $produccionHoy->where('tipo_ordeño', 'mañana')->first();
        $produccionTarde = $produccionHoy->where('tipo_ordeño', 'tarde')->first();

        $totalLeche = 0;
        $totalAnimales = 0;
        $count = 0;

        if ($produccionManana) {
            $totalLeche += $produccionManana->cantidad_litros;
            $totalAnimales += $produccionManana->cantidad_animales;
            $count++;
        }

        if ($produccionTarde) {
            $totalLeche += $produccionTarde->cantidad_litros;
            $totalAnimales += $produccionTarde->cantidad_animales;
            $count++;
        }

        // Calcular el promedio si hay más de un registro
        if ($count > 0) {
            $totalAnimales = $totalAnimales / $count;
        }
    }

    // Retornar el resultado
    return response()->json([
        'fecha' => $fechaHoy,
        'total_leche' => $totalLeche,
        'total_animales' => $totalAnimales,
    ]);
}
public function getProduccionPorFecha(Request $request)
{
    // Validar que la fecha esté presente en la solicitud
    $request->validate([
        'fecha' => 'required|date', // Aseguramos que la fecha sea válida
    ]);

    // Obtener la fecha pasada por el usuario
    $fechaSeleccionada = $request->input('fecha');

    // Recuperar todos los registros de producción de leche para la fecha seleccionada
    $produccionSeleccionada = Produccion_Leche::whereDate('fecha_produccion', $fechaSeleccionada)->get();

    if ($produccionSeleccionada->isEmpty()) {
        return response()->json([
            'fecha' => $fechaSeleccionada,
            'total_leche' => 0,
            'total_animales' => 0,
        ]);
    }

    // Buscar si existe un registro con tipo de ordeño "ambos"
    $produccionAmbos = $produccionSeleccionada->where('tipo_ordeño', 'ambos')->first();

    if ($produccionAmbos) {
        // Si existe "ambos", usar esos valores directamente
        $totalLeche = $produccionAmbos->cantidad_litros;
        $totalAnimales = $produccionAmbos->cantidad_animales;
    } else {
        // Si no existe "ambos", combinar registros de "mañana" y "tarde"
        $produccionManana = $produccionSeleccionada->where('tipo_ordeño', 'mañana')->first();
        $produccionTarde = $produccionSeleccionada->where('tipo_ordeño', 'tarde')->first();

        $totalLeche = 0;
        $totalAnimales = 0;
        $count = 0;

        if ($produccionManana) {
            $totalLeche += $produccionManana->cantidad_litros;
            $totalAnimales += $produccionManana->cantidad_animales;
            $count++;
        }

        if ($produccionTarde) {
            $totalLeche += $produccionTarde->cantidad_litros;
            $totalAnimales += $produccionTarde->cantidad_animales;
            $count++;
        }

        // Calcular el promedio si hay más de un registro
        if ($count > 0) {
            $totalAnimales = $totalAnimales / $count;
        }
    }

    // Retornar el resultado para la fecha seleccionada
    return response()->json([
        'fecha' => $fechaSeleccionada,
        'total_leche' => $totalLeche,
        'total_animales' => $totalAnimales,
    ]);
}

public function getProduccionMensual()
{
    // Obtener el mes y año actuales
    $mesActual = now()->month;
    $añoActual = now()->year;

    // Obtener los registros del mes actual
    $produccionMensual = Produccion_Leche::whereYear('fecha_produccion', $añoActual)
        ->whereMonth('fecha_produccion', $mesActual)
        ->get();

    // Agrupar por fecha y procesar cada día
    $resultadosDiarios = [];
    $totalLecheMes = 0;
    $totalAnimalesMes = 0;

    foreach ($produccionMensual->groupBy('fecha_produccion') as $fecha => $registros) {
        // Buscar si existe un registro con tipo de ordeño "ambos"
        $produccionAmbos = $registros->where('tipo_ordeño', 'ambos')->first();

        if ($produccionAmbos) {
            $totalLeche = $produccionAmbos->cantidad_litros;
            $totalAnimales = $produccionAmbos->cantidad_animales;
        } else {
            // Si no existe "ambos", combinar registros de "mañana" y "tarde"
            $produccionManana = $registros->where('tipo_ordeño', 'mañana')->first();
            $produccionTarde = $registros->where('tipo_ordeño', 'tarde')->first();

            $totalLeche = 0;
            $totalAnimales = 0;
            $count = 0;

            if ($produccionManana) {
                $totalLeche += $produccionManana->cantidad_litros;
                $totalAnimales += $produccionManana->cantidad_animales;
                $count++;
            }

            if ($produccionTarde) {
                $totalLeche += $produccionTarde->cantidad_litros;
                $totalAnimales += $produccionTarde->cantidad_animales;
                $count++;
            }

            if ($count > 0) {
                $totalAnimales = $totalAnimales / $count;
            }
        }

        // Sumar los totales mensuales
        $totalLecheMes += $totalLeche;
        $totalAnimalesMes += $totalAnimales;

        // Guardar el resultado diario
        $resultadosDiarios[] = [
            'fecha' => $fecha,
            'total_leche' => $totalLeche,
            'total_animales' => round($totalAnimales, 2),
        ];
    }

    // Calcular promedios mensuales
    $diasConRegistro = count($resultadosDiarios);
    $promedioAnimales = $diasConRegistro > 0 ? $totalAnimalesMes / $diasConRegistro : 0;
    $promedioLecheDiaria = $diasConRegistro > 0 ? $totalLecheMes / $diasConRegistro : 0;

    // Retornar el resultado
    return response()->json([
        'mes' => $mesActual,
        'año' => $añoActual,
        'dias_con_registro' => $diasConRegistro,
        'total_leche' => $totalLecheMes,
        'promedio_animales' => round($promedioAnimales, 2),
        'promedio_leche_diaria' => round($promedioLecheDiaria, 2),
        'detalles_diarios' => $resultadosDiarios,
    ]);
}
public function getProduccionMensual1(Request $request)
    {
        // Obtener el mes desde los parámetros de la solicitud
        $mesSeleccionado = $request->input('mes');
        
        // Obtener el año actual automáticamente
        $añoSeleccionado = now()->year;

        // Verificar si el mes proporcionado es válido
        if (!$mesSeleccionado || $mesSeleccionado < 1 || $mesSeleccionado > 12) {
            return response()->json(['error' => 'Mes inválido'], 400);
        }

        // Obtener los registros del mes seleccionado y el año actual
        $produccionMensual = Produccion_Leche::whereYear('fecha_produccion', $añoSeleccionado)
            ->whereMonth('fecha_produccion', $mesSeleccionado)
            ->get();

        // Agrupar por fecha y procesar cada día
        $resultadosDiarios = [];
        $totalLecheMes = 0;
        $totalAnimalesMes = 0;

        foreach ($produccionMensual->groupBy('fecha_produccion') as $fecha => $registros) {
            // Buscar si existe un registro con tipo de ordeño "ambos"
            $produccionAmbos = $registros->where('tipo_ordeño', 'ambos')->first();

            if ($produccionAmbos) {
                $totalLeche = $produccionAmbos->cantidad_litros;
                $totalAnimales = $produccionAmbos->cantidad_animales;
            } else {
                // Si no existe "ambos", combinar registros de "mañana" y "tarde"
                $produccionManana = $registros->where('tipo_ordeño', 'mañana')->first();
                $produccionTarde = $registros->where('tipo_ordeño', 'tarde')->first();

                $totalLeche = 0;
                $totalAnimales = 0;
                $count = 0;

                if ($produccionManana) {
                    $totalLeche += $produccionManana->cantidad_litros;
                    $totalAnimales += $produccionManana->cantidad_animales;
                    $count++;
                }

                if ($produccionTarde) {
                    $totalLeche += $produccionTarde->cantidad_litros;
                    $totalAnimales += $produccionTarde->cantidad_animales;
                    $count++;
                }

                if ($count > 0) {
                    $totalAnimales = $totalAnimales / $count;
                }
            }

            // Sumar los totales mensuales
            $totalLecheMes += $totalLeche;
            $totalAnimalesMes += $totalAnimales;

            // Guardar el resultado diario
            $resultadosDiarios[] = [
                'fecha' => $fecha,
                'total_leche' => $totalLeche,
                'total_animales' => round($totalAnimales, 2),
            ];
        }

        // Calcular promedios mensuales
        $diasConRegistro = count($resultadosDiarios);
        $promedioAnimales = $diasConRegistro > 0 ? $totalAnimalesMes / $diasConRegistro : 0;
        $promedioLecheDiaria = $diasConRegistro > 0 ? $totalLecheMes / $diasConRegistro : 0;

        // Retornar el resultado
        return response()->json([
            'mes' => $mesSeleccionado,
            'año' => $añoSeleccionado,
            'dias_con_registro' => $diasConRegistro,
            'total_leche' => $totalLecheMes,
            'promedio_animales' => round($promedioAnimales, 2),
            'promedio_leche_diaria' => round($promedioLecheDiaria, 2),
            'detalles_diarios' => $resultadosDiarios,
        ]);
    }

}

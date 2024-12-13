<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ActualizarEtapaCrecimiento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $vacas = \App\Models\Vaca::all();

        foreach ($vacas as $vaca) {
            $meses = Carbon::now()->diffInMonths($vaca->fecha_nacimiento);

            // Determinar la etapa de crecimiento
            if ($meses < 7) {
                $vaca->etapa_de_crecimiento = 'cria';
            } elseif ($meses >= 7 && $meses < 12) {
                $vaca->etapa_de_crecimiento = 'ternero';
            } elseif ($meses >= 12 && $meses < 15) {
                $vaca->etapa_de_crecimiento = 'juvenil';
            } else {
                $vaca->etapa_de_crecimiento = 'adulto';
            }

            // Si la vaca es adulta, marcarla como gestante
            if ($vaca->etapa_de_crecimiento == 'adulto') {
                $vaca->estado_reproductivo = 'gestante';
            } else {
                $vaca->estado_reproductivo = 'no gestante';
            }

            // Guardar los cambios en la vaca
            $vaca->save();
        }
    }
}

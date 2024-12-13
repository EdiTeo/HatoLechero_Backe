<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizarEtapaCrecimiento extends Command
{
    protected $signature = 'vacasyetapa:actualizar';
    protected $description = 'Actualizar la etapa de crecimiento de las vacas';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('vacas')->update(['fecha_nacimiento' => DB::raw('fecha_nacimiento')]);

        $this->info('Etapa de crecimiento de las vacas actualizada.');
    }
}

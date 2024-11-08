<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE vacas MODIFY COLUMN etapa_de_crecimiento ENUM('ternero', 'juvenil', 'adulto', 'cria')");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE vacas MODIFY COLUMN etapa_de_crecimiento ENUM('ternero', 'juvenil', 'adulto')");

    }
};

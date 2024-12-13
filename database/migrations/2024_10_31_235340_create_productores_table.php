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
        Schema::create('productores', function (Blueprint $table) {
            $table->id('productor_id'); // ID único para el productor
            $table->string('nombre', 255); // Nombre del productor
            $table->string('celular', 10)->nullable(); // Celular del productor (opcional)
            $table->string('email', 255)->nullable(); // Correo electrónico del productor (opcional)
            $table->time('hora_inicio_ordeño')->nullable(); // Hora de inicio del ordeño (opcional)
            $table->time('hora_fin_ordeño')->nullable(); // Hora de fin del ordeño (opcional)
            $table->timestamps(); // Timestamps de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productores');
    }
};

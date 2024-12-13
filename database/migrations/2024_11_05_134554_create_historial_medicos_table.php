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
        Schema::create('historial_medicos', function (Blueprint $table) {
            $table->id('tratamiento_id');
            $table->unsignedBigInteger('vaca_id'); 
            $table->foreign('vaca_id')->references('vaca_id')->on('vacas')->onDelete('cascade');
            $table->text('descripcion');
            $table->enum('tipo', ['tratamiento', 'vacunación', 'fallecimiento']);
            $table->string('medicamento')->nullable(); // Columna para almacenar el medicamento
            $table->text('notas')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_medicos');
    }
};

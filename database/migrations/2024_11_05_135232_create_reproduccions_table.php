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
        Schema::create('reproduccions', function (Blueprint $table) {
            $table->id('reproduccion_id');
            $table->unsignedBigInteger('vaca_id'); 
            $table->foreign('vaca_id')->references('vaca_id')->on('vacas')->onDelete('cascade');
            $table->date('fecha_inseminacion');
            $table->date('fecha_estimada_parto');
            $table->date('fecha_real_parto')->nullable();
            $table->enum('estado_parto', ['normal', 'prematuro', 'aborto','fracaso'])->nullable();// añadir fracaso
            // Campos nuevos solicitados
            $table->date('fecha_secado')->nullable(); // Fecha de secado
            $table->date('fecha_revision')->nullable(); // Fecha de revisión
            $table->string('raza_toro')->nullable(); // Raza del toro
            $table->text('nota')->nullable(); // Nota adicional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reproduccions');
    }
};

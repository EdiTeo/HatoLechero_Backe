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
            $table->boolean('fue_prematuro')->default(false);
            $table->enum('estado_parto', ['normal', 'prematuro', 'aborto']);
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

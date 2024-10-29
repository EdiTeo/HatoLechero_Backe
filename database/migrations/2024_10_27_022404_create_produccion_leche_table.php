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
        Schema::create('produccion_leche', function (Blueprint $table) {
            $table->id('produccion_id');
            $table->unsignedBigInteger('vaca_id'); 
            $table->foreign('vaca_id')->references('vaca_id')->on('vacas')->onDelete('cascade');
            $table->float('cantidad_litros');
            $table->date('fecha_produccion');
            $table->enum('tipo_ordeño', ['mañana', 'tarde', 'ambos']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produccion_leche');
    }
};

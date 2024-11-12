<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('vacas', function (Blueprint $table) {
            $table->id('vaca_id');  
            $table->unsignedBigInteger('productor_id');  
            $table->foreign('productor_id')->references('productor_id')->on('productores')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->enum('etapa_de_crecimiento', ['ternero', 'juvenil', 'adulto']);
            $table->enum('estado_reproductivo', ['gestante', 'no_gestante', 'en_lactancia', 'seco']);
            $table->string('raza', 50);
            $table->date('fecha_nacimiento');
            $table->enum('estado', ['activa', 'inactiva']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacas');
    }
};

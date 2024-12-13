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
        Schema::create('produccion__leches', function (Blueprint $table) {
            $table->id('produccion_id');
            $table->unsignedBigInteger('productor_id'); // Cambiar vaca_id a productor_id
            $table->foreign('productor_id')->references('productor_id')->on('productores')->onDelete('cascade'); // Actualizar referencia de clave foránea
            $table->integer('cantidad_animales');
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
        Schema::dropIfExists('produccion__leches');
    }
};

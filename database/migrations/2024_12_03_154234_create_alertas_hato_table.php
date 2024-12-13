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
        Schema::create('alertas_hato', function (Blueprint $table) {
            $table->id('id_alerta');
            $table->unsignedBigInteger('productor_id');
            $table->date('fecha_alerta');
            $table->string('tipo_alerta');
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->foreign('productor_id')->references('productor_id')->on('productores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas_hato');
    }
};

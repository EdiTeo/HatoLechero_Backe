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
        Schema::create('alertas', function (Blueprint $table) {
            $table->id('alerta_id');
            $table->unsignedBigInteger('vaca_id'); 
            $table->foreign('vaca_id')->references('vaca_id')->on('vacas')->onDelete('cascade');
            $table->text('mensaje');
            $table->enum('tipo_alerta', ['tratamiento', 'antibiótico', 'parto']);
            $table->timestamp('fecha_alerta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};

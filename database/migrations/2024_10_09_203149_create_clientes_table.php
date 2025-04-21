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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del cliente
            $table->string('telefono')->nullable(); // Teléfono del cliente
            $table->string('barrio')->nullable(); // barrio del cliente
            $table->string('direccion'); // Dirección del cliente
            $table->string('notas')->nullable(); // Notas adicionales sobre el cliente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

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
        Schema::create('cierres_caja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja'); // Asegúrate de que sea unsignedBigInteger
            $table->foreign('id_caja')->references('id')->on('num_caja')->onDelete('cascade');
            $table->enum('turno', ['dia', 'noche']);
            $table->date('fecha');
            $table->decimal('monto_inicial', 10, 2);
            $table->decimal('monto_final', 10, 2);
            $table->decimal('total_ventas', 10, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierres_caja');
    }
};

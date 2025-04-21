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
        Schema::create('venta_medio_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('id_medio_pago');
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('id_medioPago')->references('id')->on('medio_pago')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_medio_pago');
    }
};

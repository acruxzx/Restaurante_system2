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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('venta');

            $table->unsignedBigInteger('id_medioPago');
            $table->foreign('id_medioPago')->references('id')->on('medio_pago')->onDelete('cascade');

            $table->unsignedBigInteger('id_caja');
            $table->foreign('id_caja')->references('id')->on('medio_pago')->onDelete('cascade');

            
            $table->unsignedBigInteger('id_productoPedido');
            $table->foreign('id_productoPedido')->references('id')->on('producto_pedidos')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};

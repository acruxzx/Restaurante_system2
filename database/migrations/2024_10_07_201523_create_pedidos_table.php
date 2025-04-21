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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('pedido');
            $table->dateTime('entrega');
            $table->unsignedBigInteger('id_trabajador');
            $table->foreign('id_trabajador')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_estadoPedido');
            $table->foreign('id_estadoPedido')->references('id')->on('estado_pedidos')->onDelete('cascade');

            $table->unsignedBigInteger('id_tp_pedido');
            $table->foreign('id_tp_pedido')->references('id')->on('tp_pedido')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

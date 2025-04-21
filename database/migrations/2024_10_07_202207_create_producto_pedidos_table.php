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
        Schema::create('producto_pedidos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_precio');
            $table->foreign('id_precio')->references('id')->on('precios')->onDelete('cascade');

            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('cascade');

            $table->double('cantidad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_pedidos');
    }
};

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
        Schema::create('caja', function (Blueprint $table) {
            $table->id();
            $table->double('egreso');
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->unsignedBigInteger('id_trabajador');
            $table->foreign('id_trabajador')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_num_caja');
            $table->foreign('id_num_caja')->references('id')->on('num_caja')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja');
    }
};

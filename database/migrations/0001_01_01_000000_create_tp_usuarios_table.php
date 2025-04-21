<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 2024_10_07_193937
     */
    public function up(): void
    {
        Schema::create('tp_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('rol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tp_usuarios');
    }
};

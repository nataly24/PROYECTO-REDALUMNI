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
        Schema::create('paginas_web', function (Blueprint $table) {
            $table->integer('id_pagina', true);
            $table->enum('entidad_tipo', ['Exalumno', 'Empresa']);
            $table->integer('entidad_id');
            $table->string('titulo', 100);
            $table->string('url');

            $table->unique(['entidad_tipo', 'entidad_id', 'url'], 'entidad_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paginas_web');
    }
};

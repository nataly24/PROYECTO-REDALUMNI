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
        Schema::create('formacion_academica', function (Blueprint $table) {
            $table->integer('id_formacion', true);
            $table->integer('id_exalumno')->index('id_exalumno');
            $table->enum('tipo', ['Bachillerato', 'Pregrado', 'Posgrado', 'Curso']);
            $table->string('titulo_obtenido')->nullable();
            $table->string('institucion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacion_academica');
    }
};

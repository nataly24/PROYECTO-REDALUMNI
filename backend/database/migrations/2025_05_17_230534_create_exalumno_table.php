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
        Schema::create('exalumno', function (Blueprint $table) {
            $table->integer('id_exalumno', true);
            $table->integer('id_persona')->index('id_persona');
            $table->string('ci', 20)->unique('ci');
            $table->string('codigo_carrera', 20);
            $table->string('carrera', 100);
            $table->string('facultad', 100);
            $table->enum('estado_academico', ['Egresado', 'Titulado'])->nullable()->default('Egresado');
            $table->date('fecha_colacion')->nullable();
            $table->string('ciudad_residencia', 100)->nullable();
            $table->string('telefono_contacto', 20)->nullable();
            $table->string('linkedin')->nullable();
            $table->text('perfil_profesional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exalumno');
    }
};

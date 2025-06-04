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
        Schema::create('habilidades', function (Blueprint $table) {
            $table->integer('id_habilidad', true);
            $table->integer('id_exalumno')->index('id_exalumno');
            $table->string('nombre', 100)->nullable();
            $table->enum('tipo', ['Técnica', 'Blanda', 'Idioma'])->nullable();
            $table->enum('nivel', ['Básico', 'Intermedio', 'Avanzado'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habilidades');
    }
};

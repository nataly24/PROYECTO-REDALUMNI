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
        Schema::create('competencias', function (Blueprint $table) {
            $table->integer('id_competencia', true);
            $table->integer('id_exalumno')->index('id_exalumno');
            $table->string('herramienta', 100);
            $table->enum('nivel', ['Básico', 'Intermedio', 'Avanzado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencias');
    }
};

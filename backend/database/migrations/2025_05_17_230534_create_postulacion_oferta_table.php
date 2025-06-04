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
        Schema::create('postulacion_oferta', function (Blueprint $table) {
            $table->integer('id_postulacion', true);
            $table->integer('id_exalumno');
            $table->integer('id_oferta')->index('id_oferta');
            $table->dateTime('fecha_postulacion')->nullable()->useCurrent();
            $table->enum('estado', ['Enviada', 'Revisada', 'Aceptado', 'Rechazado'])->nullable()->default('Enviada');
            $table->text('observaciones')->nullable();

            $table->unique(['id_exalumno', 'id_oferta'], 'id_exalumno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulacion_oferta');
    }
};

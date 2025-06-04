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
        Schema::create('auditoria_estado_academico', function (Blueprint $table) {
            $table->integer('id_auditoria', true);
            $table->integer('id_exalumno')->index('id_exalumno');
            $table->enum('estado_anterior', ['Egresado', 'Titulado'])->nullable();
            $table->enum('estado_nuevo', ['Egresado', 'Titulado'])->nullable();
            $table->dateTime('fecha_cambio')->nullable()->useCurrent();
            $table->integer('cambiado_por')->index('cambiado_por');
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_estado_academico');
    }
};

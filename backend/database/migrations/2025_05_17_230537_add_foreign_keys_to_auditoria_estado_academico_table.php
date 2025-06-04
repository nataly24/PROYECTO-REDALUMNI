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
        Schema::table('auditoria_estado_academico', function (Blueprint $table) {
            $table->foreign(['id_exalumno'], 'auditoria_estado_academico_ibfk_1')->references(['id_exalumno'])->on('exalumno')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['cambiado_por'], 'auditoria_estado_academico_ibfk_2')->references(['id_usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auditoria_estado_academico', function (Blueprint $table) {
            $table->dropForeign('auditoria_estado_academico_ibfk_1');
            $table->dropForeign('auditoria_estado_academico_ibfk_2');
        });
    }
};

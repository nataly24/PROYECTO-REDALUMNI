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
        Schema::table('postulacion_oferta', function (Blueprint $table) {
            $table->foreign(['id_exalumno'], 'postulacion_oferta_ibfk_1')->references(['id_exalumno'])->on('exalumno')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_oferta'], 'postulacion_oferta_ibfk_2')->references(['id_oferta'])->on('oferta_laboral')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postulacion_oferta', function (Blueprint $table) {
            $table->dropForeign('postulacion_oferta_ibfk_1');
            $table->dropForeign('postulacion_oferta_ibfk_2');
        });
    }
};

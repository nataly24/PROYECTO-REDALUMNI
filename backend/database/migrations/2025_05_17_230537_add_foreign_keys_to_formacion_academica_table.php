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
        Schema::table('formacion_academica', function (Blueprint $table) {
            $table->foreign(['id_exalumno'], 'formacion_academica_ibfk_1')->references(['id_exalumno'])->on('exalumno')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formacion_academica', function (Blueprint $table) {
            $table->dropForeign('formacion_academica_ibfk_1');
        });
    }
};

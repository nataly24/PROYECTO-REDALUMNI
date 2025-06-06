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
        Schema::table('experiencia_laboral', function (Blueprint $table) {
            $table->foreign(['id_exalumno'], 'experiencia_laboral_ibfk_1')->references(['id_exalumno'])->on('exalumno')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiencia_laboral', function (Blueprint $table) {
            $table->dropForeign('experiencia_laboral_ibfk_1');
        });
    }
};

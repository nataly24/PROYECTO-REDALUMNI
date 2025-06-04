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
        Schema::table('habilidades', function (Blueprint $table) {
            $table->foreign(['id_exalumno'], 'habilidades_ibfk_1')->references(['id_exalumno'])->on('exalumno')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habilidades', function (Blueprint $table) {
            $table->dropForeign('habilidades_ibfk_1');
        });
    }
};

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
        Schema::table('ingreso_subenil', function (Blueprint $table) {
            $table->foreign(['id_item'], 'ingreso_subenil_ibfk_1')->references(['id_item'])->on('subenil')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ingresado_por'], 'ingreso_subenil_ibfk_2')->references(['id_usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingreso_subenil', function (Blueprint $table) {
            $table->dropForeign('ingreso_subenil_ibfk_1');
            $table->dropForeign('ingreso_subenil_ibfk_2');
        });
    }
};

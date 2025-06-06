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
        Schema::table('salida_subenil', function (Blueprint $table) {
            $table->foreign(['id_item'], 'salida_subenil_ibfk_1')->references(['id_item'])->on('subenil')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['entregado_por'], 'salida_subenil_ibfk_2')->references(['id_usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salida_subenil', function (Blueprint $table) {
            $table->dropForeign('salida_subenil_ibfk_1');
            $table->dropForeign('salida_subenil_ibfk_2');
        });
    }
};

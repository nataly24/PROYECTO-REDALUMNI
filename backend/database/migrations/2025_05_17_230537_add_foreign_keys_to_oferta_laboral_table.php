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
        Schema::table('oferta_laboral', function (Blueprint $table) {
            $table->foreign(['id_empresa'], 'oferta_laboral_ibfk_1')->references(['id_empresa'])->on('empresa')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['publicada_por'], 'oferta_laboral_ibfk_2')->references(['id_usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oferta_laboral', function (Blueprint $table) {
            $table->dropForeign('oferta_laboral_ibfk_1');
            $table->dropForeign('oferta_laboral_ibfk_2');
        });
    }
};

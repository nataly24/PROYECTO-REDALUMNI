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
        Schema::table('referencia_laboral', function (Blueprint $table) {
            $table->foreign(['id_experiencia'], 'referencia_laboral_ibfk_1')->references(['id_experiencia'])->on('experiencia_laboral')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referencia_laboral', function (Blueprint $table) {
            $table->dropForeign('referencia_laboral_ibfk_1');
        });
    }
};

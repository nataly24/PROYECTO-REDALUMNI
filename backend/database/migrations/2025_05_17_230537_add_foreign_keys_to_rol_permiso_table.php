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
        Schema::table('rol_permiso', function (Blueprint $table) {
            $table->foreign(['id_rol'], 'rol_permiso_ibfk_1')->references(['id_rol'])->on('rol')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_permiso'], 'rol_permiso_ibfk_2')->references(['id_permiso'])->on('permiso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rol_permiso', function (Blueprint $table) {
            $table->dropForeign('rol_permiso_ibfk_1');
            $table->dropForeign('rol_permiso_ibfk_2');
        });
    }
};

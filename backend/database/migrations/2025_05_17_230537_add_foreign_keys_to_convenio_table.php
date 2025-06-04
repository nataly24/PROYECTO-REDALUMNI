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
        Schema::table('convenio', function (Blueprint $table) {
            $table->foreign(['id_empresa'], 'convenio_ibfk_1')->references(['id_empresa'])->on('empresa')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convenio', function (Blueprint $table) {
            $table->dropForeign('convenio_ibfk_1');
        });
    }
};

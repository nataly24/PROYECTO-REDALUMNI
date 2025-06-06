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
        Schema::table('exalumno', function (Blueprint $table) {
            $table->foreign(['id_persona'], 'exalumno_ibfk_1')->references(['id_persona'])->on('persona')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exalumno', function (Blueprint $table) {
            $table->dropForeign('exalumno_ibfk_1');
        });
    }
};

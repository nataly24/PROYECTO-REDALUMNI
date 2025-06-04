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
        Schema::create('referencia_laboral', function (Blueprint $table) {
            $table->integer('id_referencia', true);
            $table->integer('id_experiencia')->index('id_experiencia');
            $table->string('nombre_contacto', 100)->nullable();
            $table->string('cargo_contacto', 100)->nullable();
            $table->string('telefono_contacto', 50)->nullable();
            $table->string('correo_contacto', 100)->nullable();
            $table->text('relacion_laboral')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencia_laboral');
    }
};

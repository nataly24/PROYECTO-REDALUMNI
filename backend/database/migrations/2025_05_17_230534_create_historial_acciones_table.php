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
        Schema::create('historial_acciones', function (Blueprint $table) {
            $table->integer('id_historial', true);
            $table->integer('id_usuario')->index('id_usuario');
            $table->string('accion', 100);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_accion')->nullable()->useCurrent();
            $table->string('ip_address', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_acciones');
    }
};

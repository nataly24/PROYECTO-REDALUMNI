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
        Schema::create('empresa', function (Blueprint $table) {
            $table->integer('id_empresa', true);
            $table->integer('id_usuario')->index('id_usuario');
            $table->string('nombre_empresa');
            $table->string('nit', 20)->unique('nit');
            $table->string('correo_empresa')->unique('correo_empresa');
            $table->string('tipo_empresa', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion_empresa')->nullable();
            $table->text('descripcion_empresa')->nullable();
            $table->enum('estado_empresa', ['activa', 'inactiva', 'pendiente'])->nullable()->default('pendiente');
            $table->dateTime('fecha_registro')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};

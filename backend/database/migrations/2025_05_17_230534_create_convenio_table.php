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
        Schema::create('convenio', function (Blueprint $table) {
            $table->integer('id_convenio', true);
            $table->integer('id_empresa')->index('id_empresa');
            $table->string('tipo_convenio', 100);
            $table->string('numero_convenio', 50)->unique('numero_convenio');
            $table->string('identificador_convenio', 50)->nullable()->unique('identificador_convenio');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado_vigencia', ['vigente', 'vencido', 'prorrogado'])->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio');
    }
};

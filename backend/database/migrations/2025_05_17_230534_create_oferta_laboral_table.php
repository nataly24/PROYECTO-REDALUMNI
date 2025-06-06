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
        Schema::create('oferta_laboral', function (Blueprint $table) {
            $table->integer('id_oferta', true);
            $table->integer('id_empresa')->index('id_empresa');
            $table->string('titulo_puesto');
            $table->text('descripcion_puesto');
            $table->string('departamento', 100)->nullable();
            $table->date('fecha_publicacion')->nullable()->useCurrent();
            $table->date('fecha_vencimiento');
            $table->enum('modalidad', ['Presencial', 'Remoto', 'Híbrido'])->nullable();
            $table->enum('tipo_contrato', ['Eventual', 'Temporal', 'Permanente'])->nullable();
            $table->text('funcion_principal')->nullable();
            $table->text('requisitos')->nullable();
            $table->text('competencias')->nullable();
            $table->text('valorable')->nullable();
            $table->integer('publicada_por')->index('publicada_por');
            $table->string('nombre_contacto_rrhh', 100)->nullable();
            $table->string('cargo_contacto_rrhh', 100)->nullable();
            $table->string('celular_contacto_rrhh', 30)->nullable();
            $table->string('correo_contacto_rrhh', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_laboral');
    }
};

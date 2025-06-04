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
        Schema::create('subenil', function (Blueprint $table) {
            $table->integer('id_item', true);
            $table->string('nombre_item', 100);
            $table->enum('categoria', ['Material de Colación', 'Material de Oficina', 'Otro']);
            $table->string('tipo_item', 100)->nullable();
            $table->integer('cantidad_disponible')->default(0);
            $table->string('unidad', 20)->nullable()->default('unidad');
            $table->text('observaciones')->nullable();
            $table->integer('registrado_por')->index('registrado_por');
            $table->dateTime('fecha_registro')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subenil');
    }
};

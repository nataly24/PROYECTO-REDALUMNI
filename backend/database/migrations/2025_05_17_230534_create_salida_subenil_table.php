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
        Schema::create('salida_subenil', function (Blueprint $table) {
            $table->integer('id_salida', true);
            $table->integer('id_item')->index('id_item');
            $table->integer('cantidad');
            $table->string('destino_colacion', 100)->nullable();
            $table->dateTime('fecha_salida')->nullable()->useCurrent();
            $table->integer('entregado_por')->index('entregado_por');
            $table->string('recibido_por', 100)->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salida_subenil');
    }
};

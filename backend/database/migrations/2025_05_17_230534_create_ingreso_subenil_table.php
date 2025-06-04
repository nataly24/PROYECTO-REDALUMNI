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
        Schema::create('ingreso_subenil', function (Blueprint $table) {
            $table->integer('id_ingreso', true);
            $table->integer('id_item')->index('id_item');
            $table->integer('cantidad');
            $table->string('motivo', 100)->nullable();
            $table->dateTime('fecha_ingreso')->nullable()->useCurrent();
            $table->integer('ingresado_por')->index('ingresado_por');
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_subenil');
    }
};

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
        Schema::create('carta', function (Blueprint $table) {
            $table->integer('id_carta', true);
            $table->enum('tipo_carta', ['Recibida', 'Enviada']);
            $table->string('numero_carta', 50)->nullable()->unique('numero_carta');
            $table->string('asunto')->nullable();
            $table->string('remitente_destinatario')->nullable();
            $table->date('fecha')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('archivo_url')->nullable();
            $table->integer('registrado_por')->index('registrado_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta');
    }
};

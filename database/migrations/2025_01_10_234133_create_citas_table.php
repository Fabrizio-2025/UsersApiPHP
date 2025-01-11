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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Relación con clientes
            $table->unsignedBigInteger('mascota_id'); // Relación con mascotas
            $table->string('tipo_cita'); // Vacuna, tratamiento, revisión, etc.
            $table->datetime('fecha_hora'); // Fecha y hora de la cita
            $table->text('descripcion')->nullable(); // Descripción adicional
            $table->string('estado')->default('pendiente'); // Estado de la cita
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('mascota_id')->references('id')->on('mascotas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

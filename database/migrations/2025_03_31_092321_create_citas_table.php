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
            $table->id('cita_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('barbero_id');
            $table->unsignedBigInteger('servicio_id');
            $table->dateTime('fecha_hora');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'completada'])->default('pendiente');
            $table->foreign('cliente_id')->references('usuario_id')->on('users')->onDelete('cascade');
            $table->foreign('barbero_id')->references('usuario_id')->on('users')->onDelete('cascade');
            $table->foreign('servicio_id')->references('servicio_id')->on('servicios')->onDelete('cascade');
            $table->index('fecha_hora');
            $table->integer('status')->default(1); // 1: Activo, 0: Inactivo
            $table->timestamps();
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

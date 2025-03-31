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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id('oferta_id');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('descuento', 5, 2); // Porcentaje
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('tipo', ['servicio', 'producto']);
            $table->unsignedBigInteger('item_id'); // Referencia a servicio o producto
            $table->index(['fecha_inicio', 'fecha_fin']);
            $table->integer('status')->default(1); // 1: Activo, 0: Inactivo

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};

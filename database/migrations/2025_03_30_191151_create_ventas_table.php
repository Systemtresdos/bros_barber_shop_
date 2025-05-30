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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('venta_id');
            $table->unsignedBigInteger('cliente_id');
            $table->dateTime('fecha_venta')->useCurrent();
            $table->decimal('total', 10, 2);
            $table->foreign('cliente_id')->references('usuario_id')->on('users')->onDelete('cascade');
            $table->index('fecha_venta');
            $table->string('tipo_pago')->default('efectivo');
            $table->integer('status')->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};

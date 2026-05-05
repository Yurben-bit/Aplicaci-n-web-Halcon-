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
        Schema::create('evidencia_fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedidoId'); // Relación con el pedido
            $table->string('ruta_foto'); // Ruta del archivo en el servidor
            $table->string('latitud')->nullable(); // GPS Opcional
            $table->string('longitud')->nullable(); // GPS Opcional
            $table->timestamps();

            // Al borrar un pedido, se borran sus fotos automáticamente (Borrado en cascada)
            $table->foreign('pedidoId')->references('id')->on('pedidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia_fotos');
    }
};
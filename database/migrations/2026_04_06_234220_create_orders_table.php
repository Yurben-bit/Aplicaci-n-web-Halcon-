<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las modificaciones en la base de datos.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // Descripción del pedido
            
            // Requisito: Estados (Pendiente, En ruta, Entregado)
            $table->enum('status', ['pending', 'in_route', 'delivered'])->default('pending');
            
            // Requisito: Ruta de la fotografía de evidencia
            $table->string('evidence_path')->nullable(); 
            
            // Requisito: Ordenar de último a primero (Usa created_at)
            $table->timestamps(); 
        });
    }

    /**
     * Revierte las modificaciones (si decides borrar la tabla).
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
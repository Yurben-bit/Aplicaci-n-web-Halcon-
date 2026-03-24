<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stockAlmacenes', function (Blueprint $table) {
            $table->id();
            // Creamos la llave foránea que referencia a la tabla materiales
            $table->foreignId('materialesId')->constrained('materiales')->onDelete('cascade');
            
            $table->integer('cantidadStock');
            $table->integer('stockMinimo');
            $table->integer('stockMaximo');
            
            // Usamos el timestamp de Laravel para la actualización automática
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stockAlmacenes');
    }
};
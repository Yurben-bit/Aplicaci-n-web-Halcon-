<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*

        CREATE TABLE IF NOT EXISTS stockAlmacenes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        materialesId INT NOT NULL, -- Para almacenar el material del que se está registrando el stock
        cantidadStock INT NOT NULL, -- Para almacenar la cantidad de material disponible en el almacén
        stockMinimo INT NOT NULL, -- Para almacenar la cantidad mínima de material que debe haber en el almacén antes de generar una alerta para compras
        stockMaximo INT NOT NULL, -- Para almacenar la cantidad máxima de material que puede haber en el almacén para evitar sobrestock
        fechaActualizacion DATETIME DEFAULT CURRENT_TIMESTAMP, -- Para almacenar la fecha y hora de la última actualización del stock
        FOREIGN KEY (materialesId) REFERENCES materiales(id) 
        );

        */

        Schema::create('stockAlmacenes', function (Blueprint $table) {
            $table->id();
            // Creamos la llave foránea que referencia a la tabla materials
            $table->foreignId('material_Id')->constrained('materials')->onDelete('cascade');
            
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
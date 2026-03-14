<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    CREATE TABLE IF NOT EXISTS materiales(
    id INT AUTO_INCREMENT PRIMARY KEY,
    claveMaterial INT NOT NULL UNIQUE, -- Para almacenar la clave única del material
    descripcionMaterial TEXT NOT NULL, -- Para almacenar la descripción del material
    precioUnitario INT NOT NULL,-- Para almacenar el precio unitario del material
    cantidadMaterial INT NOT NULL -- Para almacenar la cantidad de material disponible en el almacén
    );

     */
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clave_material')->unique();
            $table->text('descripcion_material');
            $table->integer('precio_unitario');
            $table->integer('cantidad_material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};

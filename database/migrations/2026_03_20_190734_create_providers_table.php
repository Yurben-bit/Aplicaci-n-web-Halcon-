<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    CREATE TABLE IF NOT EXISTS proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProveedor VARCHAR(255) NOT NULL, -- Para almacenar el nombre del proveedor
    telefono VARCHAR(20) NOT NULL, -- Para almacenar el teléfono del proveedor
    correoElectronico VARCHAR(320) NOT NULL, -- Para almacenar el correo electrónico del proveedor
    activo BOOLEAN DEFAULT TRUE, -- Para marcar proveedores como activos o inactivos
    registroFecha DATETIME DEFAULT CURRENT_TIMESTAMP -- Para almacenar la fecha y hora de registro del proveedor en la base de datos
    );

     */
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_proveedor');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};

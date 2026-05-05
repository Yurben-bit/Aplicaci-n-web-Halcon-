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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numeroFactura', 50);
            $table->unsignedBigInteger('clienteId'); 
            $table->dateTime('fechaPedido');
            $table->string('calleEntrega', 255);
            $table->string('numeroExteriorEntrega', 20);
            $table->string('numeroInteriorEntrega', 20)->nullable();
            $table->string('coloniaEntrega', 255);
            $table->string('ciudadEntrega', 255);
            $table->string('municipioEntrega', 255);
            $table->string('estadoEntrega', 255);
            $table->string('paisEntrega', 255);
            $table->string('codigoPostalEntrega', 10);
            $table->text('notas')->nullable();
            $table->enum('estado', ['Solicitado', 'En proceso', 'En ruta', 'Entregado'])->default('Solicitado');
            $table->unsignedBigInteger('usuariosId'); 
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Relaciones
            // Nota: Asegúrate de que las tablas 'clientes' y 'users' ya existan en tu base de datos
            $table->foreign('clienteId')->references('id')->on('clientes');
            $table->foreign('usuariosId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
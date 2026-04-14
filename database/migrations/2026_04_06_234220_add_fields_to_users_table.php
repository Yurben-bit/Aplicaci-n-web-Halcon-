<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade campos personalizados a la tabla de usuarios existente.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Requisito: Asignar rol o departamento
            $table->string('role_or_department')->nullable()->after('email');
            
            // Requisito: Estatus activo o inactivo
            $table->boolean('is_active')->default(true)->after('role_or_department');
        });
    }

    /**
     * Elimina los campos si se hace un rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role_or_department', 'is_active']);
        });
    }
};
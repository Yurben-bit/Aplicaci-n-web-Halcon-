<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['Ordered', 'In Process', 'In Route', 'Delivered'])
                ->default('Ordered')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_enum', function (Blueprint $table) {
            $table->enum('status', ['pendiente', 'en_ruta', 'entregado'])
                ->default('pendiente')
                ->change();
        });
    }
};

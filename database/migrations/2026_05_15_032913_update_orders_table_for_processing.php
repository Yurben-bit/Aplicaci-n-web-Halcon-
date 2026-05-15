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
        Schema::table('orders', function (Blueprint $table) {

            // Cambiar enum a los estados usados por el frontend
            $table->enum('status', ['Ordered', 'In Process', 'In Route', 'Delivered'])
                ->default('Ordered')
                ->change();

            // Asegurar que items y missing_items sean JSON
            if (Schema::hasColumn('orders', 'items')) {
                $table->json('items')->nullable()->change();
            }

            if (Schema::hasColumn('orders', 'missing_items')) {
                $table->json('missing_items')->nullable()->change();
            }

            // Asegurar que deleted sea boolean
            if (Schema::hasColumn('orders', 'deleted')) {
                $table->boolean('deleted')->default(false)->change();
            }

            // Crear invoice_number si no existe
            if (!Schema::hasColumn('orders', 'invoice_number')) {
                $table->string('invoice_number')->nullable();
            }
        });
    }

    public function down(): void
    {
        // No es posible revertir el cambio de enum sin perder datos
    }

};

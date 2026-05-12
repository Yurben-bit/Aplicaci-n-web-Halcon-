<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('id');
            $table->string('customer_name')->nullable()->after('invoice_number');
            $table->string('customer_number')->nullable()->after('customer_name');
            $table->string('fiscal_data')->nullable()->after('customer_number');
            $table->dateTime('order_date')->nullable()->after('fiscal_data');
            $table->string('delivery_address')->nullable()->after('order_date');
            $table->text('notes')->nullable()->after('delivery_address');
            $table->json('items')->nullable()->after('notes');
            $table->decimal('total_amount', 12, 2)->nullable()->after('items');
            $table->boolean('deleted')->default(false)->after('total_amount');
            $table->string('loaded_unit_photo')->nullable()->after('deleted');
            $table->string('delivery_evidence_photo')->nullable()->after('loaded_unit_photo');
            $table->string('loaded_photo_timestamp')->nullable()->after('delivery_evidence_photo');
            $table->string('delivered_photo_timestamp')->nullable()->after('loaded_photo_timestamp');
            $table->text('delivery_notes')->nullable()->after('delivered_photo_timestamp');
            $table->json('missing_items')->nullable()->after('delivery_notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number',
                'customer_name',
                'customer_number',
                'fiscal_data',
                'order_date',
                'delivery_address',
                'notes',
                'items',
                'total_amount',
                'deleted',
                'loaded_unit_photo',
                'delivery_evidence_photo',
                'loaded_photo_timestamp',
                'delivered_photo_timestamp',
                'delivery_notes',
                'missing_items',
            ]);
        });
    }
};
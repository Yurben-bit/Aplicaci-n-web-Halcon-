<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'invoice_number')) {
                $table->string('invoice_number')->nullable()->after('id');
            }
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('invoice_number');
            }
            if (!Schema::hasColumn('orders', 'customer_number')) {
                $table->string('customer_number')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'fiscal_data')) {
                $table->string('fiscal_data')->nullable()->after('customer_number');
            }
            if (!Schema::hasColumn('orders', 'order_date')) {
                $table->dateTime('order_date')->nullable()->after('fiscal_data');
            }
            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->string('delivery_address')->nullable()->after('order_date');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('delivery_address');
            }
            if (!Schema::hasColumn('orders', 'items')) {
                $table->json('items')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->nullable()->after('items');
            }
            if (!Schema::hasColumn('orders', 'deleted')) {
                $table->boolean('deleted')->default(false)->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'loaded_unit_photo')) {
                $table->string('loaded_unit_photo')->nullable()->after('deleted');
            }
            if (!Schema::hasColumn('orders', 'delivery_evidence_photo')) {
                $table->string('delivery_evidence_photo')->nullable()->after('loaded_unit_photo');
            }
            if (!Schema::hasColumn('orders', 'loaded_photo_timestamp')) {
                $table->string('loaded_photo_timestamp')->nullable()->after('delivery_evidence_photo');
            }
            if (!Schema::hasColumn('orders', 'delivered_photo_timestamp')) {
                $table->string('delivered_photo_timestamp')->nullable()->after('loaded_photo_timestamp');
            }
            if (!Schema::hasColumn('orders', 'delivery_notes')) {
                $table->text('delivery_notes')->nullable()->after('delivered_photo_timestamp');
            }
            if (!Schema::hasColumn('orders', 'missing_items')) {
                $table->json('missing_items')->nullable()->after('delivery_notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'invoice_number')) {
                $table->dropColumn('invoice_number');
            }
            if (Schema::hasColumn('orders', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
            if (Schema::hasColumn('orders', 'customer_number')) {
                $table->dropColumn('customer_number');
            }
            if (Schema::hasColumn('orders', 'fiscal_data')) {
                $table->dropColumn('fiscal_data');
            }
            if (Schema::hasColumn('orders', 'order_date')) {
                $table->dropColumn('order_date');
            }
            if (Schema::hasColumn('orders', 'delivery_address')) {
                $table->dropColumn('delivery_address');
            }
            if (Schema::hasColumn('orders', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('orders', 'items')) {
                $table->dropColumn('items');
            }
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('orders', 'deleted')) {
                $table->dropColumn('deleted');
            }
            if (Schema::hasColumn('orders', 'loaded_unit_photo')) {
                $table->dropColumn('loaded_unit_photo');
            }
            if (Schema::hasColumn('orders', 'delivery_evidence_photo')) {
                $table->dropColumn('delivery_evidence_photo');
            }
            if (Schema::hasColumn('orders', 'loaded_photo_timestamp')) {
                $table->dropColumn('loaded_photo_timestamp');
            }
            if (Schema::hasColumn('orders', 'delivered_photo_timestamp')) {
                $table->dropColumn('delivered_photo_timestamp');
            }
            if (Schema::hasColumn('orders', 'delivery_notes')) {
                $table->dropColumn('delivery_notes');
            }
            if (Schema::hasColumn('orders', 'missing_items')) {
                $table->dropColumn('missing_items');
            }
        });
    }
};
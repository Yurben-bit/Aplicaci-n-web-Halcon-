<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company')->nullable()->after('name');
            $table->string('phone')->nullable()->after('company');
            $table->string('address')->nullable()->after('phone');
            $table->string('customer_number')->nullable()->unique()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company', 'phone', 'address', 'customer_number']);
        });
    }
};
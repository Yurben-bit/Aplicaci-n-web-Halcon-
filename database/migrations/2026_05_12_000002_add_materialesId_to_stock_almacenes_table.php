<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stockAlmacenes', function (Blueprint $table) {
            $table->foreignId('materialesId')->nullable()->after('id')->constrained('materials')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stockAlmacenes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('materialesId');
        });
    }
};
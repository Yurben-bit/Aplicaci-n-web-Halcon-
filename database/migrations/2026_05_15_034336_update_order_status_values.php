<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('orders')->where('status', 'pendiente')->update(['status' => 'Ordered']);
        DB::table('orders')->where('status', 'en_ruta')->update(['status' => 'In Route']);
        DB::table('orders')->where('status', 'entregado')->update(['status' => 'Delivered']);
    }

    public function down(): void
    {
        DB::table('orders')->where('status', 'Ordered')->update(['status' => 'pendiente']);
        DB::table('orders')->where('status', 'In Route')->update(['status' => 'en_ruta']);
        DB::table('orders')->where('status', 'Delivered')->update(['status' => 'entregado']);
    }

};

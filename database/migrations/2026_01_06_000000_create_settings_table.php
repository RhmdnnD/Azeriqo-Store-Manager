<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Contoh: 'total_sold'
            $table->bigInteger('value')->default(0); // Contoh: 1500
            $table->timestamps();
        });

        // --- AUTO SYNC: Ambil jumlah transaksi saat ini sebagai modal awal ---
        $currentCount = 0;
        try {
            if(Schema::hasTable('transactions')){
                $currentCount = DB::table('transactions')->count();
            }
        } catch (\Exception $e) {}

        DB::table('settings')->insert([
            'key' => 'total_sold',
            'value' => $currentCount,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
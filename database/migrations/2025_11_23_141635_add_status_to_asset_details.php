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
    Schema::table('asset_details', function (Blueprint $table) {
        // Cek dulu biar tidak error kalau sudah ada
        if (!Schema::hasColumn('asset_details', 'status')) {
            $table->enum('status', ['tersedia', 'dipinjam', 'maintenance', 'hilang'])
                  ->default('tersedia')
                  ->after('condition');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_details', function (Blueprint $table) {
            //
        });
    }
};

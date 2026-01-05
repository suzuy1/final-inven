<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Kondisi aset setelah dikembalikan
            $table->enum('condition_after', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable()->after('status');

            // Catatan khusus saat pengembalian (terpisah dari notes peminjaman)
            $table->text('return_notes')->nullable()->after('condition_after');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['condition_after', 'return_notes']);
        });
    }
};

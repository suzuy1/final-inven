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
    Schema::create('asset_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade'); // Link ke Induk
        
        $table->string('unit_code')->unique()->nullable(); // INV/SUMBER/ID (Nanti kita generate otomatis)
        $table->string('model_name'); // Tipe Barang (Misal: Acer Aspire 5)
        
        $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
        
        // Relasi ke Data Master lain
        $table->foreignId('room_id')->constrained('rooms'); 
        $table->foreignId('funding_source_id')->constrained('funding_sources');
        
        // Tanggal & Harga
        $table->date('purchase_date')->nullable(); // Tgl Beli
        $table->decimal('price', 15, 2)->default(0); // Harga Beli
        
        $table->date('repair_date')->nullable(); // Tgl Perbaikan
        $table->date('check_date')->nullable(); // Tgl Pengecekan
        
        $table->text('notes')->nullable(); // Keterangan tambahan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_details');
    }
};

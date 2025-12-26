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
    Schema::create('consumable_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('consumable_id')->constrained('consumables')->onDelete('cascade');
        
        $table->string('batch_code')->unique(); // Kode Unit (BHP/ATK/1/001)
        $table->string('model_name'); // Merk/Tipe (Cth: Kimia Farma / Sidu)
        
        // PENTING: Untuk BHP kita butuh jumlah
        $table->integer('initial_stock'); // Stok Awal Beli
        $table->integer('current_stock'); // Sisa Stok
        
        // Data pendukung (Sama seperti Asset)
        $table->foreignId('room_id')->constrained('rooms');
        $table->foreignId('funding_source_id')->constrained('funding_sources');
        $table->enum('condition', ['baik', 'rusak', 'kadaluarsa'])->default('baik');
        
        // Tanggal
        $table->date('purchase_date')->nullable();
        $table->date('expiry_date')->nullable(); // Tgl Kadaluarsa (PENTING BUAT OBAT)
        $table->date('check_date')->nullable(); // Tgl Pengecekan
        
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumable_details');
    }
};

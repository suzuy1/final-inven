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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // Siapa admin yang input?
        
        // Kita relasikan ke Batch Spesifik (Bukan cuma nama barang)
        // Agar kita tahu barang keluar dari batch yang mana (First In First Out)
        $table->foreignId('consumable_detail_id')->constrained('consumable_details')->onDelete('cascade');
        
        $table->enum('type', ['masuk', 'keluar']); // STATUS KUNCI
        $table->integer('amount'); // Jumlah barang
        
        $table->date('date'); // Tgl Transaksi
        $table->text('notes')->nullable(); // Keperluan apa? (Misal: Permintaan BEM)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

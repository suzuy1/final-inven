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
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        
        // Barang apa yang dipinjam? (Harus Unit Spesifik, bukan nama induk)
        $table->foreignId('asset_detail_id')->constrained('asset_details')->onDelete('cascade');
        
        // Identitas Peminjam (Manual Input)
        $table->string('borrower_name'); // Nama Mahasiswa/Dosen
        $table->string('borrower_id'); // NIM atau NIP
        $table->string('phone')->nullable(); // No HP (Penting buat nagih)
        
        // Tanggal
        $table->date('loan_date'); // Tgl Pinjam
        $table->date('return_date_plan'); // Rencana Kembali
        $table->date('return_date_actual')->nullable(); // Realisasi Kembali
        
        // Status Peminjaman
        $table->enum('status', ['dipinjam', 'kembali', 'telat'])->default('dipinjam');
        
        $table->text('notes')->nullable(); // Keperluan
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();

            // User yang mengusulkan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('fk_proc_user');

            // Informasi Pengadaan
            $table->string('requestor_name'); // Nama pengusul
            $table->string('item_name'); // Nama barang yang akan dibeli
            $table->enum('type', ['asset', 'consumable']); // Tipe barang
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null')->name('fk_proc_category'); // Kategori
            $table->integer('quantity'); // Jumlah yang akan dibeli
            $table->text('description')->nullable(); // Deskripsi/spesifikasi
            $table->decimal('unit_price_estimation', 15, 2)->nullable(); // Estimasi harga satuan

            // Status Workflow
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            // pending = menunggu approval
            // approved = disetujui, proses pembelian
            // rejected = ditolak
            // completed = barang sudah datang dan masuk stok

            // Catatan Admin
            $table->text('admin_note')->nullable();

            // Timestamps
            $table->timestamp('request_date')->useCurrent(); // Tanggal pengajuan
            $table->timestamp('response_date')->nullable(); // Tanggal respon admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};

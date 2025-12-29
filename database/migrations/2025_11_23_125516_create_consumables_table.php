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
    Schema::create('consumables', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Barang (Cth: Paracetamol 500mg)
        $table->string('unit'); // Satuan (Cth: Strip, Box, Pcs)
        $table->foreignId('category_id')->constrained('categories');
        $table->text('notes')->nullable(); // Keterangan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};

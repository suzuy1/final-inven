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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            // KOLOM-KOLOM PENTING DITAMBAHKAN DI SINI
            $table->string('name')->unique(); // Nama Unit Kerja (mis: BAAK, Prodi TI)
            $table->string('code', 10)->nullable()->unique(); // Kode Unit (Opsional, tapi unik)
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif'); // Status unit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
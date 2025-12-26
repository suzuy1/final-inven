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
        // Pastikan nama tabel adalah 'rooms' sesuai dengan Model 'Room'
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            
            // Kolom-kolom inti Ruangan
            $table->string('name')->unique(); // Nama Ruangan (mis: Lab Komputer 1)
            $table->string('location'); // Lokasi (mis: Gedung A Lt 2)
            
            // Relasi ke Unit (Foreign Key)
            // foreignId('unit_id') : Membuat kolom unit_id (UNSIGNED BIGINT)
            // constrained('units') : Membuat foreign key ke kolom 'id' di tabel 'units'
            // onDelete('cascade') : Jika Unit dihapus, Ruangan yang terkait ikut terhapus.
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); 
            
            // Kolom status dengan opsi enum
            $table->enum('status', ['tersedia', 'perbaikan', 'digunakan'])->default('tersedia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
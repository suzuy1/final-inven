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
    Schema::create('funding_sources', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Kode Sumber Dana (Wajib Unik)
        $table->string('name'); // Nama Lengkap Sumber Dana
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_sources');
    }
};

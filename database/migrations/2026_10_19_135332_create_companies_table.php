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
Schema::create('companies', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Menghubungkan HRD dengan Perusahaannya
    $table->string('name'); // Nama Perusahaan
    $table->string('location'); // Kota / Lokasi
    $table->text('address'); // Alamat Lengkap
    $table->string('phone')->nullable(); // No Telepon Perusahaan
    $table->text('description')->nullable(); // Deskripsi Singkat / Bidang Usaha
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

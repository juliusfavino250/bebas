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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nisn')->unique();
        $table->string('class');
        $table->string('phone')->nullable();
        
        // Fitur Tambahan: Pengajuan Ubah Profil
        $table->text('pending_data')->nullable(); // Menyimpan JSON perubahan biodata sementara
        $table->boolean('is_profile_requested')->default(false);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

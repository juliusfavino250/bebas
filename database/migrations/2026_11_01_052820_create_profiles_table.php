<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Mandatory (Wajib Diisi)
            $table->integer('age');
            
            // Optional (Tidak Wajib)
            $table->text('bio')->nullable();
            $table->string('contact')->nullable();
            $table->string('hobby')->nullable();
            $table->string('social_media')->nullable();
            
            // Role specific fields
            $table->string('school')->nullable();  // Untuk Siswa & Guru
            $table->string('class')->nullable();   // Khusus Siswa
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null'); // Khusus HRD

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
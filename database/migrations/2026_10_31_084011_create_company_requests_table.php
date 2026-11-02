<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Siswa yang diprospek PKL
    $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // Guru yang mengajukan
    $table->foreignId('company_id')->constrained()->onDelete('cascade');        // Perusahaan tujuan
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('notes')->nullable(); // Catatan tambahan dari guru
    $table->timestamps();
});

        // Tabel untuk chat / diskusi lanjutan antara Guru dan HRD terkait request tersebut
        Schema::create('request_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_request_id')->constrained('company_requests')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // Bisa guru atau hrd
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_chats');
        Schema::dropIfExists('company_requests');
    }
};
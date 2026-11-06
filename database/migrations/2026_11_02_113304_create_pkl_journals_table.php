<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pkl_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->date('date');
            $table->text('activity'); // Kegiatan harian
            $table->text('reflection'); // Refleksi siswa
            $table->enum('status', ['draft', 'sent_to_hrd', 'approved_by_hrd', 'sent_to_teacher', 'completed'])->default('draft');
            $table->text('hrd_notes')->nullable(); // Catatan/feedback dari HRD
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pkl_journals');
    }
};
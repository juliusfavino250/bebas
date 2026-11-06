<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyRequest;
use App\Models\User;
use App\Models\Company;

class PklJournal extends Model
{
    use HasFactory;

    protected $table = 'pkl_journals';

    protected $fillable = [
        'student_id',
        'company_id',
        'date',
        'activity',
        'reflection',
        'status',
    ];

    // Relasi ke User (Siswa yang mengisi jurnal)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi ke Perusahaan / Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relasi langsung ke CompanyRequest berdasarkan student_id atau company_id
    public function companyRequest()
    {
        return $this->belongsTo(CompanyRequest::class, 'student_id', 'student_id');
    }
}
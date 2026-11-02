<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'teacher_id',
        'message',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function chats()
{
    return $this->hasMany(RequestChat::class);
    return $this->hasMany(RequestChat::class, 'company_request_id');
}
}
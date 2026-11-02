<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',    // <-- PASTIKAN INI ADA
        'age',
        'bio',
        'contact',
        'hobby',
        'social_media',
        'school',
        'class',
        'company_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
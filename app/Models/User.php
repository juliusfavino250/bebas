<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'teacher', 'hrd', 'student'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Tabel Company (Khusus untuk User ber-role HRD)
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    /**
     * Relasi ke Tabel Profile (Setiap User memiliki satu profil)
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    public function companyRequest()
{
    return $this->hasOne(CompanyRequest::class, 'student_id');
}
}
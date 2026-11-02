<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_request_id',
        'sender_id',
        'message',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function request()
    {
        return $this->belongsTo(CompanyRequest::class, 'company_request_id');
    }
}
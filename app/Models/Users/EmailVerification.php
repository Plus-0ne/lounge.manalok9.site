<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $table='email_verification';


    protected $fillable = [
        'email_address',
        'token',
        'expiration',
        'verified',
        'created_at',
        'updated_at',
    ];
}

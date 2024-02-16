<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    protected $table='members_password_reset';


    protected $fillable = [
        'email_address',
        'token',
        'expiration',
        'created_at',
        'updated_at',
    ];

}

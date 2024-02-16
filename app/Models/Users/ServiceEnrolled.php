<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEnrolled extends Model
{
    use HasFactory;

    protected $table = 'service_enrolled';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'service_uuid',
        'status',
        'created_at',
        'updated_at',
    ];
}

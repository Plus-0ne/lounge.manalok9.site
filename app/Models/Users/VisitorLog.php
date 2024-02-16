<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='visitor_logs';

    protected $fillable = [
        'ip_address',
    ];
}

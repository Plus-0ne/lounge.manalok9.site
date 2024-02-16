<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLogs extends Model
{
    use HasFactory;

    protected $table = 'admin_logs';

    protected $fillable = [
        'uuid',
        'admin_uuid',
        'action',
        'description',
        'alert_level', // 0 = critical ; 1 = normal
        'created_at',
        'updated_at',
    ];
}

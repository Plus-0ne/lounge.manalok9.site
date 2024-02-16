<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IagdMembers extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_members';

    protected $fillable = [
        'status',
        'iagd_number',
        'name',
        'emails',
        'address',
        'numbers',
        'extra_data1',
        'extra_data2',
        'date_year',
    ];
}

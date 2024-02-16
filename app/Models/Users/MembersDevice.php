<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersDevice extends Model
{
    use HasFactory;

    protected $table='members_devices';


    protected $fillable = [
        'mem_id',
        'ip_address',
        'device_type',
        'browser',
        'platform',
        'current_device',
        'created_at',
        'updated_at',
    ];

    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'id','mem_id');
    }
}

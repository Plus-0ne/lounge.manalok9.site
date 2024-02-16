<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersAd extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='members_ads';

    protected $fillable = [
        'member_ad_no',
        'member_uuid',
        'uuid',

        'title',
        'message',
        
        'file_path',

        'created_at',
        'updated_at',
    ];
    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'uuid','member_uuid');
    }
}
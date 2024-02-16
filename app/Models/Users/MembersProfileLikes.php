<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersProfileLikes extends Model
{
    use HasFactory;

    protected $table = 'members_profile_like';

    protected $fillable = [
        'uuid',
        'like_by_uuid',
        'reaction',
        'created_at',
        'updated_at',
    ];

    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'uuid','uuid');
    }
}

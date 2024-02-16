<?php

namespace App\Models\Admin;

use App\Models\Users\MembersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminModel extends Authenticatable
{
    use HasFactory , SoftDeletes;

    protected $table='admins';

    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'user_uuid',
        'email_address',
        'password',
        'department',
        'position',
        'roles',
        'added_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    /**
     * Get the userAccount associated with the AdminModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userAccount(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'user_uuid');
    }
}

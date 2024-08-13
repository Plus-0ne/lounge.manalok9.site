<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dealers extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='dealers';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'last_name',
        'first_name',
        'middle_name',
        'email_address',
        'contact_number',
        'tel_number',
        'store_location',
        'status',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the userAccount associated with the Dealers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userAccount(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'user_uuid');
    }
    /**
     * Get the fileImage associated with the Dealers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fileImage(): HasOne
    {
        return $this->hasOne(DealersAttachments::class, 'dealers_uuid', 'uuid');
    }
}

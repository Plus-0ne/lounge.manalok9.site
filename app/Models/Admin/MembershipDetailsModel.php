<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipDetailsModel extends Model
{
    use HasFactory;

    protected $table='ml_iagd_details';

    protected $fillable = [
        'registration_uuid',
        'user_uuid',
        'iagd_number',

        'first_name',
        'last_name',
        'middle_initial',
        'email_address',
        'contact_number',
        'address',
        'shipping_address',

        'nearest_lbc_branch',
        'name_on_card',
        'fb_url',

        'membership_package',
        'referral_code',
        'referred_by',

        'status',

        'created_at',
        'updated_at',
    ];


    public function MemberAccount()
    {
        return $this->hasOne(RegistrationModel::class,'uuid','user_uuid');
    }
    public function Uploads()
    {
        return $this->hasMany(MembershipDetailsUploadsModel::class,'registration_uuid','registration_uuid');
    }
}

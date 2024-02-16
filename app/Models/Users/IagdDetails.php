<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IagdDetails extends Model
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
}

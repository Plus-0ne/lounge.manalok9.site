<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipDetailsComissionModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';

    protected $table='premium_registration_comissions';

    protected $fillable = [
        'premium_registration_comission_uuid',
        'sale_total',
        'comission_total',
        'lounge_registration_uuid',
        'registered_member_lounge_uuid',
        'first_referrer_lounge_uuid',
        'second_referrer_lounge_uuid',
        'first_referrer_comission',
        'second_referrer_comission',
        'created_by',
        'status',
    ];
}

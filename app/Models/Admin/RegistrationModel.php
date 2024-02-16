<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    use HasFactory;

    protected $table='iagd_members';
    
    public $timestamps = true;

    protected $fillable = [
        'id',
        'iagd_number',
        'name',
        'email_address',
        'contact_number',
        'complete_address',
        'shipping_address',
        'nearest_lbc',
        'name_on_card',
        'facebool_url',
        'assisted_by',
        'reffered_by',
        'name_on_card',
        'order_number',
        'icgd_member',
        'irgd_member',
        'ibgd_member',
        'ifgd_member',
        'membership_status',
        'from_registry',

        'is_premium',
    ];
}

<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipDetailsUploadsModel extends Model
{
    use HasFactory;

    protected $table='ml_iagd_details_uploads';

    protected $fillable = [
        'registration_uuid',
        'user_uuid',
        'type',
        'file_path',
        'created_at',
        'updated_at',
    ];

}

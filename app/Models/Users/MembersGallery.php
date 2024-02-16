<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersGallery extends Model
{
    use HasFactory;

    protected $table='members_gallery';

    protected $fillable = [
        'uuid',
        'name',
        'gender',
        'breed',
        'description',
        'file_path',
        'created_at',
        'updated_at',
    ];
}

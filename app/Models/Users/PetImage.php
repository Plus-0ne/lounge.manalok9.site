<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetImage extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='pet_images';

    protected $fillable = [
        'pet_image_no',
        'pet_no',
        'pet_uuid',
        'pet_type',
        'file_path',
        'created_at',
        'updated_at',
    ];
}

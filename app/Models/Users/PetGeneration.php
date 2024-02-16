<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetGeneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'pet_id',

        'pet_type',

        'pair_no',
        'sire_name',
        'sire_breed',
        'dam_name',
        'dam_breed',
    ];
}

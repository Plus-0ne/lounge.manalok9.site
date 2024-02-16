<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnimals extends Model
{
    use HasFactory;

    protected $table='test_animals';


    protected $fillable = [
        'owner_iagd_number',

        'rabbit_name',
        'eye_color',
        'rabbit_color',

        'markings',
        'date_of_birth',
        'location_details',

        'gender',
        'height',
        'weight',

        'owner',
        'rabbit_no',
        'age',

        'name_of_sire',
        'name_of_dam',
        'breed',
    ];
}

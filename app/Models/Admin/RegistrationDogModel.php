<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationDogModel extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_members_dog';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetUUID',
        'OwnerUUID',
        'OwnerIAGDNo',
        
        'PetName',
        'BirthDate',
        'Gender',

        'Location',
        'Breed',
        'Owner',
        'Co_Owner',
        
        'Breeder',
        'Markings',
        'PetColor',
        'EyeColor',

        'Height',
        'Weight',
        'SireName',
        'DamName',


        'Status',
        'DateAdded',
    ];


    public function AdtlInfo()
    {
        return $this->hasOne(RegistrationPetDetailsModel::class,'PetUUID','PetUUID');
    }

    public function OwnerInfo()
    {
        return $this->setConnection('mysql')->hasOne(RegistrationModel::class,'uuid','OwnerUUID');
    }
}

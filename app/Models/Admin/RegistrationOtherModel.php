<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOtherModel extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_members_other_animal';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetUUID',
        'OwnerUUID',
        'OwnerIAGDNo',
        
        'PetName',
        'AnimalType',
        'CommonName',
        'FamilyStrain',
        'SizeLength',
        'SizeWidth',
        'SizeHeight',
        'Weight',
        'ColorMarking',

        'Co_Owner',

        'storage_img_uuid',
        'img_token',

        'non_member',


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

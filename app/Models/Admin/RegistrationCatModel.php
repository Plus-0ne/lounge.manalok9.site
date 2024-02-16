<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationCatModel extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_members_cat';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetUUID',
        'OwnerUUID',
        'OwnerIAGDNo',
        
        'PetName',
        'BirthDate',
        'EyeColor',
        'PetColor',

        'Markings',
        'Location',
        'Gender',
        'Height',

        'Weight',
        'Owner',
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

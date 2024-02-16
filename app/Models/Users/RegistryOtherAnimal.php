<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryOtherAnimal extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_registry_other_animal';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetNo',
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
    ];

    public function PetImage()
    {
        return $this->hasOne(PetImage::class,'pet_no','PetNo');
    }
    public function AdtlInfo()
    {
        return $this->hasOne(NonMemberRegistration::class,'PetUUID','PetUUID');
    }
}

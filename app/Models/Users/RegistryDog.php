<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryDog extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_registry_dog';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetNo',
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

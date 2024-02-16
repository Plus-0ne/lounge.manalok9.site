<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryBird extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_registry_bird';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetNo',
        'OwnerIAGDNo',
        
        'PetName',
        'EyeColor',
        'PetColor',
        'Markings',

        'BirthDate',
        'Location',
        'Gender',
        'Height',

        'Weight',
        'Owner',
        'Co_Owner',
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

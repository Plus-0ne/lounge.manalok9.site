<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryCat extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_registry_cat';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetNo',
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

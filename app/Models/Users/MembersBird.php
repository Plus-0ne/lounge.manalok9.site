<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersBird extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_members_bird';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'PetUUID',
        'OwnerUUID',
        'OwnerIAGDNo',

        'PetName',
        'EyeColor',
        'PetColor',
        'Markings',

        'BirthDate',
        'Location',
        'Breed',
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

    // public function PetImage()
    // {
    //     return $this->hasOne(PetImage::class,'pet_uuid','PetUUID');
    // }
    // public function StorageFile()
    // {
    //     return $this->hasOne(StorageFile::class,'uuid','storage_img_uuid');
    // }

    public function AdtlInfo()
    {
        return $this->hasOne(NonMemberRegistration::class,'PetUUID','PetUUID');
    }
}

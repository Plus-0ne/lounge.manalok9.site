<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPetDetailsModel extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table='wm_non_member_registration';
    
    protected $primaryKey = 'ID';

    protected $fillable = [
        'UUID',
        'FullName',
        'ContactNumber',
        'EmailAddress',
        'FacebookPage',
        'Type',
        'PetUUID',

        'MicrochipNo',
        'AgeInMonths',
        'VetClinicName',
        'VetOnlineProfile',
        'ShelterInfo',
        'ShelterOnlineProfile',
        'BreederInfo',
        'BreederOnlineProfile',
        'SireName',
        'SireBreed',
        'SireRegNo',
        'DamName',
        'DamBreed',
        'DamRegNo',

        'Photo',
        'PetSupportingDocuments',
        'VetRecordDocuments',
        'SireImage',
        'SireSupportingDocuments',
        'DamImage',
        'DamSupportingDocuments',
    ];


    public function FilePhoto()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','Photo');
    }
    public function FilePetSupportingDocuments()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','PetSupportingDocuments');
    }
    public function FileVetRecordDocuments()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','VetRecordDocuments');
    }
    public function FileSireImage()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','SireImage');
    }
    public function FileSireSupportingDocuments()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','SireSupportingDocuments');
    }
    public function FileDamImage()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','DamImage');
    }
    public function FileDamSupportingDocuments()
    {
        return $this->setConnection('mysql')->hasOne(StorageModel::class, 'uuid','DamSupportingDocuments');
    }
}

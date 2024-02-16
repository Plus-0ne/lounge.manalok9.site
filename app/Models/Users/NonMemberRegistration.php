<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NonMemberRegistration extends Model
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
        return $this->hasOne(StorageFile::class,'uuid','Photo');
    }

    /**
     * Get the petImage associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petImage(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','pet_image');
    }

    /**
     * Get all of the petImageUploads for the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function petImageUploads(): HasMany
    {
        return $this->hasMany(StorageFile::class, 'uuid', 'Photo');
    }

    /**
     * Get the petRecord that owns the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dogRecord(): BelongsTo
    {
        return $this->belongsTo(MembersDog::class, 'PetUUID', 'PetUUID');
    }

    /* -------------------------------------------------------------------------- */
    /*                                 Dog uploads                                */
    /* -------------------------------------------------------------------------- */
    /**
     * Get the dogImage associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dogImage(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','pet_image');
    }

    /**
     * Get the user associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petSupportingDocuments(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','pet_supporting_doc');
    }

    /**
     * Get the dogVetRecord associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petVetRecord(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','vet_record');
    }

    /**
     * Get the dogSireImage associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petSireImage(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','sire_image');
    }

    /**
     * Get the dogSireSupportingDocument associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petSireSupportingDocuments(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','sire_supporting_doc');
    }

    /**
     * Get the dogDamImage associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petDamImage(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','dam_image');
    }

    /**
     * Get the dogDamSupportingDocument associated with the NonMemberRegistration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function petDamSupportingDocuments(): HasOne
    {
        return $this->hasOne(StorageFile::class, 'uuid', 'Photo')->where('image_type','dam_supporting_doc');
    }
}

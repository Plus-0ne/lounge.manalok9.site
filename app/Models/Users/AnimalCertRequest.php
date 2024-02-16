<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AnimalCertRequest extends Model
{
    use HasFactory;

    protected $table='ml_animalcert_request';


    protected $fillable = [
        'uuid',
        'user_uuid',
        'animal_uuid',
        'include_pedigree_cert',
        'sire_iagd_num',
        'sire_name',
        'sire_breed',
        'dam_iagd_num',
        'dam_name',
        'dam_breed',
        'status',
        'created_at',
        'updated_at',
        'fb_account',
        'animal_type',
        'certificate_only', // 1 or 0
        'certificate_holder', // 1 or 0
    ];

    /**
     * Get the animalDetails associated with the AnimalCertRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function animalDetails(): HasOne
    {
        return $this->hasOne(MembersDog::class, 'PetUUID', 'animal_uuid');
    }
    /**
     * Get the requestCreator that owns the AnimalCertRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestCreator(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'user_uuid', 'uuid');
    }
}

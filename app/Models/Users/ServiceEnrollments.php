<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceEnrollments extends Model
{
    use HasFactory;

    protected $table = 'service_enrollments';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'petName',
        'petBreed',
        'petColor',
        'petAge',
        'petGender',

        'petOwner',
        'currentAddress',
        'contactNumber',
        'mobileNumber',
        'emailAddress',
        'fbAccountLink',
        'personalBelongings',

        'textAreaDogToClass',
        'textAreaWhatToAccomplish',
        'textAreaWhereAboutUs',

        'ehrlichiosis',
        'liverProblem',
        'kidneyProblem',
        'fracture',
        'hipDysplasia',
        'allergy',
        'eyeIrritation',
        'skinProblem',
        'undergoneOperation',

        'biteIncendent', // 1 = true or 0 = false
        'biteIncendentSelected',

        'otherHealthProblem', // 1 = true or 0 = false
        'textAreaOtherHealthProblem',

        'healthRecord', // Upladed urls
        'laboratoryResult', // Upladed urls

        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Get all of the servicesEnrolled for the ServiceEnrollments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicesEnrolled(): HasMany
    {
        return $this->hasMany(ServiceEnrolled::class, 'service_uuid', 'uuid');
    }
}

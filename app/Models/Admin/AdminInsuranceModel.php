<?php

namespace App\Models\Admin;

use App\Models\Users\InsuranceOrdered;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminInsuranceModel extends Model
{
    use HasFactory;

    protected $table = 'ml_insurance';

    protected $fillable = [
        'uuid',
        'plan_type',

        'title',
        'description',
        'price',
        'coverage_period',
        'coverage_type',
        'package_type',
        'available_discount',
        'status',
        'image_path',
        'added_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Get all of the insruanceAvailedByUser for the AdminInsuranceModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insruanceAvailedByUser(): HasMany
    {
        return $this->hasMany(InsuranceOrdered::class, 'insurance_uuid', 'uuid');
    }

}

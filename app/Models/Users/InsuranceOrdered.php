<?php

namespace App\Models\Users;

use App\Models\Admin\AdminInsuranceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsuranceOrdered extends Model
{
    use HasFactory;
    protected $table = 'insurance_order';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'insurance_uuid',
        'order_id',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the InsuranceOrdered
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'user_uuid', 'uuid');
    }

    /**
     * Get the insuranceDetails that owns the InsuranceOrdered
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insuranceDetails(): BelongsTo
    {
        return $this->belongsTo(AdminInsuranceModel::class, 'insurance_uuid', 'uuid');
    }
}

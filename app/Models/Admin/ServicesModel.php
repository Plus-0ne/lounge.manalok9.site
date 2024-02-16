<?php

namespace App\Models\Admin;

use App\Models\Users\ServiceOrders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicesModel extends Model
{
    use HasFactory;

    protected $table = 'admin_services';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'price',
        'status',
        'image',
        'added_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get all of the serviceOrdered for the ServicesModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceOrdered(): HasMany
    {
        return $this->hasMany(ServiceOrders::class,'service_uuid','uuid');
    }

}

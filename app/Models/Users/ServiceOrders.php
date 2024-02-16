<?php

namespace App\Models\Users;

use App\Models\Admin\ServicesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ServiceOrders extends Model
{
    use HasFactory;

    protected $table='service_orders';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'service_uuid',
        'status',
        'price',
        'created_at',
        'updated_at',
    ];

    public function service()
    {
        return $this->belongsTo(ServicesModel::class);
    }

    public function orderOwner()
    {
        return $this->belongsTo(MembersModel::class);
    }

    /**
     * Get the serviceOrderedOwner associated with the ServiceOrders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function serviceOrderedOwner(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'user_uuid');
    }

    /**
     * Get the serviceDetails associated with the ServiceOrders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function serviceDetails(): HasOne
    {
        return $this->hasOne(ServicesModel::class, 'uuid', 'service_uuid');
    }
}

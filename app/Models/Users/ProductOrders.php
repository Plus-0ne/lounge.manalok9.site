<?php

namespace App\Models\Users;

use App\Models\Admin\ProductsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOrders extends Model
{
    use HasFactory;

    protected $table = 'product_orders';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'product_uuid',
        'quantity',
        'price',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the productDetails associated with the ProductOrders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function productDetails(): HasOne
    {
        return $this->hasOne(ProductsModel::class, 'uuid', 'product_uuid');
    }

    /**
     * Get the customerDetails that owns the ProductOrders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customerDetails(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'user_uuid', 'uuid');
    }
}

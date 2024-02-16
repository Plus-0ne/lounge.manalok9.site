<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'admin_products';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'price',
        'stock',
        'status',
        'image',
        'added_by',
        'created_at',
        'updated_at'
    ];
}

<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProducts extends Model
{

    use HasFactory;

    protected $connection = 'mysql3';

    protected $table = 'products';

    protected $primaryKey = 'ID';

}

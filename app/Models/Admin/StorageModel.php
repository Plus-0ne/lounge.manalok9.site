<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='storage_files';

    protected $fillable = [
        'uuid',
        'file_path',
    ];
}

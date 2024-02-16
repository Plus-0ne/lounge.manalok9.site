<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageFile extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='storage_files';

    protected $fillable = [
        'uuid',
        'file_path',
        'file_name',
        'token',
        'created_at',
        'updated_at',
        'image_type',
    ];

    /**
     * Get the additionalInfo that owns the StorageFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function additionalInformation(): BelongsTo
    {
        return $this->belongsTo(NonMemberRegistration::class, 'photo', 'uuid');
    }
}

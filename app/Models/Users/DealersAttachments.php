<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealersAttachments extends Model
{
    use HasFactory;

    protected $table='dealers_attachments';

    protected $fillable = [
        'uuid',
        'dealers_uuid',
        'filename',
        'type',
        'path',
        'created_at',
        'updated_at'
    ];
}

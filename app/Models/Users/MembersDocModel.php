<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersDocModel extends Model
{
    use HasFactory;

    protected $table='members_documents';

    public $timestamps = true;

    protected $fillable = [
        'iagd_number',
        'members_file',
    ];

}

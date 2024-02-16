<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TrainingAssistance extends Model
{
    use HasFactory;

    protected $table='ml_training_tickets';


    protected $fillable = [
        'uuid',
        'user_uuid',
        'updated_contact',
        'facebook_link',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the ticketAuthor that owns the TrainingAssistance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketAuthor(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'user_uuid', 'uuid');
    }
}

<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostReaction extends Model
{
    use HasFactory;

    protected $table='post_reaction';


    protected $fillable = [
        'post_id',
        'uuid',
        'reaction',

        'created_at',
        'updated_at',
    ];
    public function PostFeed()
    {
        return $this->hasOne(PostFeed::class,'post_id','post_id');
    }

    /**
     * Get the MembersModel associated with the PostReaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function MembersModel(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'uuid');
    }

    /**
     * Get the MembersModel that owns the PostReaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function UserReaction(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'uuid', 'uuid');
    }
}

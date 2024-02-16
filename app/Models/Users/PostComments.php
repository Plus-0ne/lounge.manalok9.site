<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComments extends Model
{
    use HasFactory;

    protected $table='post_comments';

    protected $fillable = [
        'post_id',
        'uuid',
        'comment',
        'mentions',
        'created_at',
        'updated_at',
    ];
    public function PostFeed()
    {
        return $this->hasOne(PostFeed::class,'post_id','post_id');
    }

    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'uuid','uuid');
    }

    /**
     * Get the CommentsFromPost associated with the PostComments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function CommentsFromPost(): HasOne
    {
        return $this->hasOne(PostFeed::class, 'post_id', 'post_id');
    }

    /**
     * Get the userCommentOwner that owns the PostComments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCommentOwner(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'uuid', 'uuid');
    }
}

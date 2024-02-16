<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PostFeed extends Model
{
    use HasFactory , SoftDeletes;

    protected $table='post_feed';

    protected $fillable = [
        'post_id',
        'type',
        'uuid',
        'post_message',
        'date',
        'time',
        'status',
        'visibility',

        'created_at',
        'updated_at',
        'share_source'
    ];

    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'uuid','uuid');
    }
    public function PostReaction()
    {
        return $this->hasMany(PostReaction::class,'post_id','post_id');
    }
    public function PostComments()
    {
        return $this->hasMany(PostComments::class,'post_id','post_id');
    }
    public function UserFollow()
    {
        return $this->hasMany(UserFollow::class,'uuid','uuid');
    }

    /**
     * Get the CommentPerPost associated with the PostFeed
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function CommentPerPost(): HasMany
    {
        return $this->HasMany(PostComments::class, 'post_id', 'post_id')->with('userCommentOwner')->orderBy('created_at','asc');
    }

    /**
     * Get all of the postLastComment for the PostFeed
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postLastComment(): HasMany
    {
        return $this->hasMany(PostComments::class, 'post_id', 'post_id')->orderBy('created_at','DESC');
    }

    /**
     * Get all of the PostAttachments for the PostFeed
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function PostAttachments(): HasMany
    {
        return $this->hasMany(PostAttachments::class, 'post_uuid', 'post_id');
    }
    /**
     * Get all of the UsersFollowers for the PostFeed
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UsersFollowers()
    {
        return $this->hasMany(UserFollow::class, 'follow_uuid', 'uuid')->get()->first();
    }

    /**
     * Get the post associated with the PostFeed share_source
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sharedSource(): HasOne
    {
        $share_source = $this->share_source;

        return $this->hasOne(PostFeed::class, 'post_id', 'share_source')->with(['MembersModel' => function($mmm) {
            $mmm->select('id', 'uuid', 'iagd_number', 'email_address', 'profile_image', 'first_name', 'last_name');
        }]);
    }

    /**
     * Get all of the sourceAttachments for the PostFeed
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sourceAttachments(): HasMany
    {
        return $this->hasMany(PostAttachments::class, 'post_uuid', 'share_source');
    }
}

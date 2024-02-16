<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserFollow extends Model
{
    use HasFactory;

    protected $table='ml_follow';


    protected $fillable = [
        'uuid',
        'follow_uuid',
        'room_uuid',
        'status',
        'last_message_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the MembersModel associated with the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function MembersModel(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'uuid');
    }

    /**
     * Get the myFollowers associated with the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function myFollowers(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'follow_uuid');
    }

    /**
     * Get the FollowDetails associated with the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function FollowDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'follow_uuid');
    }

    /**
     * Get all of the roomConversation for the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roomConversation(): HasMany
    {
        return $this->hasMany(mlConversation::class, 'room_uuid', 'room_uuid');
    }

    public function LastMessage()
    {
        $lastMessage = $this->roomConversation();

        $lastMessage
        ->orderBy('created_at','desc')
        ->with('userDetails');

        return $lastMessage;
    }

    /* Follow page relationships */
    /**
     * Get the followerDetails associated with the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function followerDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'uuid');
    }
    /**
     * Get the followingDetails associated with the UserFollow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function followingDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'follow_uuid');
    }
}

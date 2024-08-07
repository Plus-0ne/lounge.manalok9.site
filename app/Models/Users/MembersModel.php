<?php

namespace App\Models\Users;

use App\Models\Admin\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class MembersModel extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $table='iagd_members';


    protected $fillable = [
        'uuid',
        'iagd_number',
        'old_iagd_number',
        'email_address',
        'password',
        'isGoogle',
        'profile_image',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birth_date',
        'contact_number',
        'address',
        'is_email_verified',
        'is_premium',
        'status',
        'timezone',
        'last_action',
        'referred_by',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /* RELATIONSHIPS */
    public function PostFeed()
    {
        return $this->hasMany(PostFeed::class,'uuid','uuid');
    }
    public function MembersDevice()
    {
        return $this->hasMany(MembersDevice::class,'mem_id','id');
    }
    public function PostComments()
    {
        return $this->hasMany(PostComments::class,'uuid','uuid');
    }

    /**
     * Get all of the myFollowers for the MembersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myFollowers()
    {
        return $this->hasMany(UserFollow::class, 'follow_uuid', 'uuid');
    }

    public function UserFollow()
    {
        return $this->hasMany(UserFollow::class,'uuid','uuid');
    }

    public function TradeLog()
    {
        return $this->hasMany(TradeLog::class,'iagd_number','iagd_number');
    }
    public function MembersProfileLikes()
    {
        return $this->hasMany(MembersProfileLikes::class,'uuid','uuid');
    }

    /**
     * Get all of the PostReaction for the MembersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function PostReaction(): HasMany
    {
        return $this->hasMany(PostReaction::class, 'uuid', 'uuid');
    }

    /**
     * Get all of the sentMessage for the MembersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessage(): HasMany
    {
        return $this->hasMany(mlConversation::class, 'sender_uuid', 'uuid');
    }

    /**
     * Get all of the receivedMessage for the MembersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessage(): HasMany
    {
        return $this->hasMany(mlConversation::class, 'reciever_uuid', 'uuid');
    }

    /* BROADCASTING */
    public function receivesBroadcastNotificationsOn()
    {
        return [
            'my.notification.'.$this->id
        ];
    }

    /**
     * Get the adminAccount associated with the MembersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adminAccount(): HasOne
    {
        return $this->hasOne(AdminModel::class, 'user_uuid', 'uuid');
    }
}

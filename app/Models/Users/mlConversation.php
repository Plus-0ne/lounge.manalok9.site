<?php

namespace App\Models\Users;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class mlConversation extends Model
{
    use HasFactory;

    protected $table='ml_conversation';

    protected $fillable = [
        'room_uuid',
        'conversation_uuid',
        'sender_uuid',
        'receiver_uuid',

        'message',
        'type',
        'status',

        'created_at',
        'updated_at',
    ];

    protected $encrypt = ['message'];

    /* Encrypt */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt))
        {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /* Decrypt */
    public function getAttribute($key)
    {
        if (in_array($key, $this->encrypt))
        {
            return Crypt::decryptString($this->attributes[$key]);
        }

        return parent::getAttribute($key);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($attributes as $key => $value)
        {
            if (in_array($key, $this->encrypt))
            {
                $attributes[$key] = Crypt::decrypt($value);
            }
        }

        return $attributes;
    }

    /**
     * Get the userDetails associated with the mlConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'sender_uuid');
    }

    /**
     * Get the senderDetails associated with the mlConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function senderDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'sender_uuid');
    }

    /**
     * Get the receiverDetails associated with the mlConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiverDetails(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'receiver_uuid');
    }

    /**
     * Get the fromThisRoom associated with the mlConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fromThisRoom(): HasOne
    {
        return $this->hasOne(UserFollow::class, 'room_uuid', 'room_uuid');
    }
}

<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class UserNotifications extends Model
{
    use HasFactory;

    protected $table='ml_notifications';


    protected $fillable = [
        'uuid',
        'notification_uuid',
        'from_uuid',
        'to_uuid',
        'type',
        'content',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the NotficationAuthor associated with the UserNotifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function NotificationAuthor(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'from_uuid');
    }

    /**
     * Get the NotificationReceiver associated with the UserNotifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function NotificationReceiver(): HasOne
    {
        return $this->hasOne(MembersModel::class, 'uuid', 'to_uuid');
    }
}

<?php

namespace App\Helper;

use App\Models\Users\UserNotifications;
use App\Models\Users\PostReaction;
use App\Models\Users\PostComments;

use Auth;
use Str;

class NotificationsForUser_Helper
{
    /* -------------------------------------------------------------------------- */
    /*                            Get user notification                           */
    /* -------------------------------------------------------------------------- */
    public static function getUserNotification()
    {
        /* Get notification for authenticated user by to uuid */
        $allNotifications = UserNotifications::where('to_uuid',Auth::guard('web')->user()->uuid)
        ->with('NotificationAuthor')
        ->with('NotificationReceiver')
        ->orderBy('created_at','DESC');
        return $allNotifications;
    }

    /* -------------------------------------------------------------------------- */
    /*                       Create or update notifications                       */
    /* -------------------------------------------------------------------------- */
    public static function createUserNotification($data)
    {
        /* Create new notifcation */
        extract($data);

        /* Check user if notification exist  */
        $UserNotifications = UserNotifications::where([
            ['from_uuid','=',$from_uuid],
            ['to_uuid','=',$to_uuid],
            ['type','=',$type],
            ['content','=',$content],
        ]);

        if ($UserNotifications->count() < 1) {

            /* Create notification */
            if ($to_uuid == Auth::guard('web')->user()->uuid) {
                return false;
            }

            do {
                $notification_uuid = Str::uuid();
            } while (UserNotifications::where('notification_uuid', '=', $notification_uuid)->first()  instanceof UserNotifications);

            $uncreate = UserNotifications::create([
                'notification_uuid' => $notification_uuid,
                'from_uuid' => $from_uuid,
                'to_uuid' => $to_uuid,
                'type' => $type,
                'content' => $content,
                'status' => $status,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);

            $uncreate->save();
            return $uncreate;
        }

        /* Update notification */
        if ($to_uuid == Auth::guard('web')->user()->uuid) {
            return false;
        }

        $unUpdate = $UserNotifications;
        $updateN = UserNotifications::find($unUpdate->first()->id);

        $updateN->status = $status;
        $updateN->created_at = $created_at;
        $updateN->updated_at = $updated_at;

        $updateN->save();
        return $updateN;
    }

    public static function notificationCountUnread()
    {
        /* Count unread notification */
        $unreadNotification = UserNotifications::where([
            ['to_uuid','=',Auth::guard('web')->user()->uuid],
            ['status','=',0]
        ])->get()->count();
        return $unreadNotification;
    }
}

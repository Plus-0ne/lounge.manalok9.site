<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Helpers */
use App\Helper\NotificationsForUser_Helper;
use App\Helper\CheckAuthUser_isFollower;
use App\Models\Users\PostFeed;
use App\Models\Users\UserNotifications;
use Illuminate\Support\Facades\Validator;

/* Models */
class NavUserNotification extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                Get user notification and throw json response               */
    /* -------------------------------------------------------------------------- */
    public function getNotificationsForUser(Request $request)
    {
        $notificationCountUnread = NotificationsForUser_Helper::notificationCountUnread();
        $userNotifications = NotificationsForUser_Helper::getUserNotification()->orderBy('status','ASC');
        $data = [
            'userNotifications' => $userNotifications->paginate(10),
            'unreadNotification' => $notificationCountUnread
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*             Get user notification by notification uuid and type            */
    /* -------------------------------------------------------------------------- */
    public function viewUserNotification(Request $request)
    {
        /* Validate ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }

        /* Validate input */
        $validate = Validator::make($request->all(),[
            'notification_uuid' => 'required',
            'type' => 'required'
        ]);

        /* Throw error response if validation fails */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get notifications details */
        $nd = UserNotifications::where('notification_uuid',$request->input('notification_uuid'));
        if ($nd->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Notification not found.'
            ];
            return response()->json($data);
        }

        /* If type */
        if ($nd->first()->type == 'follow') {
            $data = [
                'status' => 'info',
                'message' => 'for follower notification'
            ];
            return response()->json($data);
        }

        /* Get content details */
        $postDetails = PostFeed::where('post_id',$nd->first()->content);

        if ($postDetails->first()->visibility == 'private') {
            /* Notifications variables from_uuid = notifications sender and to_uuid = notifications receiver */
            $data = [
                'from_uuid' => $nd->first()->from_uuid,
                'to_uuid' => $nd->first()->to_uuid
            ];

            $isFollower = CheckAuthUser_isFollower::checkIfUserIsFollower($data);

            /* Check if authenticated user is a follower */
            if ($isFollower->count() < 1) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Follow this user to view his or her private post'
                ];
                return response()->json($data);
            }

            $nd->update([
                'status' => 1
            ]);

            $data = [
                'status' => 'success',
                'message' => 'View private post',
                'toPost' => $postDetails->first()->post_id,
                'redirectUrl' => route('user.view_this_posts')
            ];
            return response()->json($data);
        }

        /* If public post get post and get redirect url */
        $nd->update([
            'status' => 1
        ]);

        $data = [
            'status' => 'success',
            'message' => 'View post',
            'toPost' => $postDetails->first()->post_id,
            'redirectUrl' => route('user.view_this_posts')
        ];
        return response()->json($data);


    }
}

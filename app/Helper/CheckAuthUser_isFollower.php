<?php

namespace App\Helper;

use App\Models\Users\UserFollow;

class CheckAuthUser_isFollower
{
    public static function checkIfUserIsFollower($data)
    {
        extract($data);

        $checkUserifFollower = UserFollow::where([
            'follow_uuid' => $from_uuid,
            'uuid' => $to_uuid,
            'status' => 1
        ])
        ->with('myFollowers');

        return $checkUserifFollower;
    }
}

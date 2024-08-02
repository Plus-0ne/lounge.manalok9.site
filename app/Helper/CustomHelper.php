<?php

namespace App\Helper;

use App\Models\Users\MembersModel;
use App\Models\Users\VisitorLog;
use Carbon;

class CustomHelper
{
    /**
     * Get Members visitor log and status activity
     * @return string|array
     */
    public static function analytics() {
        $users_online = MembersModel::where('last_action', '>', Carbon::now()->subMinutes(10))->count();
        $users_registered = MembersModel::count();
        $visitor_count = VisitorLog::all()->count();

        $data = array(
            'users_online' => $users_online,
            'users_registered' => $users_registered,
            'visitor_count' => $visitor_count,
        );

        return $data;
    }
}

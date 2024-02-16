<?php

namespace App\Helper;

use App\Models\Admin\AdminLogs;
use Auth;
use Carbon;
use Str;

class AdminLogsHelper
{
    public static function addAdminAction($logAction,$logDescription,$logAlertLevel)
    {
        do {
            $uuid = Str::uuid();
        } while (AdminLogs::where("uuid", $uuid)->first() instanceof AdminLogs);

        $data = [
            'uuid' => $uuid,
            'admin_uuid' => Auth::guard('web_admin')->user()->admin_id,
            'action' => $logAction,
            'description' => $logDescription,
            'alert_level' => $logAlertLevel, // 0 = critical ; 1 = normal
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $adminlogs = AdminLogs::create($data);

        $adminlogs->save();
    }
}

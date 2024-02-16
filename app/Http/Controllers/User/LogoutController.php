<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Carbon;
use App\Models\Users\UserNotifications;

class LogoutController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                             Logout user account                            */
    /* -------------------------------------------------------------------------- */
    public function LogoutUser(Request $request)
    {

        /* Set variables */
        $oldNotif = null;

        /* Get user notifications */
        $all_notification = UserNotifications::where('to_uuid',Auth::guard('web')->user()->uuid);

        /* Foreach notification */
        foreach ($all_notification->get() as $row) {

            /* check if created_at is 1 month and above */
            $oldNotif = carbon::now()->diffInDays($row->created_at);

            /* If notification created_at is greater than or equal to 1 month */
            if ($oldNotif > 0 AND $row->status == 1) UserNotifications::find($row->id)->delete();
        }

        Auth::guard('web')->logout();
        Auth::guard('web_admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

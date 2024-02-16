<?php

namespace App\Helper;

use App\Models\Admin\AdminModel;
use Auth;

class GetAdminAccount
{
    public static function get()
    {
        /* Get user details */
        $adminDetails = AdminModel::where('id',Auth::guard('web_admin')->user()->id);
        $adminDetails->with('userAccount')->first();
        return $adminDetails;
    }
}

<?php

namespace App\Helper;

use App\Models\Admin\AdminModel;
use Auth;

class AdminRolesAndRestrictions
{
    public static function checkRole()
    {
        /* Check admin role */
        $admin_account = Auth::guard('web_admin')->user()->roles;
        return $admin_account;
    }
}

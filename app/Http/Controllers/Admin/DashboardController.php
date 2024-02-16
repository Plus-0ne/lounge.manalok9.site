<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                           Get admin user details                           */
    /* -------------------------------------------------------------------------- */
    public function adminUserDetails()
    {
        /* Get user details */
        $adminDetails = AdminModel::find(Auth::guard('web_admin')->user()->id)
        ->with('userAccount')
        ->first();
        return $adminDetails;
    }
}

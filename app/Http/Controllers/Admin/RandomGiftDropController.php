<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RandomGiftDropController extends Controller
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

    public function index()
    {
        /* Get user details */
        $adminDetails = $this->adminUserDetails();

        $data = array(
			'title' => 'Random Gift Drop | International Animal Genetics Database',
            'adminDetails' => $adminDetails
		);
		return view('pages/admins/admin-random-drop',['data'=>$data]);
    }
}

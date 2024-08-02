<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use URL;

class DealersController extends Controller
{
    /**
     * Page view for dealers form
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        // Get all notifications
        $notif = Notif_Helper::GetUserNotification();

        // Declare javascript variables
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        // Create data array for view
        $data = array(
            'title' => 'Be our dealers | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );

        // Return view
        return view('pages.users.user_be_a_dealer', ["data" => $data]);
    }
}

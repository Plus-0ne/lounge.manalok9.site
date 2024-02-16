<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Carbon\Carbon;

use App\Models\Users\MembersModel;
use App\Models\Users\VisitorLog;



class LandingController extends Controller
{
    public function __construct()
    {
        $users_online = MembersModel::where('last_action', '>', Carbon::now()->subMinutes(10))->count();
        $users_registered = MembersModel::count();
        $visitor_count = VisitorLog::all()->count();

        $data = array(
            'users_online' => $users_online,
            'users_registered' => $users_registered,
            'visitor_count' => $visitor_count,
        );

        View::share('analytics', $data);
    }

    public function index()
    {
        $data = [
            'title' => 'International Animals Genetics Database'
        ];
        return view('pages/landing-page-v2', $data);
    }
}

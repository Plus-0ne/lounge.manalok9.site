<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CookiesPolicy extends Controller
{
    public function index(Request $request)
    {
        return view('pages/page-information/cookies_policy');
    }
}

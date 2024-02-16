<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyPolicy extends Controller
{
    public function index(Request $request)
    {
        return view('pages/page-information/privacy_policy');
    }
}

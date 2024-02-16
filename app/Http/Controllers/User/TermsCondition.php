<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsCondition extends Controller
{
    public function index(Request $request)
    {
        return view('pages/page-information/terms_and_condition');
    }
}

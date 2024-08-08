<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\Dealers;
use Illuminate\Http\Request;

class DealersController extends Controller
{
    /**
     * Show dealers page
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
        $dealersApplicant = Dealers::all();


        $data = array(
            'title' => 'Verification | International Animal Genetics Database',
            'dealersApplicant' => $dealersApplicant
        );

        return view('pages/admins/admin-dealer-verification', ['data' => $data]);
    }

    /**
     * Show approved dealers page
     * @return \Illuminate\Contracts\View\View
     */
    public function approvedDealers() {

    }
}

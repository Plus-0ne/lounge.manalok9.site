<?php

namespace App\Http\Controllers\Admin;

use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Users\AnimalCertRequest;
use Illuminate\Http\Request;
use JavaScript;
use URL;

class CertificationRequestController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                         Certification request page                         */
    /* -------------------------------------------------------------------------- */
    /**
     * Certification request page
     *
     * @return View
     */
    public function index()
    {
        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $cert_req = AnimalCertRequest::with('requestCreator')
        ->with('animalDetails')->get();

        $data = array(
            'title' => 'Certification Request | International Animal Genetics Database',
            'cert_req' => $cert_req
        );

        return view('pages/admins/admin-certification-request', ['data' => $data]);
    }

}

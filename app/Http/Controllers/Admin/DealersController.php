<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Dealers;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use URL;
use Validator;

class DealersController extends Controller
{
    /**
     * Show dealers page
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        JavaScript::put([
            'urlBase' => URL::to('/'),
            'assetUrl' => asset('/')
        ]);
        $dealersApplicant = Dealers::all();

        $data = array(
            'title' => 'Dealers | International Animal Genetics Database',
            'dealersApplicant' => $dealersApplicant
        );

        return view('pages/admins/admin-dealer-verification', ['data' => $data]);
    }

    /**
     * Updade dealer status
     * @param Request $request
     * @return
     */
    public function updateDealerStatus(Request $request) {

        // Check request if ajax
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];

            return response()->json($data);
        }

        // Create rules
        $rules = [
            'uuid' => 'required',
            'type' => 'required'
        ];

        // Create validation message
        $message = [
            'uuid.required' => 'Please enter your uuid!',
            'type.required' => 'Please select update type'
        ];

        // Validate request
        $validate = Validator::make($request->all(),$rules,$message);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }

        $id = CustomHelper::convertUuidToId($request->input('uuid'),Dealers::class);

        switch ($request->input('type')) {
            case 'approve':
                $dealer = $this->approveDealer($id);
                break;
            case 'reject':
                $dealer = $this->rejectDealer($id);
                break;
            default:
                $data = [
                    'status' => 'error',
                    'message' => 'Something\'s wrong! Please try again later.'
                ];

                return response()->json($data);
        }

        return response()->json($dealer);
    }

    public function approveDealer($id) {
        $dealer = Dealers::find($id);

        if ($dealer->status == 0) {
            return $data = [
                'status' => 'warning',
                'message' => 'This application is already rejected.'
            ];
        }

        if ($dealer->status == 2) {
            return $data = [
                'status' => 'warning',
                'message' => 'This application is already approved.'
            ];
        }


        $dealer->status = 2;

        if (!$dealer->save()) {
            return $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
        }

        return $data = [
            'status' => 'success',
            'message' => 'Dealer approved successfully!'
        ];


    }

    public function rejectDealer($id) {

        $dealer = Dealers::find($id);

        if ($dealer->status == 0) {
            return $data = [
                'status' => 'warning',
                'message' => 'This application is already rejected.'
            ];
        }

        if ($dealer->status == 2) {
            return $data = [
                'status' => 'warning',
                'message' => 'This application is already approved.'
            ];
        }
        
        $dealer->status = 0;

        if (!$dealer->save()) {
            return $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
        }

        return $data = [
            'status' => 'success',
            'message' => 'Dealer application has been rejected!'
        ];

    }
}

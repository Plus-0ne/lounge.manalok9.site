<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Users\MembersModel;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;
use Validator;

class QrCodeController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                           Download qrcode of user                          */
    /* -------------------------------------------------------------------------- */
    public function qrcode_download(Request $request)
    {
        /* Validate request */
        $validate = Validator::make($request->all(), [
            'uuid' => 'required'
        ], [
            'uuid.required' => 'Something\'s wrong! Please try again later.'
        ]);

        if ($validate->fails()) {

            return redirect()->back()->withErrors($validate);
        }
        $pPath = public_path('/img/qr-code');
        if (!file_exists($pPath)) {
            mkdir($pPath, 0777, true);
        }


        /* Create url for qrcode text */
        $qrUrl = route('user.qr_result_user') . '?uuid=' . $request->input('uuid');
        $output_file = '/qrcode-img-' . time() . '.png';
        QrCode::format('png')
            ->errorCorrection('H')
            ->color(30, 37, 48)
            ->backgroundColor(255, 255, 255)
            ->margin(2)
            ->size(500)
            ->generate($qrUrl, $pPath . '/' . $output_file);

        $paa = $pPath . '/' . $output_file;

        return response()->download($paa)->deleteFileAfterSend(true);
    }

    /* -------------------------------------------------------------------------- */
    /*                            Qr code scanner page                            */
    /* -------------------------------------------------------------------------- */
    public function qrcode_scanner()
    {
        $data = [
            'title' => 'IAGD QR Code scanner'
        ];
        return view('pages/qrCode-scanner', $data);
    }

    /* -------------------------------------------------------------------------- */
    /*                               QR result user                               */
    /* -------------------------------------------------------------------------- */
    public function qr_result_user(Request $request)
    {
        $validate = Validator::make($request->input(), [
            'uuid' => 'required'
        ], [
            'uuid.required' => 'User not found! Please try again later.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            /* Page view for user scanned */
            return view('pages.qr-result-user')->with($data);
        }

        $users = MembersModel::where('uuid',$request->input('uuid'));

        /* Check if user exist */
        if ($users->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'User does not exist.'
            ];
            /* Page view for user scanned */
            return view('pages.qr-result-user')->with($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Scanned user found.',
            'user' => $users
        ];
        /* Page view for user scanned */
        return view('pages.qr-result-user')->with($data);
    }
}

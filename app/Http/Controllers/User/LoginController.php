<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Browser;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;

/* USER MODEL */
use App\Models\Users\MembersModel;
use App\Models\Users\MembersDevice;


class LoginController extends Controller
{
    public function user_loginvalidation(Request $request)
    {
        /*
            Run validation
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'validate_error',
                'message' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }
        $validate = Validator::make($request->all(), [
            'unique_id' => 'required',
            'password' => 'required',
        ], [
            'unique_id.required' => 'Enter your email address',
            'password.required' => 'Enter your password',
        ]);

        /*
            Check if valiation failed - Throw response
        */
        if ($validate->fails()) {

            $data = [
                'status' => 'validate_error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);

        }

        /*
            Check if remember me is checked
        */
        if ($request->input('rememberMe') == 1) {
            $rememberMe = 'true';
        }
        else
        {
            $rememberMe = 'false';
        }

        /*
            Assign variables
        */
        $uniqueid = $request->input('unique_id');
        $password = $request->input('password');

        /*
            User authentication
        */
        $fieldType = filter_var($uniqueid, FILTER_VALIDATE_EMAIL) ? 'email_address' : 'iagd_number';
        if (Auth::guard('web')->attempt([
            $fieldType => $uniqueid,
            'password' => $password,
        ],$rememberMe)) {

            /* Attempt to login admin */
            $admin = AdminModel::where('user_uuid', '=', Auth::guard('web')->user()->uuid)->first();

            if ($admin != null)
            {
                Auth::guard('web_admin')->loginUsingId($admin->id);
            }

            $request->session()->regenerate();


            /* Log device login */
            $browser = Browser::browserFamily() . ' ' . Browser::browserVersion() . ' ' . Browser::browserVersionPatch() . ' ' . Browser::browserEngine();
            $platform = Browser::platformFamily() . ' ' . Browser::platformVersion() . ' ' . Browser::platformVersionPatch();
            $current_device = Browser::deviceFamily() . '' . Browser::deviceModel();

            $InsertDevice = MembersDevice::create([
                'mem_id' => Auth::guard('web')->user()->id,
                'ip_address' => $request->ip(),
                'device_type' => Browser::deviceType(),
                'browser' => $browser,
                'platform' => $platform,
                'current_device' => $current_device,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $InsertDevice->save();

            $user_info = Auth::guard('web')->user();

            $iagd_number_uuid = 'IAGD-' . str_pad($user_info->id, 6, '0', STR_PAD_LEFT);



            /** @var - $user_info = authenticated user **/

            if ($user_info->iagd_number == null) {
                $user_info->iagd_number = $iagd_number_uuid;
                $user_info->save();
            }

            $data = [
                'status' => 'user_is_onlineeee',
                'message' => route('dashboard')
            ];

            return response()->json($data);

        }
        else
        {
            $data = [
                'status' => 'incorrect_cred',
                'message' => 'Incorrect credentials'
            ];
            return response()->json($data);
        }
    }
}

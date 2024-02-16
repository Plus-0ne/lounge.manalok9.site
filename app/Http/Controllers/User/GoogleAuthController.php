<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use Carbon\Carbon;

use App\Models\Users\MembersModel;
use App\Models\Users\EmailVerification;
use Validator;

class GoogleAuthController extends Controller
{
    public function google_auth_redirect(Request $request)
    {
        // return Socialite::driver('google')->redirect();
    }

    public function google_auth(Request $request)
    {
        // var_dump(Socialite::driver('google')->user());
    }

    /* DECODE JWT */
    public function decodeJwt_google($token)
    {
        $tokenParts = explode(".", $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        return $jwtPayload;
    }

    /*
        GOOGLE AUTHENTICATION
    */
    public function validate_g_login(Request $request)
    {
        /*
            * Validate requests
        */
        $validate = Validator::make($request->all(), [
            'cred' => 'required'
        ], [
            'cred.required' => 'Something\'s wrong, Please refresh the page.'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /*
            * Decode jwt_google response
        */
        $token = $request->input('cred');

        $jwtRes = $this->decodeJwt_google($token);


        /*
            * Assign variables to decoded jwt response
        */
        $email_address = $jwtRes->email;
        $email_verified = $jwtRes->email_verified;
        $googleUid = $jwtRes->sub;
        $googlegiven_name = $jwtRes->given_name;
        $googlefamily_name = $jwtRes->family_name;

        /*
            * Check if email address is verified
        */
        if ($email_verified == false) {
            $data = [
                'status' => 'warning',
                'message' => 'Your google email account is not verified',
            ];
            return response()->json($data);
        }

        /*
            * Check user credintials in db
        */
        $CheckCredentials = MembersModel::where('email_address', $email_address);
        $ccred = $CheckCredentials->first();

        if ($CheckCredentials->count() > 0) {
            /*
                * Check if email is verified
            */
            if ($ccred->is_email_verified == 0) {
                /*
                    * REDIRECT TO VERIFICATION PAGE
                */
                $data = [
                    'status' => 'warning',
                    'message' => 'Your email is not verified.',
                ];
                return response()->json($data);
            }

            /*
                * CHECK IF ACCOUNT AND GOOGLE IS LINKED
            */
            if ($ccred->isGoogle == $googleUid) {
                /*
                    * Login this user account
                */
                Auth::guard('web')->login($CheckCredentials->first());
                Auth::guard('web_admin')->login($CheckCredentials->first());

                $user_info = Auth::guard('web')->user();

                $iagd_number_uuid = 'IAGD-' . str_pad($user_info->id, 6, '0', STR_PAD_LEFT);

                /** @var - $user_info = authenticated user **/

                if ($user_info->iagd_number == null) {
                    $user_info->iagd_number = $iagd_number_uuid;
                    $user_info->save();
                }

                $data = [
                    'status' => 'success',
                    'message' => 'User has been logged in',
                    'redirectUrl' => route('dashboard'),
                ];
                return response()->json($data);
            } else {
                /*
                    * Redirect to page consent to link google and lounge account
                */
                $gAccount = [
                    'googleUid' => $googleUid,
                    'googleEmailAddress' => $email_address,
                ];
                $request->session()->put('googleLinkAccount', $gAccount);

                $data = [
                    'status' => 'warning',
                    'message' => 'Your email address will be link in your IAGD account.',
                    'redirectUrl' => route('user.account_link_google')
                ];
                return response()->json($data);
            }
        } else {
            /*
                * Create email verification
            */

            do {
                $eToken = Str::random(64);
            } while (EmailVerification::where('token', '=', $eToken)->first()  instanceof EmailVerification);

            $expiration = time();

            $created_at = Carbon::now();
            $updated_at = Carbon::now();

            $CheckIfUserhasVerfication = EmailVerification::where('email_address', $email_address);
            if ($CheckIfUserhasVerfication->count() > 0) {
                $cuhv = $CheckIfUserhasVerfication->first();

                $row_id = $cuhv->id;

                $updateEmailV = EmailVerification::find($row_id);

                $updateEmailV->token = $eToken;
                $updateEmailV->expiration = $expiration;
                $updateEmailV->updated_at = $updated_at;

                if ($updateEmailV->save()) {
                    /*
                       * SET SESSION GOOGLE ID AND EMAIL
                       * REDIRECT TO PAGE REGISTRATION WITH TOKEN
                    */
                    $gAccount = [
                        'googleUid' => $googleUid,
                        'googlegiven_name' => $googlegiven_name,
                        'googlefamily_name' => $googlefamily_name,
                    ];
                    $request->session()->put('register_this_googleacount', $gAccount);
                    $request->session()->put('register_this_email', $email_address);

                    $data = [
                        'status' => 'success',
                        'message' => 'Continue to registration page',
                        'redirectUrl' => route('user.user_registration') . '?tk=' . $eToken
                    ];
                    return response()->json($data);
                } else {
                    $data = [
                        'status' => 'warning',
                        'message' => 'Failed to save verification',
                    ];
                    return response()->json($data);
                }
            }

            /*
                * If email verification count is less than 1 or no row found
            */
            $insertEmailVerify = EmailVerification::create([
                'email_address' => $email_address,
                'token' => $eToken,
                'expiration' => $expiration,
                'verified' => 0,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);

            if ($insertEmailVerify->save()) {
                /*
                    * SET SESSION GOOGLE ID AND EMAIL
                    * REDIRECT TO PAGE REGISTRATION WITH TOKEN
                */
                $gAccount = [
                    'googleUid' => $googleUid,
                    'googlegiven_name' => $googlegiven_name,
                    'googlefamily_name' => $googlefamily_name,
                ];
                $request->session()->put('register_this_googleacount', $gAccount);
                $request->session()->put('register_this_email', $email_address);

                $data = [
                    'status' => 'success',
                    'message' => 'Continue to registration page',
                    'redirectUrl' => route('user.user_registration') . '?tk=' . $eToken
                ];
                return response()->json($data);
            } else {
                $data = [
                    'status' => 'warning',
                    'message' => 'Failed to save verification',
                ];
                return response()->json($data);
            }
        }
    }
    /*
        LINK GOOGLE ACCOUNT TO LOUNGE ACCOUNT
    */
    public function account_link_google(Request $request)
    {
        if (!$request->session()->has('googleLinkAccount')) {
            return redirect()->route('user.login');
        }
        $data = array(
            'title' => 'Link your Google account | IAGD Members Lounge',
        );
        return view('pages/users/user-page-link', ["data" => $data]);
    }

    /*
        AJAX LINK ACCOUNT FUNCTION
    */
    public function linkmyAccount(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('user.login');
        }
        if (!$request->session()->has('googleLinkAccount')) {
            $data = [
                'status' => 'warning',
                'message' => 'Somethig\'s wrong.',
                'redirectUrl' => route('user.login')
            ];
            return response()->json($data);
        }
        if (!$request->has('linkmyAccount') || empty($request->input('linkmyAccount'))) {
            $data = [
                'status' => 'warning',
                'message' => 'Somethig\'s wrong.',
                'redirectUrl' => route('user.login')
            ];
            return response()->json($data);
        }

        /*
            FIND ACCOUNT
        */
        $googleUid = $request->session()->get('googleLinkAccount.googleUid');
        $email_address = $request->session()->get('googleLinkAccount.googleEmailAddress');
        $timez = $request->input('timez');
        if (!empty($timez)) {
            $updated_at = Carbon::now();
        } else {
            $updated_at = Carbon::now();
        }
        $CheckAccount = MembersModel::where('email_address', $email_address);

        if ($CheckAccount->count() > 0) {
            /*
                LINK ACCOUNT
            */
            $ca = $CheckAccount->first();

            $row_id = $ca->id;

            $UpdateAccount = MembersModel::find($row_id);

            $UpdateAccount->isGoogle = $googleUid;
            $UpdateAccount->updated_at = $updated_at;

            if ($UpdateAccount->save()) {


                Auth::guard('web')->login($UpdateAccount);

                $request->session()->forget('googleLinkAccount');

                $data = [
                    'status' => 'success',
                    'message' => 'User has been logged in',
                    'redirectUrl' => route('dashboard'),
                ];

                return response()->json($data);
            } else {
                $data = [
                    'status' => 'warning',
                    'message' => 'Somethig\'s wrong.',
                    'redirectUrl' => route('user.login')
                ];
                return response()->json($data);
            }
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Somethig\'s wrong.',
                'redirectUrl' => route('user.login')
            ];
            return response()->json($data);
        }
    }
}

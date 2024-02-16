<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/* CLASSESS */
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Hash;
use Auth;
use Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

/* USERS */
use App\Models\Users\MembersModel;
use App\Models\Users\ResetPassword;
use App\Models\Users\EmailVerification;


class RegistrationController extends Controller
{

    /* EMAIL PUBLIC FUNCTION FOR SENDING VERIFICATION LINK */
    public function sendEmailToUser($email_data)
    {
        try {
            extract($email_data);

            $email_sender = Config::get('gl_settings.app_email_address');
            $receiver = $email_address;
            $token = $token;

            $verification_link = route('user.user_registration').'?tk='.$token;

            $data = array(
                'verification_link' => $verification_link,
            );
            $send_email = Mail::send('pages/users/template/emails/mail-verify-iagd', $data, function ($message) use ($receiver,$email_sender) {
                $message->to($receiver, $receiver)
                    ->subject('Email confirmation');
                $message->from($email_sender, 'email-confirmation@lounge.metaanimals.org');
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function email_verification_sample()
    {
        return view('pages/users/template/emails/mail-verify-iagd');
    }

    /* EMAIL CONFIRMATION PAGE WHEN CREATE ACCOUNT IS CLICK */
    public function email_confirmation(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        $data = array(
            'title' => 'Enter your email address | IAGD Members Lounge',
        );
        return view('pages/users/user-email-confirmation', ['data' => $data]);
    }


    /* EMAIL LINK PAGE WHEN USER CLICK THE BUTTON IN EMAIL DOCUMENT */
    public function user_registration(Request $request)
    {
        /* CHECK IF TOKEN KEY IS SET */
        if (!$request->has('tk')) {
            $data = [
                'page_title' => 'Invalid access',
                'title' => 'Whoops! ',
                'status' => 'Invalid request',
                'backUrl' => route('user.login')
            ];
            return view('errors/page-expired',$data);
        }

        /* CHECK IF TOKEN VALUE IS SET */
        if (empty($request->input('tk'))) {
            $data = [
                'page_title' => 'Invalid access',
                'title' => 'Whoops! ',
                'status' => 'Invalid request',
                'backUrl' => route('user.login')
            ];
            return view('errors/page-expired',$data);
        }


        /* CHECK IF TOKEN IS EXIST */

        $token = $request->input('tk');

        $CheckToken = EmailVerification::where('token',$token);
        if ($CheckToken->count() < 1) {
            $data = [
                'page_title' => 'Invalid access',
                'title' => 'Whoops! ',
                'status' => 'Invalid request',
                'backUrl' => route('user.login')
            ];
            return view('errors/page-expired',$data);
        }

        /* CHECK IF TOKEN IS EXPIRED  */
        $ct = $CheckToken->first();

        $expiration = $ct->expiration;
        $current_time = time();

        if (($current_time - $expiration) > 600) {
            $data = [
                'page_title' => 'Expired',
                'title' => 'Whoops! ',
                'status' => 'Page is expired. Send a new link',
                'backUrl' => route('user.email_confirmation')
            ];
            return view('errors/page-expired',$data);
        }

        /* CHECK IF VERIFIED ALREADY */
        if ($ct->verified == 1) {
            $data = [
                'page_title' => 'Already verified',
                'title' => 'Whoops! ',
                'status' => 'You already have an account',
                'backUrl' => route('user.login')
            ];
            return view('errors/page-expired',$data);
        }

        /* PUT EMAIL TO SESSION */
        $request->session()->put('register_this_email', $ct->email_address);

        $data = array(
            'title' => 'Registration | IAGD Members Lounge',
        );
        return view('pages/users/user-registration', ['data' => $data]);
    }

    /* SEND VERIFICATION LINK TO EMAIL ADDRESS */
    public function verify_email_address(Request $request)
    {
        /* CHECK IF FORM KEY IS SET */
        if (!$request->has('email_address')) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong, Please refresh the page.',
            ];

            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }
        /* CHECK IF INPUT IS NULL */
        $validate = Validator::make($request->all(),[
            'email_address' => 'required|email'
        ],[
            'email_address.required' => 'Enter your email address',
            'email_address.email' => 'Enter a valid email address',
        ]);
        if ($validate->fails()) {
            $data = [
                'status' => 'validation_error',
                'message' => $validate->errors()->first(),
            ];

            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }

        /* CHECK IF USER IS ALREADY REGISTERED */
        $CheckIfRegistered = MembersModel::where('email_address',$request->input('email_address'));
        if ($CheckIfRegistered->count() > 0) {
            $data = [
                'status' => 'already_registered',
                'message' => 'This email address is already registered',
            ];

            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }

        /* CHECK EMAIL VERIFICATION */
        $email_address = $request->input('email_address');

        $CheckEmailVerification = EmailVerification::where('email_address',$email_address);
        if ($CheckEmailVerification->count() > 0) {
            /* UPDATE EMAIL VERIFICATION */

            $cev = $CheckEmailVerification->first();

            $row_id = $cev->id;
            $token_expiration = $cev->expiration;
            $current_time = time();

            if (($current_time - $token_expiration) <= 600) {

                $remainingTime = (($token_expiration + 600) - time());
                $remainingTime = gmdate("i:s", $remainingTime);
                $data = [
                    'status' => 'warning',
                    'message' => 'Email already sent to your inbox. Wait for '.$remainingTime.' seconds to send again.',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }

            /* UPDATE TOKEN AND EXPIRATION */
            do {
                $token = Str::random(64);
            } while (EmailVerification::where('token', '=', $token)->first()  instanceof EmailVerification);

            $expiration = time();

            $updated_at = Carbon::now();

            /* SEND EMAIL VERIFICATION */
            $email_data = [
                'email_address' => $email_address,
                'token' => $token
            ];

            if ($this->sendEmailToUser($email_data) == false) {

                /* PUT EMAIL TO SESSION */
                $request->session()->put('register_this_email', $email_address);

                $data = [
                    'status' => 'failed_to_sent_email',
                    'message' => 'Failed to send email, Please try again later',
                ];

                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
            else
            {
                /* UPDATE EMAIL VERIFICATION */
                $UpdateEmailVerification = EmailVerification::find($row_id);

                $UpdateEmailVerification->token = $token;
                $UpdateEmailVerification->expiration = $expiration;
                $UpdateEmailVerification->updated_at = $updated_at;

                $UpdateEmailVerification->save();

                $data = [
                    'status' => 'mail_sent_to_email',
                    'message' => 'We sent a link to your email address. Check your inbox or spam.',
                ];

                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
        }
        else
        {


            do {
                $token = Str::random(64);
            } while (EmailVerification::where('token', '=', $token)->first()  instanceof EmailVerification);

            $expiration = time();

            $created_at = Carbon::now();
            $updated_at = Carbon::now();

            /* SEND EMAIL VERIFICATION */
            $email_data = [
                'email_address' => $email_address,
                'token' => $token
            ];

            if ($this->sendEmailToUser($email_data) == false) {

                $data = [
                    'status' => 'failed_to_sent_email',
                    'message' => 'Failed to send email, Please try again later',
                ];

                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
            else
            {
                /* INSERT EMAIL VERIFICATION */
                $insertEmailVerify = EmailVerification::create([
                    'email_address' => $request->input('email_address'),
                    'token' => $token,
                    'expiration' => $expiration,
                    'verified' => 0,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                $insertEmailVerify->save();

                $data = [
                    'status' => 'mail_sent_to_email',
                    'message' => 'We sent a link to your email address. Check your inbox or spam.',
                ];

                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
        }
    }

    /* REGISTER NEW USER */
    public function create_account(Request $request)
    {
        /* SET KEYS */
        $key_array = [
            '_token',
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'contact_number',
            'password1',
            'password2',
            'referral_code',
            'timez',
        ];

        if (!$request->session()->has('register_this_email') || empty($request->session()->get('register_this_email'))) {
            $data = [
                'status' => 'warning',
                'message' => 'Invalid request',
                'redirecToUrl' => route('user.login')
            ];



            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->route('user.login')->with($data);
            }
        }
        /* LOOP THROUGH REQUEST CHECK IF KEY IS SET */
        foreach ($request->all() as $key => $value) {
            if (!in_array($key,$key_array)) {
                $data = [
                    'status' => 'key_error',
                    'message' => 'Something\'s wrong, Please refresh the page.',
                ];

                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }

            }
        }

        /* CREATE VAILDATION */
        $validate = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'contact_number' => 'required',

            'password1' => 'required',
            'password2' => 'required',
        ],[
            'first_name.required' => 'Enter your first name',
            'last_name.required' => 'Enter your last name',
            'gender.required' => 'Select your gender',
            'birth_date.required' => 'Enter your birth date',
            'contact_number.required' => 'Enter your contact number',

            'password1.required' => 'Enter your password',
            'password2.required' => 'Enter your password',
        ]);

        /* CHECK IF VALIDATION FAILED */
        if ($validate->fails()) {
            $data = [
                'status' => 'validation_error',
                'message' => $validate->errors()->first()
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }


        $email_address = $request->session()->get('register_this_email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $googleUid = null;
        /*
            CHECK IF USER SIGNUP AS GOOGLE USER
        */
        if ($request->session()->has('register_this_googleacount')) {
            $googleUid = $request->session()->get('register_this_googleacount.googleUid');
            $first_name = $request->session()->get('register_this_googleacount.googlegiven_name');
            $last_name = $request->session()->get('register_this_googleacount.googlefamily_name');
        }

        /* CHECK IF EMAIL EXIST */
        $CheckMembers = MembersModel::where('email_address',$email_address);
        if ($CheckMembers->count() > 0) {
            $data = [
                'status' => 'email_exist',
                'message' => 'This email address is already registered'
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }

        /* CHECK IF PASSWORD IS NOT EQUAL */
        if ($request->input('password1') != $request->input('password2')) {
            $data = [
                'status' => 'password_not_matched',
                'message' => 'Password did not matched'
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }

        /* INSERT TO DATABASE */
        do {
            $uuid = Str::uuid();
        } while (MembersModel::where('uuid', '=', $uuid)->first()  instanceof MembersModel);

        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        /* Generate IAGD Number */
        // $iagd_number_uuid = IdGenerator::generate([
        //     'table' => 'iagd_members',
        //     'length' => 11,
        //     'prefix' => 'IAGD-',
        //     'field' => 'iagd_number'
        // ]);

        // SET DEFAULT IAGD# TO NULL, IAGD# IS GENERATED ON LOGIN
        $iagd_number_uuid = NULL;

        $InsertUser = MembersModel::create([
            'uuid' => $uuid,
            'iagd_number' => $iagd_number_uuid,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $request->input('gender'),
            'birth_date' => $request->input('birth_date'),
            'contact_number' => $request->input('contact_number'),
            'email_address' => $email_address,
            'password' => Hash::make($request->input('password1')),

            'isGoogle' => $googleUid,
            'referred_by' => $request->input('referral_code'),
            'is_email_verified' => 1,
            'timezone' => $request->input('timez'),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        if ($InsertUser->save()) {

            /* UPDATE TOKEN  */
            $UpdateEmailVerification = EmailVerification::where('email_address',$email_address);

            $uev = $UpdateEmailVerification->first();

            $UpdatedNow = EmailVerification::find($uev->id);

            $UpdatedNow->verified = 1;
            $UpdatedNow->updated_at = $updated_at;

            $UpdatedNow->save();

            if ($request->session()->has('register_this_email')) {
                $request->session()->forget('register_this_email');
            }
            if ($request->session()->has('register_this_googleacount')) {
                $request->session()->forget('register_this_googleacount');
            }

            $data = [
                'status' => 'account_created',
                'message' => 'Account created successfully!',
                'redirecToUrl' => route('user.login')
            ];



            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->route('user.login')->with($data);
            }
        }
        else
        {
            $data = [
                'status' => 'account_not_created',
                'message' => 'Failed to create your account'
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }
    }

    /* PASSWORD RESET */

    public function forgot_password(Request $request)
    {
        $data = array(
            'title' => 'Forgot Password | IAGD Members Lounge',
        );
        return view('pages/users/user-forgot-password', ["data" => $data]);
    }

    public function send_email_for_passwordreset($mail_data)
    {
        try {
            extract($mail_data);

            $email_sender = Config::get('gl_settings.app_email_address');
            $receiver = $email_address;
            $token = $token;

            $verification_link = route('user.reset_your_password').'?em='.$receiver.'&tk='.$token;

            $data = array(
                'verification_link' => $verification_link,

            );
            $send_email = Mail::send('pages/users/template/emails/mail-forgot-password', $data, function ($message) use ($receiver,$email_sender) {
                $message->to($receiver,$receiver)->subject('Reset password');
                $message->from($email_sender, 'password-reset@lounge.metaanimals.org');
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function check_email_address(Request $request)
    {

        /* CHECK IF EMAIL ADDRESS KEY NAME IS SET */
        if (!$request->has('email_address')) {
            $data = [
                'status' => 'key_error',
                'message' => 'Somethin\'s wrong! Please try again.',
            ];

            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->with($data);
            }

        }

        /* MAKE A VALIDATION FOR INPUT */
        $validate = Validator::make($request->all(),[
            'email_address' => 'required|email'
        ],[
            'email_address.required' => 'Enter your email address!',
            'email_address.email' => 'Email address is invalid!'
        ]);

        /* THROW RESPONSE IF VALIDATION FAILED */
        if ($validate->fails()) {
            $data = [
                'status' => 'failed_validate',
                'message' => $validate->errors()->first(),
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->with($data);
            }
        }

        /* CHECK IF USER IS LOGGED IN */
        if (Auth::guard('web')->check()) {

            /* LOGOUT USER */
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        /* GET USER USING EMAIL */
        $email = $request->input('email_address');
        $MembersData = MembersModel::where('email_address',$email);

        if ($MembersData->count() > 0) {

            $md = $MembersData->first();
            if ($md->is_email_verified != 1) {
                $data = [
                    'status' => 'verify_email_pls',
                    'message' => 'You need to verify your email address',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
            $CheckResetPass = ResetPassword::where('email_address',$email);

            if ($CheckResetPass->count() > 0) {
                $crp = $CheckResetPass->first();

                /* CHECK VALIDITY */
                if ((time() - $crp->expiration) > 600) {
                    /* RESEND EMAIL PASSWORD RESET */

                    do {
                        $email_address = $md->email_address;
                        $token = Str::random(32);
                    } while (ResetPassword::where("email_address", "=", $email_address)->where("token", "=", $token)->first() instanceof ResetPassword);


                    $UpdateResetPassword = ResetPassword::find($crp->id);

                    $UpdateResetPassword->email_address = $email_address;
                    $UpdateResetPassword->token = $token;
                    $UpdateResetPassword->expiration = time();
                    $UpdateResetPassword->created_at = Carbon::now();
                    $UpdateResetPassword->updated_at = Carbon::now();

                    $UpdateResetPassword->save();

                    $mail_data = [
                        'email_address' => $email_address,
                        'token' => $token,
                    ];

                    if ($this->send_email_for_passwordreset($mail_data) == false) {
                        $data = [
                            'status' => 'mail_not_sent',
                            'message' => 'Can\'t send email',
                        ];
                        if ($request->ajax()) {
                            return response()->json($data);
                        }
                        else
                        {
                            return redirect()->back()->withInput()->with($data);
                        }
                    }


                    $data = [
                        'status' => 'mail_sent',
                        'message' => 'We sent an email to your email address. Please check your inbox or spam mails.',
                    ];
                    if ($request->ajax()) {
                        return response()->json($data);
                    }
                    else
                    {
                        return redirect()->back()->withInput()->with($data);
                    }
                }
                else
                {
                    $remainingTime = (($crp->expiration + 600) - time());
                    $remainingTime = gmdate("i:s", $remainingTime);
                    $data = [
                        'status' => 'wait_for_seconds',
                        'message' => 'Wait for '.$remainingTime.' seconds',
                    ];
                    if ($request->ajax()) {
                        return response()->json($data);
                    }
                    else
                    {
                        return redirect()->back()->withInput()->with($data);
                    }
                }

            }
            /* CREATE NEW PASWORD RESET RECORD */

            do {
                $email_address = $email;
                $token = Str::random(32);
            } while (ResetPassword::where("email_address", "=", $email_address)->where("token", "=", $token)->first() instanceof ResetPassword);

            $InsertPasswordReset = ResetPassword::create([
                'email_address' => $email_address,
                'token' => $token,
                'expiration' => time(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($InsertPasswordReset->save()) {


                /* SEND EMAIL FOR PASSWORD RESET */
                $mail_data = [
                    'email_address' => $email_address,
                    'token' => $token,
                ];

                $this->send_email_for_passwordreset($mail_data);

                $data = [
                    'status' => 'mail_sent',
                    'message' => 'We sent an email to your email address. Please check your inbox or spam mails.',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }
            else
            {
                $data = [
                    'status' => 'error_saving',
                    'message' => 'Somethin\'s wrong! Please try again.',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->back()->withInput()->with($data);
                }
            }


        }
        else
        {
            $data = [
                'status' => 'member_not_found',
                'message' => 'Please check your email address',
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->with($data);
            }
        }

    }

    public function reset_your_password(Request $request)
    {
        /* CHECK IF VARIABLES IS SET AND NOT NULL */
        if (!$request->has('em') || !$request->has('tk') || empty($request->input('em')) || empty($request->input('tk'))) {
            return redirect()->route('user.login')->with('response','key_error');
        }

        $email_address = $request->input('em');
        $token = $request->input('tk');

        /* CHECK IF PASSWORD RESET IS VALID */
        $CheckVerificationEmail = EmailVerification::where('email_address',$email_address);
        if ($CheckVerificationEmail->count() > 0) {
            $cve = $CheckVerificationEmail->first();

            if ($cve->verified == 0) {
                return redirect()->route('user.login')->with('response','verify_em_first');
            }
        }
        else
        {
            return redirect()->route('user.login')->with('response','verify_em_first');
        }

        /* GET PASSWORD RESET REQUEST */
        $CheckResetPass = ResetPassword::where('email_address','=',$email_address)->where('token','=',$token);
        $crp = $CheckResetPass->first();

        /* PASSWORD RESET DOESNT EXIST */
        if (!$CheckResetPass->count() > 0) {
            return redirect()->route('user.login')->with('response','invalid_pass_res_req');
        }

        /* CHECK REQUEST VALIDITY */

        $time_elapse = (time() - $crp->expiration);

        if ($time_elapse > 600) { // GREATER THAN 600 INVALID PASSWORD RESET REQUEST
            return redirect()->route('user.login')->with('response','invalid_pass_res_req');
        }

        /* SET ID TO SESSION */
        $Members = MembersModel::where('email_address',$email_address);

        if (!$Members->count() > 0) {
            return redirect()->route('user.login')->with('response','reg_needed');
        }
        $request->session()->put('pass_change', [
            'user_id' => $Members->first()->id,
            'token' => $token
        ]);

        /* LOAD VIEW CHANGE PASSWORD */

        $data = array(
            'title' => 'Change Password | IAGD Members Lounge',
        );
        return view('pages/users/user-change-password', ["data" => $data]);

    }
}

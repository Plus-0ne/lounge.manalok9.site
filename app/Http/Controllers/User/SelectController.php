<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Users\MembersModel;
use App\Models\Users\IagdMembers;
use App\Models\Users\EmailVerification;
use App\Models\Users\PostFeed;
use App\Models\Users\PostComments;
use App\Models\Users\PostReaction;
use App\Models\Users\MembersFollowers;

use App\Models\Users\Trade;
use App\Models\Users\TradeLog;

use App\Models\Users\ResetPassword;

use App\Models\Users\UserFollow;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;
use Illuminate\Support\Facades\DB;

use Hash;

/* Custom helper */


class SelectController extends Controller
{

    /* EMAIL FUNCTION */
    public function Send_verification_link($email_data)
    {
        extract($email_data);

        $name = $name;
        $receiver = $receiver;

        /* IF LOCAL USE */
        // $verification_link = 'http://'.$_SERVER['SERVER_NAME'].':8000/create_password_foruser?in='.$iagd_number.'&tk='.$token;
        /* IF IN HOSTING */
        $verification_link = route('user.create_password_foruser').'?in=' . $iagd_number . '&tk=' . $token;

        $logo_url = "http://development-iagd.metaanimals.tech/Source/META_LOGO.svg";
        $data = array(
            'name' => $name,
            'receiver' => $receiver,
            'iagd_number' => $iagd_number,
            'logo_url' => $logo_url,
            'verification_link' => $verification_link,

        );
        $send_email = Mail::send('pages/users/template/emails/mail-verify-iagd', $data, function ($message) use ($name, $receiver) {
            $message->to($receiver, $name)
                ->subject('IAGD No. verification');
            $message->from('project-test@development-iagd.metaanimals.tech', 'verification@iagd.metaanimals.tech');
        });
    }

    /* NOTIFICATION FUNCTION */
    public function memberNotification($notifyData)
    {
        extract($notifyData);


        $uuid = $uuid;
        $from_uuid = $from_uuid;
        $message = $message;

        /* GET NOTIFY FROM USER */
        $from_user = MembersModel::where('uuid', $from_uuid)->first();

        /* GET NOTIFY TO USER */
        $id = MembersModel::where('uuid', $uuid)->first()->id;
        $find_notifiable_user = MembersModel::find($id);
        $data = [
            'user_data' => $find_notifiable_user->first(),
            'from_user' => $from_user,
            'message' => $message
        ];
        Notification::send($find_notifiable_user, new MyPostNotification($data));
    }


    public function check_iagd_number(Request $request)
    {
        /* CHECK FORM INPUT */
        if (!$request->has('iagd_number')) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(), [
            'iagd_number' => 'required'
        ], [
            'iagd_number.required' => 'IAGD No. is required'
        ]);

        /* THROW ERROR IF VALIDATION FAILS */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* CHECK IAGD NUMBER */
        $iagd_number = $request->input('iagd_number');
        $CheckIagdDetails = IagdMembers::where('iagd_number', $iagd_number);
        if ($CheckIagdDetails->count() > 0) {

            /* CHECK IF MEMBER HAS EMAIL IN TABLE IAGDMEMBERS */
            if (empty($CheckIagdDetails->first()->emails)) {
                return redirect()->back()->with('response', 'no_email_found');
            }


            /* PAGE SEND VERIFICATION LINK */
            $CheckVerification = EmailVerification::where('iagd_number', $iagd_number);
            if ($CheckVerification->count() > 0) {
                /* UPDATE */

                if ($CheckVerification->first()->verified == 1) {
                    return redirect()->route('user.login')->with('response', 'already_have_account');
                }

                $token = Str::random(32);
                $time_ms = time();

                $id = $CheckVerification->first()->id;

                $update_verification = EmailVerification::find($id);

                $update_verification->token = $token;
                $update_verification->expiration = $time_ms;

                if ($update_verification->save()) {
                    $email_data = array(
                        'name' => $CheckIagdDetails->first()->name,
                        'receiver' => $CheckIagdDetails->first()->emails,
                        'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                        'token' => $token,
                    );
                    $this->Send_verification_link($email_data);

                    $sess_data = array(
                        'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                        'email_address' => $CheckIagdDetails->first()->emails,
                        'token' => $token,
                    );
                    $request->session()->put('iagd_checking', $sess_data);

                    return redirect()->route('user.verify_iagd_number_email')->with('response', 'email_sent');
                } else {
                    return redirect()->back()->with('response', 'error_saving_verification');
                }
            } else {
                $token = Str::random(32);
                $time_ms = time();

                $save_verification = EmailVerification::create([
                    'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                    'email_address' => $CheckIagdDetails->first()->emails,
                    'token' => $token,
                    'expiration' => $time_ms,
                ]);
                if ($save_verification->save()) {
                    $email_data = array(
                        'name' => $CheckIagdDetails->first()->name,
                        'receiver' => $CheckIagdDetails->first()->emails,
                        'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                        'token' => $token,
                    );
                    $this->Send_verification_link($email_data);

                    $sess_data = array(
                        'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                        'email_address' => $CheckIagdDetails->first()->emails,
                        'token' => $token,
                    );
                    $request->session()->put('iagd_checking', $sess_data);

                    return redirect()->route('user.verify_iagd_number_email')->with('response', 'email_sent');
                } else {
                    return redirect()->back()->with('response', 'error_saving_verification');
                }
            }
        } else {
            /* THROW ERROR IF NOT FOUND */
            return redirect()->back()->with('response', 'iagd_not_found');
        }
    }
    public function resend_email(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        /* VALIDATE SESSION */
        if (!$request->session()->has('iagd_checking')) {
            return redirect()->route('user.user_registered_members');
        }

        /* FIND EMAIL VERIFICATION DATA GET ID */
        $iagd_number = $request->session()->get('iagd_checking.iagd_number');
        $token = $request->session()->get('iagd_checking.token');

        $CheckVerification = EmailVerification::where('iagd_number', $iagd_number)->where('token', $token);

        if ($CheckVerification->count() > 0) {
            if ((time() - $CheckVerification->first()->expiration) < 600) {
                return redirect()->back()->with('response', 'resend_after_60');
            }

            if ($CheckVerification->first()->verified == 1) {
                return redirect()->route('user.login');
            }

            /* UPDATE */
            $token = Str::random(32);
            $time_ms = time();

            $CheckIagdDetails = IagdMembers::where('iagd_number', $iagd_number);

            $id = $CheckVerification->first()->id;

            $update_verification = EmailVerification::find($id);

            $update_verification->token = $token;
            $update_verification->expiration = $time_ms;

            if ($update_verification->save()) {
                $email_data = array(
                    'name' => $CheckIagdDetails->first()->name,
                    'receiver' => $CheckIagdDetails->first()->emails,
                    'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                    'token' => $token,
                );
                $this->Send_verification_link($email_data);

                $sess_data = array(
                    'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                    'email_address' => $CheckIagdDetails->first()->emails,
                    'token' => $token,
                );
                $request->session()->put('iagd_checking', $sess_data);

                return redirect()->route('user.verify_iagd_number_email')->with('response', 'email_sent');
            } else {
                return redirect()->back()->with('response', 'error_saving_verification');
            }
        } else {
            return redirect()->route('user.user_registered_members');
        }
    }

    public function ajax_allpost(Request $request)
    {

        if ($request->ajax()) {
            $PostFeed = tap(PostFeed::with(['MembersModel' => function ($mm) {
                $mm->select('id','uuid','iagd_number','email_address','profile_image','first_name','last_name');
            }])
            ->with('MembersModel.myFollowers')
            ->with(['MembersModel.myFollowers' => function ($mmf) {
                $mmf->where('status','=',1);

            }])

            ->with(['PostReaction' => function ($pr) {
                $pr->orderBy('created_at', 'DESC');

            }])
            ->withCount(['PostReaction as prLike' => function ($q) {
                $q->where('reaction','=',1);
            }])
            ->withCount(['PostReaction as prHaha' => function ($q) {
                $q->where('reaction','=',2);
            }])
            ->withCount(['PostReaction as prHeart' => function ($q) {
                $q->where('reaction','=',3);
            }])
            ->withCount('CommentPerPost')
            ->with('PostAttachments')->skip(0)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10))
            ->map(function ($posts) {
                $posts->setRelation('CommentPerPost', $posts->CommentPerPost->skip(0)->take(1));
                $posts->setRelation('postLastComment', $posts->postLastComment->skip(0)->take(1));
                return $posts;
            })
            ;

            // $post_content = view('pages/users/template/section/post-area',['data'=>$PostFeed])->render();
            return response()->json(['data' => $PostFeed,]);
        }
    }
    public function CheckUserLiked(Request $request)
    {
        if ($request->ajax()) {
            $uuid = Auth::guard('web')->user()->uuid;
            $post_id = $request->input('post_id');

            $CheckMemberIfLikePost = DB::table('post_reaction')
                ->where([
                    ['uuid', '=', $uuid],
                    ['post_id', '=', $post_id],
                    ['reaction', '=', 1],
                ])
                ->get();

            $PostAllReaction = DB::table('post_reaction')
                ->where([
                    ['post_id', '=', $post_id],
                    ['reaction', '=', 1],
                ])
                ->get();

            if ($CheckMemberIfLikePost->count() > 0 and $CheckMemberIfLikePost->first()->reaction == 1) {
                return response()->json([
                    'status' => 'true',
                    'like_count' => $PostAllReaction->count(),
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'like_count' => $PostAllReaction->count(),
                ]);
            }
        }
    }

    public function get_all_comments_thispost(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        if (!$request->has('pid') || empty($request->input('pid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $pid = $request->input('pid');
        $date_starts = $request->input('date_starts');


        $GetAllComments = PostComments::where([
            ['post_id', '=', $pid],
            ['created_at', '>', $date_starts],

        ])
        ->orderBy('created_at', 'DESC')
        ->with('MembersModel');

        if ($GetAllComments->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Successfully fetched all comments',
                'comments' => $GetAllComments->paginate(7)
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'null',
                'message' => 'No comment posted yet',
            ];
            return response()->json($data);
        }
    }

    /* COMMENT UPDATE */
    public function GetLatestComment(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        if (!$request->has('pid') || empty($request->input('pid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $pid = $request->input('pid');
        $date_starts = $request->input('date_starts');

        $GetAllComments = PostComments::where([
            ['post_id', '=', $pid],
            ['created_at', '>', $date_starts],

        ])
        ->orderBy('created_at', 'DESC')
        ->with('MembersModel')
        ->limit(1);

        if ($GetAllComments->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Successfully fetched all comments',
                'comments' => $GetAllComments->get()
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'null',
                'message' => 'No comment posted yet',
            ];
            return response()->json($data);
        }
    }




    /* PET TRADING */
    public function ajax_alltrade(Request $request)
    {

        if ($request->ajax()) {
            // $PostFeed = PostFeed::with('MembersModel:id,iagd_number,email_address')
            //     ->with([
            //         'PostReaction' => function ($pr) {
            //             $pr->limit(5);
            //             $pr->orderBy('created_at', 'DESC');
            //         }
            //     ])
            //     ->withCount([
            //         'PostReaction' => function ($q) {
            //             $q->where('reaction', '=', 1);
            //         }
            //     ])
            //     ->withCount('PostComments')
            //     ->orderBy('created_at', 'DESC')
            //     ->paginate(3);
            $Trade = Trade::orderBy('created_at', 'DESC')
                ->withCount([
                        'TradeLog' => function ($tl) {
                            $tl->where('log_status', '=', 'pending');
                        }
                    ])
                ->paginate(3);
            return response()->json(['data' => $Trade]);
        }
    }
    /* FORGOT PASSWORD */


    public function resend_password_reset(Request $request)
    {
        if (!$request->session()->has('password_reset_session')) {
            return redirect()->back();
        }
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        $data = array(
            'title' => 'Resend password | IAGD Members Lounge',
        );
        return view('pages/users/user-resend-forgot-password', ["data" => $data]);
    }

    public function resend_mail_passreset(Request $request)
    {
        if (!$request->session()->has('password_reset_session')) {
            return redirect()->back();
        }
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        $email_address = $request->session()->get('password_reset_session.email_address');

        /* RESEND EMAIL PASSWORD RESET */
        $CheckResetPass = ResetPassword::where('email_address',$email_address);
        $time_exp = time();
        if ($CheckResetPass->count() > 0) {
            $crp = $CheckResetPass->first();

            /* CHECK VALIDITY */
            $time_elapse = (time() - $crp->expiration);

            if ($time_elapse > 600) {
                /* RESEND EMAIL PASSWORD RESET */

                do {
                    $email_address = $request->session()->get('password_reset_session.email_address');
                    $token = Str::random(32);
                } while (ResetPassword::where("email_address", "=", $email_address)->where("token", "=", $token)->first() instanceof ResetPassword);


                $UpdateResetPassword = ResetPassword::find($crp->id);

                $UpdateResetPassword->email_address = $email_address;
                $UpdateResetPassword->token = $token;
                $UpdateResetPassword->expiration = $time_exp;
                $UpdateResetPassword->created_at = Carbon::now();
                $UpdateResetPassword->updated_at = Carbon::now();

                $UpdateResetPassword->save();

                $mail_data = [
                    'email_address' => $email_address,
                    'token' => $token,
                ];

                $this->send_email_for_passwordreset($mail_data);


                /* SET SESSION FOR RESEND PASSWORD REQUEST */
                $request->session()->put('password_reset_session', [
                    'email_address' => $email_address,
                ]);


                $data = [
                    'status' => 'email_resent',
                    'message' => 'Email has beed sent',
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 'time_less_than_600_sec',
                    'message' => 'Wait 600 seconds to resend : '.$time_elapse.' seconds',
                ];
                return response()->json($data);
            }

        }
    }
    public function ajax_allrequest(Request $request)
    {
        if ($request->ajax()) {
            if (!$request->has('tradeno')) {
                $data = [
                    'status' => 'error',
                    'message' => 'Somethin\'s wrong! Please try again'
                ];
                return response()->json($data);
            }

            /* CHECK IF TRADE NO IS NOT EMPTY */
            if (empty($request->input('tradeno'))) {
                $data = [
                    'status' => 'error',
                    'message' => 'Somethin\'s wrong! Please try again'
                ];
                return response()->json($data);
            }

            $TradeLog = TradeLog::where('trade_no', $request->input('tradeno'))
                                ->where('log_status', 'pending')
                                ->with('MembersModel:id,iagd_number,profile_image,first_name,last_name')
                                ->get();
            return response()->json(['data' => $TradeLog]);
        }
    }
}

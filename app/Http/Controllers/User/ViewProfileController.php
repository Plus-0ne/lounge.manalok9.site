<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

/* USER MODELS */
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;
use App\Models\Users\PostReaction;
use App\Models\Users\PostComments;
use App\Models\Users\MembersProfileLikes;
use App\Models\Users\UserFollow;

use App\Models\Users\MembersAd;

use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryRabbit;
use App\Models\Users\RegistryBird;
use App\Models\Users\RegistryOtherAnimal;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersRabbit;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersOtherAnimal;

use App\Models\Users\mlConversation;
use App\Models\Users\MembersGallery;


use JavaScript;
use Carbon\Carbon;

/* NOTIFICATION */
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;
use App\Notifications\MessageNotification;

class ViewProfileController extends Controller
{

    ############### PAGE REQUEST

    public function view_members(Request $request)
    {

        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = array(
                'title' => 'Member not found | IAGD Members Lounge',
                'mem-data' => null,
                'analytics' => CustomHelper::analytics()
            );
            return view('pages/users/user-view-profile', ['data' => $data]);
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
        ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user-view-profile', ['data' => $data]);
    }

    public function view_comments(Request $request)
    {

        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = array(
                'title' => 'Member not found | IAGD Members Lounge',
                'mem-data' => null,
                'analytics' => CustomHelper::analytics()
            );
            return view('pages/users/user-view-comments', ['data' => $data]);
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
        ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user-view-comments', ['data' => $data]);
    }

    public function view_reacts(Request $request)
    {

        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = array(
                'title' => 'Member not found | IAGD Members Lounge',
                'mem-data' => null,
            );
            return view('pages/users/user-view-reacts', ['data' => $data]);
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
        ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user-view-reacts', ['data' => $data]);
    }

    public function view_members_advertisements(Request $request)
    {

        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = array(
                'title' => 'Member not found | IAGD Members Lounge',
                'mem-data' => null,
                'analytics' => CustomHelper::analytics()
            );
            return view('pages/users/user-view-profile', ['data' => $data]);
        }

        if ($request->input('rid') == Auth::guard('web')->user()->uuid) {
            return redirect()->route('user.user_profile');
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
        ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user-view-advertisement', ['data' => $data]);
    }

    public function view_members_pets(Request $request)
    {
        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            // $data = array(
            //     'title' => 'Member not found | IAGD Members Lounge',
            //     'mem-data' => null,
            // );
            // return view('pages/users/user_view_pets', ['data' => $data]);
            return back();
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
            'baseUrl' => url('/'),
        ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user_view_pets', ['data' => $data]);
    }
    ############### END


    ############### FUNCTIONS

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
        Notification::send($find_notifiable_user, new MessageNotification($data));
    }

    ############### END


    ############### AJAX REQUEST

    public function view_members_profile(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'invalid_request',
                'message' => 'Invalid request',
            ];
            return response()->json($data);
        }
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $uuid = $request->input('rid');

        $members = MembersModel::where('uuid',$uuid);

        if ($members->count() > 0) {
            $data = [
                'status' => 'member_found',
                'message' => 'Member found',
                'redirectTo' => route('user.view_members').'?rid='.$uuid,
            ];
            return response()->json($data);

        }
        else
        {
            $data = [
                'status' => 'not_found',
                'message' => 'Member not found',
            ];
            return response()->json($data);
        }

    }

    public function getMemberDetails(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'invalid_request',
                'message' => 'Invalid request',
            ];
            return response()->json($data);
        }
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $uuid = $request->input('rid');

        $members_post = PostFeed::where('uuid',$uuid)
        ->with(['MembersModel' =>  function ($mm) {
            $mm->select('id','uuid','iagd_number');
        }])
        ->withCount('PostReaction')
        ->withCount('PostComments');


        if ($members_post->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Member details found',
                'mem_post' => $members_post->paginate(5),
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 'error',
                'message' => 'Member details not found',
            ];
            return response()->json($data);
        }

    }

    // public function getMemberAdvertisements(Request $request)
    // {
    //     if (!$request->ajax()) {
    //         $data = [
    //             'status' => 'invalid_request',
    //             'message' => 'Invalid request',
    //         ];
    //         return response()->json($data);
    //     }
    //     if (!$request->has('rid') || empty($request->input('rid'))) {
    //         $data = [
    //             'status' => 'key_error',
    //             'message' => 'Something\'s wrong! Please try again',
    //         ];
    //         return response()->json($data);
    //     }

    //     $uuid = $request->input('rid');

    //     $members_ads = MembersAd::where('member_uuid', $request->input('rid'));


    //     if ($members_ads->count() > 0) {
    //         $data = [
    //             'status' => 'success',
    //             'message' => 'Member ads found',
    //             'mem_ad' => $members_ads->paginate(5),
    //         ];
    //         return response()->json($data);
    //     }
    //     else
    //     {
    //         $data = [
    //             'status' => 'error',
    //             'message' => 'Member ads not found',
    //         ];
    //         return response()->json($data);
    //     }

    // }
    ############### GET ALL AD

    public function getMemberAdvertisements(Request $request)
    {
        if (!$request->ajax() || empty($request->input('rid')) || !$request->has('rid')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        $page = (!empty($request->input('pg')) ? $request->input('pg') : 1);

        /* GET ALL POST */
        $members_ads = MembersAd::where('member_uuid', $request->input('rid'))
            ->orderBy('created_at','DESC')
            ->with('MembersModel')
            ->paginate(5, ['*'], 'page', $page);

        if ($members_ads->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Member ads found',
                'mem_ad' => $members_ads,
            ];
            return response()->json($data);
        }

    }
    ############### END

    public function countProfileLikes(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'invalid_request',
                'message' => 'Invalid request',
            ];
            return response()->json($data);
        }
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $uuid = $request->input('rid');

        $MembersLikes = MembersProfileLikes::where('uuid',$uuid);

        if ($MembersLikes->count() > 0) {
            $data = [
                'status' => 'has_likes',
                'message' => 'Profile likes counted',
                'prof_count' => $MembersLikes->count(),
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 'no_likes',
                'message' => 'Noone like your profile HAHAHAHAH',
                'prof_count' => 0,
            ];
            return response()->json($data);
        }


    }
    public function countProfileFollowers(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'invalid_request',
                'message' => 'Invalid request',
            ];
            return response()->json($data);
        }
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = [
                'status' => 'key_error',
                'message' => 'Something\'s wrong! Please try again',
            ];
            return response()->json($data);
        }

        $uuid = $request->input('rid');

        $UserFollow = UserFollow::where('uuid',$uuid);

        if ($UserFollow->count() > 0) {
            $data = [
                'status' => 'has_follower',
                'message' => 'Profile likes counted',
                'prof_count' => $UserFollow->count(),
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 'no_follower',
                'message' => 'No follower HAHAHAHAH',
                'prof_count' => 0,
            ];
            return response()->json($data);
        }
    }
    ############### END


    ############### GET ALL POST

    public function get_all_post(Request $request)
    {
        $userFollowStatus = [];

        if (!$request->ajax() || empty($request->input('user_uuid')) || !$request->has('user_uuid')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Set current visitor uuid and user visited uuid */
        $my_uuid = Auth::guard('web')->user()->uuid;
        $user_uuid = $request->input('user_uuid');

        /* Check if visitor is a follower */
        $UserFollower = UserFollow::where([
            ['follow_uuid','=',$user_uuid],
            ['uuid','=',$my_uuid],
            ['status','=',1],
        ]);
        if ($UserFollower->count() > 0) {
            /* User is a follower get all post public and private */
            $userFollowStatus = ['private','public'];
        }
        else
        {
            /* Not a follower get all public post */
            $userFollowStatus = ['public'];
        }

        /* If user view his profile */
        if ($my_uuid == $user_uuid) {
            /* Visitor is the current logged in user get all public and private post */
            $userFollowStatus = ['private','public'];
        }


        /* TODO : Get all post where uuid = visited uuid */

        $UserPost = PostFeed::where('uuid',$user_uuid)
        ->whereIn('visibility',$userFollowStatus)
        ->with(['MembersModel' => function ($mm) {
            $mm->select('id','uuid','iagd_number','email_address','profile_image','first_name','last_name');
        }])
        ->with('MembersModel.myFollowers')
        ->with(['MembersModel.myFollowers' => function ($mmf) {
            $mmf->where('status','=',1);

        }])
        ->with(['PostReaction' => function ($pr) use($my_uuid) {
            $pr->where([
                ['uuid', $my_uuid],
                ['reaction','>',0]
            ]);
        }])
        ->withCount(['PostReaction as total_reaction' => function ($q) {
            $q->where('reaction','>',0);
        }])
        ->withCount([
            'PostReaction as total_r1' => function ($q) {
                $q->where('reaction', 1);
            }
        ])
        ->withCount([
            'PostReaction as total_r2' => function ($q) {
                $q->where('reaction', 2);
            }
        ])
        ->withCount([
            'PostReaction as total_r3' => function ($q) {
                $q->where('reaction', 3);
            }
        ])
        ->withCount('CommentPerPost')
        ->with('PostAttachments')->skip(0)
        ->with('sharedSource')
        ->with('sourceAttachments')
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);

        return response()->json($UserPost);

    }
    ############### END


    ############### GET ALL COMMENT

    public function get_all_comment(Request $request)
    {
        $userFollowStatus = [];

        if (!$request->ajax() || empty($request->input('user_uuid')) || !$request->has('user_uuid')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Set current visitor uuid and user visited uuid */
        $my_uuid = Auth::guard('web')->user()->uuid;
        $user_uuid = $request->input('user_uuid');

        /* Check if visitor is a follower */
        $UserFollower = UserFollow::where([
            ['follow_uuid','=',$user_uuid],
            ['uuid','=',$my_uuid],
            ['status','=',1],
        ]);
        if ($UserFollower->count() > 0) {
            /* User is a follower get all post public and private */
            $userFollowStatus = ['private','public'];
        }
        else
        {
            /* Not a follower get all public post */
            $userFollowStatus = ['public'];
        }

        /* If user view his profile */
        if ($my_uuid == $user_uuid) {
            /* Visitor is the current logged in user get all public and private post */
            $userFollowStatus = ['private','public'];
        }


        /* TODO : Get all post where uuid = visited uuid */
        $UserComment = PostComments::where('uuid', $user_uuid)
        ->whereHas('PostFeed', function($q) use ($userFollowStatus) {
            $q->whereIn('visibility',$userFollowStatus);
        })
        ->with(['PostFeed' => function ($pf) {
            $pf->select('post_id');
        }])
        ->with('PostFeed.MembersModel')
        ->with('MembersModel')
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);
        // $UserPost = PostFeed::where('uuid',$user_uuid)
        // ->whereIn('visibility',$userFollowStatus)
        // ->with(['MembersModel' => function ($mm) {
        //     $mm->select('id','uuid','iagd_number','email_address','profile_image','first_name','last_name');
        // }])

        // ->with('MembersModel.myFollowers')
        // ->with(['MembersModel.myFollowers' => function ($mmf) {
        //     $mmf->where('status','=',1);

        // }])
        // ->with(['PostReaction' => function ($pr) use($my_uuid) {
        //     $pr->where([
        //         ['uuid', $my_uuid],
        //         ['reaction','>',0]
        //     ]);
        // }])
        // ->withCount(['PostReaction as total_reaction' => function ($q) {
        //     $q->where('reaction','>',0);
        // }])
        // ->withCount([
        //     'PostReaction as total_r1' => function ($q) {
        //         $q->where('reaction', 1);
        //     }
        // ])
        // ->withCount([
        //     'PostReaction as total_r2' => function ($q) {
        //         $q->where('reaction', 2);
        //     }
        // ])
        // ->withCount([
        //     'PostReaction as total_r3' => function ($q) {
        //         $q->where('reaction', 3);
        //     }
        // ])
        // ->withCount('CommentPerPost')
        // ->with('PostAttachments')->skip(0)
        // ;

        return response()->json($UserComment);

    }
    ############### END


    ############### GET ALL REACTION

    public function get_all_react(Request $request)
    {
        $userFollowStatus = [];

        if (!$request->ajax() || empty($request->input('user_uuid')) || !$request->has('user_uuid')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Set current visitor uuid and user visited uuid */
        $my_uuid = Auth::guard('web')->user()->uuid;
        $user_uuid = $request->input('user_uuid');

        /* Check if visitor is a follower */
        $UserFollower = UserFollow::where([
            ['follow_uuid','=',$user_uuid],
            ['uuid','=',$my_uuid],
            ['status','=',1],
        ]);
        if ($UserFollower->count() > 0) {
            /* User is a follower get all post public and private */
            $userFollowStatus = ['private','public'];
        }
        else
        {
            /* Not a follower get all public post */
            $userFollowStatus = ['public'];
        }

        /* If user view his profile */
        if ($my_uuid == $user_uuid) {
            /* Visitor is the current logged in user get all public and private post */
            $userFollowStatus = ['private','public'];
        }


        /* TODO : Get all post where uuid = visited uuid */
        $UserReact = PostReaction::where('uuid', $user_uuid)
        ->where('reaction', '>', 0)
        ->whereHas('PostFeed', function($q) use ($userFollowStatus) {
            $q->whereIn('visibility',$userFollowStatus);
        })
        ->with(['PostFeed' => function ($pf) {
            $pf->select('post_id');
        }])
        ->with('PostFeed.MembersModel')
        ->with('MembersModel')
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);
        // $UserPost = PostFeed::where('uuid',$user_uuid)
        // ->whereIn('visibility',$userFollowStatus)
        // ->with(['MembersModel' => function ($mm) {
        //     $mm->select('id','uuid','iagd_number','email_address','profile_image','first_name','last_name');
        // }])

        // ->with('MembersModel.myFollowers')
        // ->with(['MembersModel.myFollowers' => function ($mmf) {
        //     $mmf->where('status','=',1);

        // }])
        // ->with(['PostReaction' => function ($pr) use($my_uuid) {
        //     $pr->where([
        //         ['uuid', $my_uuid],
        //         ['reaction','>',0]
        //     ]);
        // }])
        // ->withCount(['PostReaction as total_reaction' => function ($q) {
        //     $q->where('reaction','>',0);
        // }])
        // ->withCount([
        //     'PostReaction as total_r1' => function ($q) {
        //         $q->where('reaction', 1);
        //     }
        // ])
        // ->withCount([
        //     'PostReaction as total_r2' => function ($q) {
        //         $q->where('reaction', 2);
        //     }
        // ])
        // ->withCount([
        //     'PostReaction as total_r3' => function ($q) {
        //         $q->where('reaction', 3);
        //     }
        // ])
        // ->withCount('ReactPerPost')
        // ->with('PostAttachments')->skip(0)
        // ;

        return response()->json($UserReact);

    }
    ############### END




    ############### Message check user

    public function message_user(Request $request)
    {
        if (!$request->ajax() || !$request->has('ruuid') || empty($request->input('ruuid'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        $auth_user = Auth::guard('web')->user()->uuid;
        $specific_user = $request->input('ruuid');

        /* Get specific user data */
        $GetUserData = Membersmodel::where('uuid',$specific_user);

        /* Check if auth user has connection to specific user */
        $CheckConversation = mlConversation::where([
            ['sender_uuid','=',$auth_user],
            ['receiver_uuid','=',$specific_user],
        ])->orWhere([
            ['receiver_uuid','=',$auth_user],
            ['sender_uuid','=',$specific_user],
        ])
        ->with('senderDetails')
        ->with('receiverDetails')
        ->orderBy('created_at','DESC');

        $data = [
            'status' => 'success',
            'message' => 'Message now available',
            'data' => $CheckConversation->get(),
            'userData' => $GetUserData->first()
        ];
        return response()->json($data);
    }

    ############### End

    ############### Send user a message

    public function send_user_message(Request $request)
    {
        if (!$request->ajax() || !$request->has('ruuid') || empty($request->input('ruuid'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }
        if (!$request->ajax() || !$request->has('message_txt') || empty($request->input('message_txt'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Send message from auth user to specific user */

        $sender_uuid = Auth::guard('web')->user()->uuid;
        $receiver_uuid = $request->input('ruuid');
        $message_txt = $request->input('message_txt');

        /* Check if user has connection */

        $CheckUserFollow = UserFollow::where([
            ['uuid','=',$sender_uuid],
            ['follow_uuid','=',$receiver_uuid],
        ])->orWhere([
            ['uuid','=',$receiver_uuid],
            ['follow_uuid','=',$sender_uuid],
        ]);

        /* Connection variables */
        do {
            $room_uuid = Str::uuid();
        } while (UserFollow::where("room_uuid", $room_uuid)->first() instanceof UserFollow);

        $created_at = Carbon::now();
            $updated_at = Carbon::now();

        if ($CheckUserFollow->count() > 0) {
            /* Get Room uuid */
            $room_uuid = $CheckUserFollow->first()->room_uuid;
        }
        else
        {
            /* Create connection */
            UserFollow::insert([
                [
                    'uuid' => $sender_uuid,
                    'follow_uuid' => $receiver_uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
                [
                    'uuid' => $receiver_uuid,
                    'follow_uuid' => $sender_uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
            ]);
        }

        do {
            $conversation_uuid = Str::uuid();
        } while (mlConversation::where("conversation_uuid", $conversation_uuid)->first() instanceof mlConversation);

        $sendMessage = mlConversation::create([
            'room_uuid' => $room_uuid,
            'conversation_uuid' => $conversation_uuid,
            'sender_uuid' => $sender_uuid,
            'receiver_uuid' => $receiver_uuid,
            'message' => $message_txt,
            'type' => 'private',
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($sendMessage->save()) {

            if ($sender_uuid != $receiver_uuid) {
                $msg = 'sent you a message';
                $notifyData = [
                    'uuid' => $receiver_uuid,
                    'from_uuid' => $sender_uuid,
                    'message' => $msg,
                ];
                $this->memberNotification($notifyData);
            }

            $data = [
                'status' => 'success',
                'message' => 'Message sent'
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 'error',
                'message' => 'Message not sent!'
            ];
            return response()->json($data);
        }
    }

    ############### End

    ############### Update message body

    public function update_message(Request $request)
    {
        if (!$request->ajax() || !$request->has('ruuid') || empty($request->input('ruuid'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        if (!$request->ajax() || !$request->has('lastChatdate') || empty($request->input('lastChatdate'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Get all new message */

        $auth_user = Auth::guard('web')->user()->uuid;
        $specific_user = $request->input('ruuid');
        $lastChatdate = $request->input('lastChatdate');

        /* Get specific user data */
        $GetUserData = Membersmodel::where('uuid',$specific_user);

        /* Check if auth user has connection to specific user */
        $CheckConversation = mlConversation::where([
            ['sender_uuid','=',$auth_user],
            ['receiver_uuid','=',$specific_user],
            ['created_at','>',$lastChatdate]
        ])->orWhere([
            ['receiver_uuid','=',$auth_user],
            ['sender_uuid','=',$specific_user],
            ['created_at','>',$lastChatdate]
        ])
        ->with('senderDetails')
        ->with('receiverDetails')
        ->orderBy('created_at','DESC');

        $data = [
            'status' => 'success',
            'message' => 'Message now available',
            'data' => $CheckConversation->get(),
            'userData' => $GetUserData->first(),
        ];
        return response()->json($data);

    }

    ############### End

    /* User profile react */
    public function react_to_post(Request $request)
    {
        /* Variables */
        $post_reaction = null;

        /* Check if ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }


        /* Check if null values in post request */
        $validate = Validator::make($request->all(), [
            'post_id' => 'required',
            'reaction_val' => 'required',
        ], [
            'post_id.required' => 'Something\'s wrong, Please try again!',
            'reaction_val.required' => 'Something\'s wrong, Please try again!'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Re-check post reaction request values */

        switch ($request->input('reaction_val')) {
            case '1':
                $post_reaction = '1';
                break;

            case '2':
                $post_reaction = '2';
                break;

            case '3':
                $post_reaction = '3';
                break;

            default:
                $post_reaction = '1';
                break;
        }

        /* Check if user reacted to post already */

        $PostReaction = PostReaction::where([
            ['post_id','=', $request->input('post_id')],
            ['uuid','=', Auth::guard('web')->user()->uuid]
        ]);



        if ($PostReaction->count() > 0) {

            /* Check what's user reaction to post then update user reaction */
            $id = $PostReaction->first()->id;

            if ($PostReaction->first()->reaction == $post_reaction) {

                /* Update reaction to 0 */
                $upReaction = PostReaction::find($id);

                $upReaction->reaction = 0;
                $upReaction->updated_at = Carbon::now();
                $upReaction->save();

                $post_reaction = 0;
            }
            else
            {
                /* Update reaction to reaction value */
                $upReaction = PostReaction::find($id);

                $upReaction->reaction = $post_reaction;
                $upReaction->updated_at = Carbon::now();
                $upReaction->save();
            }

            /* TODO : Notify post owner for reaction */

            $data = [
                'status' => 'success',
                'message' => 'Reaction updated',
                'postReacted' => $request->input('post_id'),
                'myReaction' => $post_reaction
            ];
            return response()->json($data);
        }
        else
        {

            /* Create new row with user reaction */
            $CreateReaction = PostReaction::create([
                'post_id' => $request->input('post_id'),
                'uuid' => Auth::guard('web')->user()->uuid,
                'reaction' => $post_reaction,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($CreateReaction->save()) {

                /* TODO : Notify post owner for reaction */

                $data = [
                    'status' => 'success',
                    'message' => 'Reaction created',
                    'postReacted' => $request->input('post_id'),
                    'myReaction' => $post_reaction
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 'error',
                    'message' => 'Reaction failed',
                    'postReacted' => $request->input('post_id'),
                    'myReaction' => $post_reaction
                ];
                return response()->json($data);
            }
        }

    }

    public function view_follows(Request $request)
    {

        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('rid');

        $getMemberDetails = MembersModel::where('uuid',$uuid);
        $CheckIfFollowed = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
            ['status','=',1]
        ]);

        $iFollowed = $CheckIfFollowed;
        $gmd = $getMemberDetails->first();


        /* CHECK IF REQUEST IS INVALID OR EMPTY */
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = array(
                'title' => 'Member not found | IAGD Members Lounge',
                'mem-data' => null,
                'analytics' => CustomHelper::analytics()
            );
            return view('pages/users/user_view_follows', ['data' => $data]);
        }

        Javascript::put([
            'my_id' => Auth::guard('web')->user()->id,
            'my_uuid' => Auth::guard('web')->user()->uuid,
            'rid' => $uuid,
            'assetUrl' => asset('/'),
        ]);

        /* Get all followers or following data */
        // $following = UserFollow::where([
        //     ['follow_uuid','=',$uuid],
        //     ['status','=',1]
        // ]);

        $data = array(
            'title' => $gmd->first_name.' '.$gmd->last_name.' | IAGD Members Lounge',
            'rid' => $uuid,
            'gmd' => $gmd,
            'iFollowed' => $iFollowed,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user_view_follows', ['data' => $data]);
    }

    /* Function get all user follower */
    public function get_user_follower(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

        /* Check if null values in post request */
        $validate = Validator::make($request->all(), [
            'rid' => 'required',
        ], [
            'rid.required' => 'Something\'s wrong, Please try again!',
        ]);

        $user_uuid = $request->input('rid');
        $user_visitor = Auth::guard('web')->user()->uuid;

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get user follower */
        $followers = UserFollow::where([
            ['follow_uuid','=',$user_uuid],
            ['status','=',1]
        ]);

        /* Create json response */

        if ($followers->count() < 1) {
            $data = [
                'status' => 'success',
                'message' => 'No follower found!'
            ];
            return response()->json($data);
        }
        else
        {
            switch ($request->input('titleSearch')) {
                case 'Followers':
                    $userFollower = UserFollow::where([
                        ['follow_uuid','=',$user_uuid],
                        ['status','=',1]
                    ])->with('MembersModel')->paginate(6);
                    break;

                case 'Following':
                    $userFollower = UserFollow::where([
                        ['uuid','=',$user_uuid],
                        ['status','=',1]
                    ])->with('FollowDetails')->paginate(6);
                    break;

                default:
                    $userFollower = UserFollow::where([
                        ['follow_uuid','=',$user_uuid],
                        ['status','=',1]
                    ])->with('MembersModel')->paginate(6);
                    break;
            }


            if ($request->input('searchString') != null) {

                switch ($request->input('titleSearch')) {
                    case 'Followers':
                        $userFollower = UserFollow::where([
                            ['follow_uuid','=',$user_uuid],
                            ['status','=',1]
                        ])
                        ->whereHas('MembersModel',function ($s) use ($request) {
                            $s->where('first_name','like', '%' . $request->input('searchString') . '%')
                            ->orWhere('last_name','like', '%' . $request->input('searchString') . '%');
                        })
                        ->with('MembersModel')
                        ->paginate(6);
                        break;

                    case 'Following':
                        $userFollower = UserFollow::where([
                            ['uuid','=',$user_uuid],
                            ['status','=',1]
                        ])
                        ->whereHas('FollowDetails',function ($s) use ($request) {
                            $s->where('first_name','like', '%' . $request->input('searchString') . '%')
                            ->orWhere('last_name','like', '%' . $request->input('searchString') . '%');
                        })
                        ->with('FollowDetails')
                        ->paginate(6);
                        break;

                    default:
                        $userFollower = UserFollow::where([
                            ['follow_uuid','=',$user_uuid],
                            ['status','=',1]
                        ])
                        ->whereHas('MembersModel',function ($s) use ($request) {
                            $s->where('first_name','like', '%' . $request->input('searchString') . '%')
                            ->orWhere('last_name','like', '%' . $request->input('searchString') . '%');
                        })
                        ->with('MembersModel')
                        ->paginate(6);
                        break;
                }

            }

            $data = [
                'status' => 'success',
                'message' => 'Follower found!',
                'userFollower' => $userFollower
            ];
            return response()->json($data);
        }

    }


    /* Function get all user pet */
    public function get_user_pets(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

        /* Check if null values in post request */
        $validate = Validator::make($request->all(), [
            'rid' => 'required',
        ], [
            'rid.required' => 'Something\'s wrong, Please try again!',
        ]);

        $user_uuid = $request->input('rid');
        $user_visitor = Auth::guard('web')->user()->uuid;
        $page = $request->input('page');

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $getMemberDetails = MembersModel::where('uuid', $user_uuid);
        $gmd = $getMemberDetails->first();

        $dogs_reg = RegistryDog::select('PetUUID','PetName','PetNo','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->orWhere('OwnerIAGDNo', ($gmd->iagd_number ?? 'NONE'))
            ->with('AdtlInfo.FilePhoto')
            ->orderBy('DateAdded', 'desc')->get();
        $cats_reg = RegistryCat::select('PetUUID','PetName','PetNo','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->orWhere('OwnerIAGDNo', ($gmd->iagd_number ?? 'NONE'))
            ->with('AdtlInfo.FilePhoto')
            ->orderBy('DateAdded', 'desc')->get();
        $rabbits_reg = RegistryRabbit::select('PetUUID','PetName','PetNo','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->orWhere('OwnerIAGDNo', ($gmd->iagd_number ?? 'NONE'))
            ->with('AdtlInfo.FilePhoto')
            ->orderBy('DateAdded', 'desc')->get();
        $birds_reg = RegistryBird::select('PetUUID','PetName','PetNo','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->orWhere('OwnerIAGDNo', ($gmd->iagd_number ?? 'NONE'))
            ->with('AdtlInfo.FilePhoto')
            ->orderBy('DateAdded', 'desc')->get();
        $otheranimals_reg = RegistryOtherAnimal::select('PetUUID','PetName','PetNo')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->orWhere('OwnerIAGDNo', ($gmd->iagd_number ?? 'NONE'))
            ->with('AdtlInfo.FilePhoto')
            ->orderBy('DateAdded', 'desc')->get();

        $dogs_mem = MembersDog::whereNotIn('PetUUID', Arr::flatten(RegistryDog::whereNotNull('PetUUID')->get('PetUUID')->toArray()))
            ->select('PetUUID','PetName','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->with('AdtlInfo.FilePhoto')
            ->where('Status', '<>', 0)
            ->orderBy('DateAdded', 'desc')->get();
        $cats_mem = MembersCat::whereNotIn('PetUUID', Arr::flatten(RegistryCat::whereNotNull('PetUUID')->get('PetUUID')->toArray()))
            ->select('PetUUID','PetName','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->with('AdtlInfo.FilePhoto')
            ->where('Status', '<>', 0)
            ->orderBy('DateAdded', 'desc')->get();
        $rabbits_mem = MembersRabbit::whereNotIn('PetUUID', Arr::flatten(RegistryRabbit::whereNotNull('PetUUID')->get('PetUUID')->toArray()))
            ->select('PetUUID','PetName','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->with('AdtlInfo.FilePhoto')
            ->where('Status', '<>', 0)
            ->orderBy('DateAdded', 'desc')->get();
        $birds_mem = MembersBird::whereNotIn('PetUUID', Arr::flatten(RegistryBird::whereNotNull('PetUUID')->get('PetUUID')->toArray()))
            ->select('PetUUID','PetName','Gender','BirthDate')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->with('AdtlInfo.FilePhoto')
            ->where('Status', '<>', 0)
            ->orderBy('DateAdded', 'desc')->get();
        $otheranimals_mem = MembersOtherAnimal::whereNotIn('PetUUID', Arr::flatten(RegistryOtherAnimal::whereNotNull('PetUUID')->get('PetUUID')->toArray()))
            ->select('PetUUID','PetName')
            ->where('Visibility', 1)
            ->where('OwnerUUID', $user_uuid)
            ->with('AdtlInfo.FilePhoto')
            ->where('Status', '<>', 0)
            ->orderBy('DateAdded', 'desc')->get();

        // insert pet_type column to result
        $pets = [
            'dog_mem' => $dogs_mem,
            'cat_mem' => $cats_mem,
            'rabbit_mem' => $rabbits_mem,
            'bird_mem' => $birds_mem,
            'otheranimal_mem' => $otheranimals_mem,
            'dog_reg' => $dogs_reg,
            'cat_reg' => $cats_reg,
            'rabbit_reg' => $rabbits_reg,
            'bird_reg' => $birds_reg,
            'otheranimal_reg' => $otheranimals_reg,
        ];
        $pets_all = [];
        foreach ($pets as $key => $arr) {
            foreach ($arr as $row) {
                $row->pet_type = $key;
                $pets_all[] = $row;
            }
        }

        $member_pets = collect($pets_all)->sortBy('DateAdded'); // ->splice(($page - 1), 30)

        /* Create json response */

        if (count($member_pets) < 1) {
            $data = [
                'status' => 'success',
                'message' => 'No pet found!'
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 'success',
                'message' => 'Pets found!',
                'userPet' => $member_pets
            ];
            return response()->json($data);
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                          User profile card message                         */
    /* -------------------------------------------------------------------------- */
    public function message_user_card(Request $request) {
        /* TODO : Fix null values in js convo.data[0].room_uuid */

        /* Validate get request */
        $validate = Validator::make($request->all(),[
            'uu' => 'required'
        ],[
            'uu.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /* If validation fails */
        if ($validate->fails()) {
            return redirect()->back();
        }

        if ($request->input('uu') == auth::guard('web')->user()->uuid) {
            return redirect()->back();
        }
        /* Check if follower if not create connection */
        $followDetails = UserFollow::where([
            ['uuid','=',Auth::guard('web')->user()->uuid],
            ['follow_uuid','=',$request->input('uu')]
        ]);

        if ($followDetails->count() > 0) {

            /* Get user room uuid */
            $room_uuid = $followDetails->first()->room_uuid;
        } else {

            /* Create room uuid */
            do {
                $room_uuid = Str::uuid();
            } while (UserFollow::where("room_uuid", $room_uuid)->first() instanceof UserFollow);

            /* Set timestamp */
            $created_at = Carbon::now();
            $updated_at = Carbon::now();

            /* Create connection */
            UserFollow::insert([
                [
                    'uuid' => $request->input('uu'),
                    'follow_uuid' => Auth::guard('web')->user()->uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
                [
                    'uuid' => Auth::guard('web')->user()->uuid,
                    'follow_uuid' => $request->input('uu'),
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
            ]);
        }
        $link = route('user.messenger').'?ru='.$room_uuid;

        return redirect()->to($link);
    }
}

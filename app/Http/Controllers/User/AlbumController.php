<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Helper */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/* Load models */
use App\Models\Users\MembersModel;
use App\Models\Users\UserFollow;
use App\Models\Users\PostAttachments;
use App\Models\Users\PostFeed;

use JavaScript;
use Carbon\Carbon;

/* Notifications */
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;
use App\Notifications\MessageNotification;

class AlbumController extends Controller
{
    /* View user gallery */
    public function view_user_album(Request $request)
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
            return view('pages/users/user_view_album', ['data' => $data]);
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
        );
        return view('pages/users/user_view_album', ['data' => $data]);
    }

    /* Ajax get all photos */
    public function get_all_attachment(Request $request)
    {
        /* Check request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }

        /* Set validation */
        $validate = Validator::make($request->all(),[
            'user_uuid' => 'required'
        ],[
            'user_uuid.required' => 'Something\'s wrong! Please try again.'
        ]);

        /* If validation failed */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* TODO : Filter album public or private */
        /* Issue : Redundant images and row data */


        $data = DB::table('post_feed as p')
        ->join('post_attachments as pas',function ($pasJoin) {
            $pasJoin->select(DB::raw('COUNT(pas.id) as TotalAttachment'))->on('pas.post_uuid','=','p.post_id');
        })
        ->select('*',DB::raw('YEAR(p.created_at) as year'))
        ->where([
            ['uuid','=',$request->input('user_uuid')],
            ['type','=','post_attachments']
        ])

        ->get()
        ->groupBy('year')
        ->map(function($posts) {
            return $posts->take(8);
        });
        return response()->json($data);
    }
}

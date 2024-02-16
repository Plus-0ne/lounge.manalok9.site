<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Models */
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;
use App\Models\Users\PostAttachments;
use App\Models\Users\PostReaction;
use App\Models\Users\UserFollow;

/* Helpers */
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Auth;
use Carbon\Carbon;

class ViewPostController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                               View full post                               */
    /* -------------------------------------------------------------------------- */
    public function view_this_posts(Request $request)
    {
        /* Check if request is null */
        $validate = Validator::make($request->all(),[
            'post_id' => 'required'
        ],[
            'post_id.required' => 'Post not found'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return redirect()->back()->with($data);
        }


        /* Get post data , post author , if attachment exist get all attachments*/
        $postData = PostFeed::where('post_id',$request->input('post_id'));
        $postAuthor = MembersModel::where('uuid',$postData->first()->uuid);
        $postsAttachments = PostAttachments::where('post_uuid',$request->input('post_id'));
        $postReaction = PostReaction::where([
            ['post_id','=',$postData->first()->post_id],
            ['uuid','=',Auth::guard('web')->user()->uuid]
        ]);
        /* User followed */
        $userFollowed = UserFollow::where([
            ['uuid','=',Auth::guard('web')->user()->uuid],
            ['follow_uuid','=',$postAuthor->first()->uuid],
            ['status','=','1']
        ]);
        /* User follower */
        $userFollower = UserFollow::where([
            ['follow_uuid','=',Auth::guard('web')->user()->uuid],
            ['uuid','=',$postAuthor->first()->uuid],
            ['status','=','1']
        ]);

        /* Get share source if post is shared */
        $share_source = null;
        $shared_post_created_date = Carbon::now();
        if (!empty($postData->first()->share_source)) {
            $share_source = $postData->with(['sharedSource' => function($e) {
                $e->with('MembersModel');
            }])
            ->with('sourceAttachments');

            $shared_post_created_date = $share_source->first()->sharedSource()->first()->MembersModel()->first()->created_at;
        }


        /* Check if post doesn't exist */
        if ($postData->count() < 1) {
            $data = [
                'title' => 'error',
                'message' => 'Post doesn\'t exist'
            ];
            return redirect()->back()->with($data);
        }

        /* Check if post doesn't exist */
        if ($postData->count() < 1) {
            $data = [
                'title' => 'error',
                'message' => 'Post doesn\'t exist'
            ];
            return redirect()->back()->with($data);
        }

        JavaScript::put([ // get trade_log details
            'post_id' => $request->input('post_id'),
            'assetUrl' => asset('/'),
            'shared_post_created_date' => $shared_post_created_date
        ]);

        /* Check if post is private */
        if ($postData->first()->visibility == 'private') {
            if ($userFollowed->count() < 1) {
                $data = [
                    'title' => 'error',
                    'message' => 'Follow user to view this post'
                ];
                return redirect()->back()->with($data);
            }
        }


        /* Create title */
        $lname = ($postAuthor->first()->last_name == null) ? ' ': $postAuthor->first()->last_name;
        $fname = ($postAuthor->first()->first_name == null) ? ' ':$postAuthor->first()->first_name;
        $title = $lname. ' '.$fname.' published post.';
        $data = [
            'title' => $title,
            'postData' => $postData,
            'postAuthor' => $postAuthor,
            'postAttachments' => $postsAttachments,
            'postReaction' => $postReaction,
            'userFollowed' => $userFollowed,
            'userFollower' => $userFollower,
            'shareContent' => $share_source
        ];
        return view('pages/users/user_dashboard_post_view', ['data'=>$data]);
    }
}

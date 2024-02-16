<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;
use BroadcastingHelpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShareController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                              Get post by uuid                              */
    /* -------------------------------------------------------------------------- */
    public function get_post_byuuid(Request $request)
    {
        /* Check ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }

        /* Validate post id */
        $validate = Validator::make($request->all(),[
            'post_id' => 'required'
        ],[
            'post_id.required' => 'Something\'s wrong! Please try again.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get post details */
        $posts = PostFeed::where('post_id',$request->input('post_id'));

        /* Check if post is share */
        if ($posts->first()->type == 'shared_post') {
            $posts = PostFeed::where('post_id',$posts->first()->share_source);
        }
        else {
            $posts = PostFeed::where('post_id',$request->input('post_id'));
        }

        /* Throw warning if post not found */
        if ($posts->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'The post you want to share did not exist!'
            ];
            return response()->json($data);
        }

        /* Throw warning if post is private */
        if ($posts->first()->visibility == 'private') {
            $data = [
                'status' => 'warning',
                'message' => 'This post is private.'
            ];
            return response()->json($data);
        }



        $posts->with(['MembersModel' => function ($mm) {
            return $mm->select('uuid', 'iagd_number', 'email_address', 'profile_image', 'first_name', 'last_name');
        }])->with('PostAttachments')->skip(0);

        $data = [
            'status' => 'success',
            'message' => 'Post found',
            'posts' => $posts->first()
        ];
        return response()->json($data);
    }
    /* -------------------------------------------------------------------------- */
    /*                             Share selected post                            */
    /* -------------------------------------------------------------------------- */
    public function share_post_create(Request $request)
    {
        /* Check if ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }

        /* Validate requests */
        $validate = Validator::make($request->all(),[
            'post_id' => 'required',
        ],[
            'post_id.required' => 'Something\'s wrong! Please try again.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get post details */
        $posts = PostFeed::where('post_id',$request->input('post_id'));

        /* Post did not exist */
        if ($posts->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Post is not available.'
            ];
            return response()->json($data);
        }

        /* Check post visibility */
        if ($posts->first()->visibility == 'private') {
            $data = [
                'status' => 'warning',
                'message' => 'Private post can\' be shared.'
            ];
            return response()->json($data);
        }

        /* Set variables value */
        $share_creator = Auth::guard('web')->user()->uuid;
        $post_message = ($request->input('share_text_message') == "") ? null:$request->input('share_text_message');
        $type = 'shared_post';
        $share_source = $request->input('post_id');

        /* Check if post_id is not in database */
        do {
            $post_id = Str::uuid();
        } while (PostFeed::where('post_id', '=', $post_id)->first() instanceof PostFeed);

        /* Create new post get shared_uuid post then add it to post shared_uuid */
        if ($posts->first()->type == 'shared_post') {
            $new_share_source = PostFeed::where('post_id',$posts->first()->share_source)->first()->post_id;
            $share_source = $new_share_source;
        }

        /* Create new post */
        $new_post = PostFeed::create([
            'post_id' => $post_id,
            'type' => $type,
            'uuid' => $share_creator,
            'post_message' => $post_message,
            'date' => Carbon::now(),
            'time' => time(),
            'status' => 'active',
            'visibility' => 'public',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'share_source' => $share_source,  // Nullable - fill insert uuid of post you want to share
        ]);

        if ($new_post->save()) {

            /* TODO : Notifify all followers */
            $data = [
                'post_uuid' => $post_id,
                'from_user_uuid' => Auth::guard('web')->user()->uuid,
            ];

            BroadcastingHelpers::eventNewPostCreated($data);

            $data = [
                'status' => 'success',
                'message' => 'Post successfully shared.'
            ];
            return response()->json($data);
        }
        else {
            $data = [
                'status' => 'warning',
                'message' => 'Post sharing failed.'
            ];
            return response()->json($data);
        }



    }

}

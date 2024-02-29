<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* USER MODELS */
use App\Models\Users\PostReaction;
use App\Models\Users\MembersModel;
use App\Models\Users\PostComments;
use App\Models\Users\PostFeed;
use App\Models\Users\PostAttachments;
use App\Models\Users\UserFollow;

/* HELPER */
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Validator;
use File;
use DB;
use App\Helper\Helper_Post_UpdatedAt;
use Image;
use App\Helper\NotificationsForUser_Helper;
use App\Helper\BroadcastingHelpers;

/* NOTIFICATION */
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;
use App\Events\PostCommentUpdate;

class PostFeedController extends Controller
{
    /* ========== MEMBER NOTIFICATION ========== */
    public function memberNotification($notifyData)
    {
        extract($notifyData);

        /* GET NOTIFY FROM USER */
        $from_user = MembersModel::where('uuid', $from_uuid)->first();

        /* GET NOTIFY TO USER */
        $id = MembersModel::where('uuid', $uuid)->first()->id;
        $find_notifiable_user = MembersModel::find($id);

        $data = [
            'user_data' => $find_notifiable_user->first(),
            'from_user' => $from_user,
            'message' => strval($message)
        ];
        Notification::send($find_notifiable_user, new MyPostNotification($data));
    }


    /* Post new comments */

    public function comment_in_post(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Check if post data not empty and properly set */
        if (!$request->has('post_uuid') || !$request->has('messageTxt')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }
        if (empty($request->input('post_uuid')) || empty($request->input('messageTxt'))) {
            $data = [
                'status' => 'error',
                'message' => 'Enter your comment.'
            ];
            return response()->json($data);
        }

        /* Set variables */
        $comment_fromuuid = Auth::guard('web')->user()->uuid;
        $post_uuid = $request->input('post_uuid');
        $commentTxt = $request->input('messageTxt');
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        if (Auth::guard('web')->user()->timezone != null) {
            $created_at = Carbon::now();
            $updated_at = Carbon::now();
        }
        $createComment = PostComments::create([
            'post_id' => $post_uuid,
            'uuid' => $comment_fromuuid,
            'comment' => $commentTxt,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        if ($createComment->save()) {

            $postDetails = PostFeed::where('post_id', $post_uuid);

            $data = [
                'post_uuid' => $post_uuid,
                'from_user_uuid' => Auth::guard('web')->user()->uuid,
                'commentTxt' => strval($commentTxt),
            ];

            BroadcastingHelpers::eventCommentNotification($data);

            $post_update_id = $postDetails->first()->id;
            $new_updated_at = Carbon::now();

            Helper_Post_UpdatedAt::update($post_update_id, $new_updated_at);

            /* Create new notificaitons */
            $data = [
                'from_uuid' => Auth::guard('web')->user()->uuid,
                'to_uuid' => $postDetails->first()->uuid,
                'type' => 'comment',
                'content' => $post_uuid,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];
            NotificationsForUser_Helper::createUserNotification($data);


            /* Get post comment */
            $PostComments = PostComments::where('id',$createComment->id)->with('MembersModel');

            /* Event for updating active post */
            $data = [
                'type' => 'update_active_post',
                'post_id' => $post_uuid,
                'comment_from_uuid' => Auth::guard('web')->user()->uuid,
                'postComments' => $PostComments->first()
            ];
            broadcast(new PostCommentUpdate($data));


            $data = [
                'status' => 'success',
                'message' => 'New comment added',
                'postComments' => $PostComments->first()
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Failed to add comment'
            ];
            return response()->json($data);
        }
    }

    /* Get comment with pagination */
    public function get_paginate_comments(Request $request)
    {
        if (!$request->ajax() || !$request->has('post_id') || !$request->has('comment_created_at')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }
        if (empty($request->input('post_id')) || empty($request->input('comment_created_at'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }
        /* Set variables */
        $post_id = $request->input('post_id');
        $created_at = $request->input('comment_created_at');

        /* Set sort value */
        $sortComments = 'asc';
        if ($request->input('sortComments') == 'oldest') {
            $sortComments = 'desc';
        }

        /* Get comments greater than comment_created_at */
        $PostComments = PostComments::where([
            ['post_id', '=', $post_id],
        ])
            ->orderBy('created_at', $sortComments)
            ->with('MembersModel');

        /* Get last comments */
        $last_comment_at = PostComments::where([
            ['post_id', '=', $post_id],
        ])->orderBy('created_at', 'DESC');

        $data = [
            'PostComments' => $PostComments->paginate(10),
            'last_comment_at' => $last_comment_at->first()->created_at
        ];
        return response()->json($data);
    }
    public function get_latest_comments(Request $request)
    {
        if (!$request->ajax() || !$request->has('post_uuid') || !$request->has('created_at') || empty($request->input('post_uuid')) || empty($request->input('created_at'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Fetch all new comments */
        $post_uuid = $request->input('post_uuid');
        $created_at = $request->input('created_at');

        $PostComments = PostComments::where([
            ['post_id', '=', $post_uuid],
            ['created_at', '>', $created_at]
        ])
            ->with('MembersModel');

        /* Get last comment date */
        $new_created_at = PostComments::where([
            ['post_id', '=', $post_uuid]
        ])->orderBy('created_at', 'DESC');

        $data = [
            'new_comments' => $PostComments->get(),
            'new_created_at' => $new_created_at->first()->created_at
        ];
        return response()->json($data);
    }

    /* Function to delete post in post feed page */
    public function post_delete(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            /* Response error */
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Check input value */
        $validate = Validator::make($request->all(), [
            'post_uuid' => 'required'
        ], [
                'post_uuid.required' => 'Something\'s wrong! Please try again later.'
            ]);

        if ($validate->fails()) {
            /* Throw error json data */
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* If all condition did not fail delete post */

        /* Find post in database */
        $PostFeed = PostFeed::where('post_id', $request->input('post_uuid'));

        $post_id = $PostFeed->first()->id;
        $post_uuid = $PostFeed->first()->post_id;

        if ($PostFeed->count() > 0) {
            /* delete post */
            $DeletePost = PostFeed::where('id', $post_id);

            if ($DeletePost->delete()) {
                /* Delete likes and comments of the post */
                /* If post force delete include this */
                // $pr = PostReaction::where('post_id', $post_uuid);
                // if ($pr->count() > 0) {
                //     $pr->delete();
                // }
                // $pc = PostComments::where('post_id', $post_uuid);
                // if ($pc->count() > 0) {
                //     $pc->delete();
                // }

                // /* Check if post has attachment */

                // $CheckPostAttachment = PostAttachments::where('post_uuid', $post_uuid);
                // if ($CheckPostAttachment->count() > 0) {

                //     /* Delete all attachments and remove data in table */
                //     foreach ($CheckPostAttachment->get() as $value) {
                //         $storePath = public_path($value->file_type);

                //         File::delete($storePath);
                //     }
                //     $CheckPostAttachment->delete();
                // }

                $data = [
                    'status' => 'success',
                    'message' => 'Post removed',
                    'postToRemove' => $post_uuid
                ];
                return response()->json($data);
            } else {
                /* Failed to delete post */
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to remove post'
                ];
                return response()->json($data);
            }

        } else {
            /* Return response error post did not exist */
            $data = [
                'status' => 'error',
                'message' => 'Post not found!'
            ];
            return response()->json($data);
        }
    }

    /* Post feed function version 2 */
    public function post_get(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

        /* Variables */
        $my_uuid = Auth::guard('web')->user()->uuid;

        $PostFeed = PostFeed::with([
            'MembersModel' => function ($mm) {
                return $mm->select('id', 'uuid', 'iagd_number', 'email_address', 'profile_image', 'first_name', 'last_name');
            }
        ])

        ->where(function ($v) use ($my_uuid) {
            $v->where('visibility','=',['public'])

            ->orWhere(function ($orv) use($my_uuid,$v) {
                $orv->where([
                    ['visibility','=','private']
                ])

                ->whereHas('MembersModel.myFollowers' , function ($mf) use ($my_uuid,$v) {

                    $mf->where([
                        ['uuid', '=', $my_uuid],
                        ['status', '=', '1']
                    ])

                    ->orWhere(function ($mm) use($my_uuid,$v) {
                        $mm->where([
                            ['follow_uuid', '=', $my_uuid],
                            ['status', '=', '1']
                        ]);
                    });

                });
            })
            ->orWhere(function($me) use ($my_uuid) {
                $me->where([
                    ['uuid','=',$my_uuid]
                ]);
            });
        })

        ->with([
            'PostReaction' => function ($pr) use ($my_uuid) {
                $pr->where([
                    ['uuid', $my_uuid],
                    ['reaction', '<>', null]
                ]);
            }
        ])
        ->withCount([
            'PostReaction as total_reaction' => function ($q) {
                $q->where('reaction', '<>', null);
            }
        ])
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
        return response()->json(['data' => $PostFeed]);
    }

    public function post_get_specific(Request $request)
    {
        /* Check if request is ajax */

        if (!$request->input('post_id')) {
            $data = [
                'status' => 'error',
                'message' => '`post_id` cannot be missing.'
            ];
            return response()->json($data);
        }

        /* Variables */
        $my_uuid = Auth::guard('web')->user()->uuid;

        $PostFeed = PostFeed::with([
            'MembersModel' => function ($mm) {
                return $mm->select('id', 'uuid', 'iagd_number', 'email_address', 'profile_image', 'first_name', 'last_name');
            }
        ])

        ->where([
            ['post_id', '=', $request->input('post_id')]
        ])

        ->with([
            'PostReaction' => function ($pr) use ($my_uuid) {
                $pr->where([
                    ['uuid', $my_uuid],
                    ['reaction', '<>', null]
                ]);
            }
        ])
        ->withCount([
            'PostReaction as total_reaction' => function ($q) {
                $q->where('reaction', '<>', null);
            }
        ])
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

        ->orderBy('updated_at', 'DESC');
        return response()->json(['data' => $PostFeed, 'post_id' => $request->input('post_id')]);
    }

    /* -------------------------------------------------------------------------- */
    /*                               View reaction                                */
    /* -------------------------------------------------------------------------- */
    public function post_reaction_view(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(),[
            'post_id' => 'required'
        ],[
            'post_id.required' => 'Something\'s wrong! Please try again later.'.$request->input('post_id')
        ]);

        /* Throw validation error */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get all comments then paginate */
        $PostReaction = PostReaction::where('post_id',$request->input('post_id'))
            ->where('reaction', '<>', '0');

        /* Throw response error if comments is empty */
        if ($PostReaction->count() < 1) {
            $data = [
                'status' => 'info',
                'message' => 'No reaction...'
            ];
            return response()->json($data);
        }
        $post_id = $request->input('post_id');

        /* Create comment pagination */
        $postReactions = PostReaction::where('post_id',$post_id)
        ->with('MembersModel')
        ->orderBy('created_at','DESC')
        ->where('reaction', '<>', '0')
        ->get();

        $data = [
            'status' => 'success',
            'postReactions' => $postReactions,
        ];
        return response()->json($data);
    }


    /* User profile react */
    public function post_reaction_create(Request $request)
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
            'reacts' => 'required',
        ], [
                'post_id.required' => 'Something\'s wrong, Please try again!',
                'reacts.required' => 'Something\'s wrong, Please try again!'
            ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Re-check post reaction request values */

        $reacts = json_decode($request->input('reacts')) ?? [];
        $reacts_holder = '';
        foreach ($reacts as $react) {
            $reacts_holder .= $react . ', ';
        }
        $reacts_holder = substr($reacts_holder, 0, -2);

        /* Check if user reacted to post already */

        $PostReaction = PostReaction::where([
            ['post_id', '=', $request->input('post_id')],
            ['uuid', '=', Auth::guard('web')->user()->uuid]
        ]);

        if ($PostReaction->count() > 0) {

            /* Check what's user reaction to post then update user reaction */
            $id = $PostReaction->first()->id;
            $post_id = $request->input('post_id');
            
            /* Update reaction to reaction value */
            $upReaction = PostReaction::find($id);

            $upReaction->reaction = $reacts_holder;
            $upReaction->updated_at = Carbon::now();
            $upReaction->save();

            $data = [
                'post_uuid' => $post_id,
                'from_user_uuid' => Auth::guard('web')->user()->uuid,
                'reaction_value' => $reacts_holder,
            ];

            BroadcastingHelpers::eventReactionNotification($data);

            /* POST DATA */
            $postdet = PostFeed::where('post_id', $request->input('post_id'));

            /* Update Posts updated_at time when user reacts */
            $post_update_id = $postdet->first()->id;
            $new_updated_at = Carbon::now();

            Helper_Post_UpdatedAt::update($post_update_id, $new_updated_at);

            /* Create new notificaitons */
            $data = [
                'from_uuid' => Auth::guard('web')->user()->uuid,
                'to_uuid' => $postdet->first()->uuid,
                'type' => 'react',
                'content' => $post_id,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];
            NotificationsForUser_Helper::createUserNotification($data);

            $data = [
                'status' => 'success',
                'message' => 'Reaction updated',
                'postReacted' => $request->input('post_id'),
                'myReaction' => $reacts_holder
            ];
            return response()->json($data);

        } else {
            $post_id = $request->input('post_id');
            $postdet = PostFeed::where('post_id', $request->input('post_id'));
            /* Create new row with user reaction */
            $CreateReaction = PostReaction::create([
                'post_id' => $request->input('post_id'),
                'uuid' => Auth::guard('web')->user()->uuid,
                'reaction' => $reacts_holder,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($CreateReaction->save()) {

                $data = [
                    'post_uuid' => $post_id,
                    'from_user_uuid' => Auth::guard('web')->user()->uuid,
                    'reaction_value' => $reacts_holder,
                ];

                BroadcastingHelpers::eventReactionNotification($data);

                /* Create new notificaitons */
                $data = [
                    'from_uuid' => Auth::guard('web')->user()->uuid,
                    'to_uuid' => $postdet->first()->uuid,
                    'type' => 'react',
                    'content' => $post_id,
                    'status' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];
                NotificationsForUser_Helper::createUserNotification($data);

                /* Update Posts updated_at time when user reacts */
                $post_update_id = $postdet->first()->id;
                $new_updated_at = Carbon::now();

                Helper_Post_UpdatedAt::update($post_update_id, $new_updated_at);

                $data = [
                    'status' => 'success',
                    'message' => 'Reaction created',
                    'postReacted' => $request->input('post_id'),
                    'myReaction' => $reacts_holder
                ];
                return response()->json($data);

            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Reaction failed',
                    'postReacted' => $request->input('post_id'),
                    'myReaction' => $reacts_holder
                ];
                return response()->json($data);
            }
        }

    }

    public function reaction_template($reaction_int)
    {
        switch ($reaction_int) {
            case '1':
                return $msg = 'like';
                break;

            case '2':
                return $msg = 'hahaha';
                break;

            case '3':
                return $msg = 'love';
                break;

            default:
                return $msg = null;
                break;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               Create new post                              */
    /* -------------------------------------------------------------------------- */
    public function create_new_post(Request $request)
    {
        /* Image file format */
        $supported_file_format = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'heic', 'heif', 'mp4', 'webm', 'ogg'];

        /* Image default value */
        $post_images = [];

        /* Check if post has image attachment */
        if ($request->hasFile('file_attachment')) {

            /* Check file extension */
            foreach ($request->file('file_attachment') as $row) {
                if (!in_array($row->extension(), $supported_file_format)) {
                    return response()->json([
                        'status' => 'error', 
                        'message' => 'Format not supported'
                    ]);
                }
            }

            /* Count all image and video in post request */
            $max_video_count = 0;
            $max_image_count = 0;

            foreach ($request->file('file_attachment') as $row) {
                if ($row->extension() == 'jpg' || $row->extension() == 'jpeg' || $row->extension() == 'gif' || $row->extension() == 'png' || $row->extension() == 'heic' || $row->extension() == 'heif') {
                    $max_image_count++;
                }

                if ($row->extension() == 'mp4' || $row->extension() == 'webm' || $row->extension() == 'ogg') {
                    if ($row->getSize() > '500000000') {
                        return response()->json([
                            'status' => 'error', 
                            'message' => 'You can upload up to 500mb file size.'
                        ]);
                    }
                    $max_video_count++;
                }
            }

            if ($max_image_count > 3) {

                return response()->json([
                    'status' => 'error', 
                    'message' => 'Maximum image upload limited to 3'
                ]);
            }

            if ($max_video_count > 1) {

                return response()->json([
                    'status' => 'error', 
                    'message' => 'Maximum video upload limited to 1 only'
                ]);
            }


            /* Create temporary and permament folder for post image upload */
            $folderPath = public_path('img/user/' . Auth::guard('web')->user()->uuid . '/temporary/post_images');
            $storePath = public_path('img/user/' . Auth::guard('web')->user()->uuid . '/post_uploads');
            $fileDbPath = 'img/user/' . Auth::guard('web')->user()->uuid . '/post_uploads';


            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            if (!file_exists($storePath)) {
                mkdir($storePath, 0777, true);
            }

            /* Wrap upload with try to track errors */
            try {

                /* Upload images to /temporary/post_images */
                foreach ($request->file('file_attachment') as $post_image) {

                    if ($post_image->extension() == 'heic' || $post_image->extension() == 'webp') {


                        $inputImage = 'post-img-' . Auth::guard('web')->user()->uuid . '-' . Str::random(11) . '.jpg';

                        $imgFile = Image::make($post_image);
                        $imgFile->save($folderPath . '/' . $inputImage);

                        $post_images[] = [
                            'file_name' => $inputImage,
                            'file_extension' => 'jpg'
                        ];
                    } else {

                        $filename = 'post-img-' . Auth::guard('web')->user()->uuid . '-' . Str::random(11) . '.' . $post_image->extension();
                        $f_extension = $post_image->extension();

                        $post_image->move($folderPath, $filename);



                        $post_images[] = [
                            'file_name' => $filename,
                            'file_extension' => $f_extension
                        ];
                    }
                }

            } catch (\Throwable $th) {
                /* If error occures remove temporary uploaded files if exist */
                foreach ($request->file('file_attachment') as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath . '/' . $value);
                    }
                }
                return response()->json([
                    'status' => 'error', 
                    'message' => 'File upload failed.'
                ]);

            }


            $validate = Validator::make($request->all(), [
                'post_visible' => 'required'
            ], [
                    'post_visible.required' => 'Select post visibility'
                ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => $validate->errors()->first()
                ]);
            }

            $post_type = 'post_attachments';

        } else {
            if ($request->input('post_msg') == null || $request->input('post_msg') == " ") {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Write what you want to share.'
                ]);
            }
            $validate = Validator::make($request->all(), [
                'post_msg' => 'required',
                'post_visible' => 'required'
            ], [
                    'post_msg.required' => 'Enter a post',
                    'post_visible.required' => 'Select post visibility'
                ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => $validate->errors()->first()
                ]);
            }

            $post_type = 'post';
        }


        /* Check if type is public or private */
        if ($request->input('post_visible') == 'public') {
            $post_visibility = 'public';
        } elseif ($request->input('post_visible') == 'private') {
            $post_visibility = 'private';
        } else {
            $post_visibility = 'public';
        }


        /* Create new post */
        do {
            $post_id = Str::uuid();
        } while (PostFeed::where('post_id', '=', $post_id)->first() instanceof PostFeed);

        $create_new_post = PostFeed::create([
            'post_id' => $post_id,
            'type' => $post_type,
            'uuid' => Auth::guard('web')->user()->uuid,
            'post_message' => $request->input('post_msg'),
            'date' => Carbon::now(),
            'time' => time(),
            'status' => 'active',
            'visibility' => $post_visibility,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($create_new_post->save()) {


            /* If post_images has image attachment  PostAttachments */
            if ($post_images > 0) {
                foreach ($post_images as $key => $value) {


                    /* Move temporary image to permanent folder */

                    File::move($folderPath . '/' . $value['file_name'], $storePath . '/' . $value['file_name']);

                    /* Insert into PostAttachemnt table */
                    PostAttachments::create([
                        'post_uuid' => $post_id,
                        'post_user_uuid' => Auth::guard('web')->user()->uuid,
                        'file_path' => $fileDbPath . '/' . $value['file_name'],
                        'file_type' => 'attachment',
                        'file_extension' => $value['file_extension'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                }
            }

            /* TODO : Notify all follower for this new post */
            $data = [
                'post_uuid' => $post_id,
                'from_user_uuid' => Auth::guard('web')->user()->uuid,
            ];

            BroadcastingHelpers::eventNewPostCreated($data);


            return response()->json([
                'status' => 'success',
                'post_uuid' => $post_id,
                'from_user_uuid' => Auth::guard('web')->user()->uuid,
                'message' => 'Post created successfully'
            ]);
        } else {
            if ($post_images > 0) {
                foreach ($post_images as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath . '/' . $value);
                    }
                }
            }

            PostFeed::find($create_new_post->id)->forceDelete();

            return response()->json([
                'status' => 'error', 
                'message' => 'Error posting'
            ]);
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                             Create new comment                             */
    /* -------------------------------------------------------------------------- */
    public function view_comments(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(),[
            'post_id' => 'required'
        ],[
            'post_id.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /* Throw validation error */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Get all comments then paginate */
        $PostComments = PostComments::where('post_id',$request->input('post_id'));

        /* Throw response error if comments is empty */
        if ($PostComments->count() < 1) {
            $data = [
                'status' => 'info',
                'message' => 'No comment......'
            ];
            return response()->json($data);
        }
        $post_id = $request->input('post_id');
        $created_at = $request->input('comment_lastDate');

        /* Create comment pagination */
        $postComments = PostComments::where('post_id',$post_id)
        ->with('MembersModel')
        ->orderBy('created_at','ASC')
        ->paginate(5);

        $data = [
            'status' => 'success',
            'postComments' => $postComments,
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                               Delete comments                              */
    /* -------------------------------------------------------------------------- */
    public function delete_comments(Request $request)
    {
        /* Check if request is from ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

        /* Validate post data */
        $validate = Validator::make($request->all(),[
            'comment_id' => 'required',
            'post_id' => 'required'
        ],[
            'comment_id.required' => 'Something\'s wrong, Please try again!',
            'post_id.required' => 'Something\'s wrong, Please try again!',
        ]);

        /* Throw validation error */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Find comment to delete */
        $commentID = $request->input('comment_id');
        $post_id = $request->input('post_id');
        $comment = PostComments::find($commentID);

        /* Check if comment exist */
        if ($comment->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'This comment does not exist!'
            ];
            return response()->json($data);
        }

        /* Delete this comment */
        if ($comment->delete()) {
            $data = [
                'status' => 'success',
                'message' => 'Comment has been deleted',
                'commentID' => $commentID,
                'postID' => $post_id
            ];
            return response()->json($data);
        }
        else {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

    }
}

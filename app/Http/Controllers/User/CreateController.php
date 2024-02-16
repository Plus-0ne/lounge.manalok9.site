<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Users\MembersModel;
use App\Models\Users\IagdMembers;
use App\Models\Users\EmailVerification;
use App\Models\Users\MembersGallery;
use App\Models\Users\PostFeed;
use App\Models\Users\PostComments;
use App\Models\Users\Trade;
use App\Models\Users\TradeLog;
use App\Models\Users\MembersAd;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersRabbit;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\NonMemberRegistration;
use App\Models\Users\StorageFile;

use App\Models\Users\PostAttachments;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;

/* EVENTS */
use App\Events\YourPostNotification;
use App\Events\YourTradeNotification;
use Illuminate\Support\Facades\Hash;

/* NOTIFICATION */
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;

class CreateController extends Controller
{
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

    public function register_user_pass(Request $request)
    {
        /* CHECK IF LOGGED IN */
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        /* CHECK SESSION */
        if (!$request->session()->has('iagd_checking')) {
            return redirect()->route('user.user_registered_members');
        }
        if (!$request->session()->has('iagd_checking.iagd_number')) {
            return redirect()->route('user.user_registered_members');
        }
        if (!$request->session()->has('iagd_checking.email_address')) {
            return redirect()->route('user.user_registered_members');
        }

        if (!$request->has('pass1') || !$request->has('pass2')) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* SET VARIABLE */
        $pass1 = $request->input('pass1');
        $pass2 = $request->input('pass2');

        /* VALIDATE INPUT */
        $validate = Validator::make($request->all(), [
            'pass1' => 'required',
            'pass2' => 'required',
        ], [
            'pass1.required' => 'Password is required',
            'pass2.required' => 'Password is required',
        ]);

        /* THROW ERROR IF FAILS */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* COMPARE PASSWORD */
        if ($pass1 !== $pass2) {
            return redirect()->back()->with('response', 'pass_not_matched');
        }


        /* CREATE ACCOUNT FOR USER */

        $iagd_number = $request->session()->get('iagd_checking.iagd_number');
        $email_address = $request->session()->get('iagd_checking.email_address');

        /* CHECK IF IAGD IS REGISTERED */
        $CheckIAGD = MembersModel::where('iagd_number', $iagd_number);
        if ($CheckIAGD->count() > 0) {
            return redirect()->route('user.login')->with('response', 'user_already_in_lounge');
        }
        /* CHECK IF EMAIL IS REGISTERED */
        $CheckIAGD = MembersModel::where('email_address', $email_address);
        if ($CheckIAGD->count() > 0) {
            return redirect()->route('user.login')->with('response', 'user_already_in_lounge');
        }

        $created_at = Carbon::now();
            $updated_at = Carbon::now();

        do {
            $uuid = Str::uuid();
        } while (MembersModel::where('uuid', '=', $uuid)->first()  instanceof MembersModel);

        $CreateMember = MembersModel::create([
            'iagd_number' => $iagd_number,
            'uuid' => $uuid,
            'email_address' => $email_address,
            'password' => Hash::make($pass1),
            'timezone' => $request->input('timezonee'),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);
        if ($CreateMember->save()) {

            $VerifyUser = EmailVerification::where('iagd_number', $iagd_number);
            $id = $VerifyUser->first()->id;
            $UpdateVerified = EmailVerification::find($id);

            $UpdateVerified->verified = 1;
            $UpdateVerified->updated_at = $updated_at;


            $UpdateVerified->save();

            if ($request->session()->has('iagd_checking')) {
                $request->session()->forget('iagd_checking');
            }

            return redirect()->route('user.login')->with('response', 'account_reated');
        } else {
            return redirect()->back()->with('response', 'key_error');
        }
    }
    public function upload_dog_image(Request $request)
    {
        if (!$request->has('name')) {
            return redirect()->back()->with('response', 'key_error');
        }
        if (!$request->has('gender')) {
            return redirect()->back()->with('response', 'key_error');
        }
        if (!$request->has('breed')) {
            return redirect()->back()->with('response', 'key_error');
        }
        if (!$request->has('description')) {
            return redirect()->back()->with('response', 'key_error');
        }
        // if (!$request->hasFile('file_path')) {
        //     return redirect()->back()->with('response','key_error');
        // }

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'breed' => 'required',
            'description' => 'required',
            'file_path' => 'required|image|mimes:jpg,png,jpeg,gif',
        ], [
            'name.required' => 'Name is required',
            'gender.required' => 'Gender is required',
            'breed.required' => 'Breed is required',
            'description.required' => 'Description is required',
            'file_path.required' => 'Image is required',
            'file_path.image' => 'Uploaded file is not an image',
            'file_path.mimes' => 'Acceptable file format is jpg , png , jpeg or gif',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* GET MEMBER IAGD NUMBER */
        $uuid = Auth::guard('web')->user()->uuid;

        $CheckGallery = MembersGallery::where('uuid', $uuid);
        if ($CheckGallery->count() < 5) {
            /* CREATE NEW ROW DATA */
            if (!$request->hasFile('file_path')) {
                return Redirect()->back()->with('status', 'image_is_null');
            }
            $file = $request->file('file_path');

            $file_name = 'dog_file_' . $request->input('name') . '_' . time();
            $dog_img_path = 'uploads/members/' . $uuid . '/' . $file_name . '.' . $file->extension();

            $file->move(public_path('uploads/members/' . $uuid), $dog_img_path);

            $CreateNewDog = MembersGallery::create([
                'uuid' => $uuid,
                'name' => $request->input('name'),
                'gender' => $request->input('gender'),
                'breed' => $request->input('breed'),
                'description' => $request->input('description'),
                'file_path' => $dog_img_path,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($CreateNewDog->save()) {
                return redirect()->back()->with('response', 'success_img_save');
            } else {
                return redirect()->back()->with('response', 'failed_to_save');
            }
        } else {
            return redirect()->back()->with('response', 'max_file_upload');
        }
    }

    /* TODO : Create post variations like post with images , post with link from other platforms */
    public function create_post(Request $request)
    {

        /* TODO : Different type of post - Simple post , image post text no value , simple post with image upload */
        /* TODO : link posts , link post with image , simple post with link and images */
        $post_images = null;
        /* Array format */
        $img_format = ['gif','jpg','png'];

        /* Check if post has image attachment */

        if ($request->hasFile('image_post')) {

            /* Check file extension */
            foreach ($request->file('image_post') as $row) {
                if (!in_array($row->extension(),$img_format)) {
                    $data = [
                        'status' => 'error',
                        'message' => 'Image format not supported'
                    ];
                    return redirect()->back()->with($data);
                }
            }

            /* Count all image in */
            $max_image_count = 0;
            foreach ($request->file('image_post') as $row) {
                $max_image_count++;
            }

            if ($max_image_count > 3) {

                $data = [
                    'status' => 'error',
                    'message' => 'Maximum image upload limited to 3'
                ];
                return redirect()->back()->with($data);
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
                foreach ($request->file('image_post') as $post_image) {
                    $filename = 'post-img-'.Auth::guard('web')->user()->uuid.'-'.Str::random(11).'.'.$post_image->extension();
                    $post_image->move($folderPath, $filename);
                    $post_images[] = $filename;
                }

            } catch (\Throwable $th) {
                /* If error occures remove temporary uploaded files if exist */
                foreach ($request->file('image_post') as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }

            }

            $validate = Validator::make($request->all(), [
                'post_visible' => 'required'
            ], [
                'post_visible.required' => 'Select post visibility'
            ]);

            if ($validate->fails()) {
                $data = [
                    'status' => 'error',
                    'message' => $validate->errors()->first()
                ];
                return redirect()->back()->with($data);
            }
            $post_type = 'post_attachments';
        }
        else
        {
            if ($request->input('post_msg') == null || $request->input('post_msg') == " ") {
                $data = [
                    'status' => 'error',
                    'message' => 'Write what you want to share.'
                ];
                return redirect()->back()->with($data);
            }
            $validate = Validator::make($request->all(), [
                'post_msg' => 'required',
                'post_visible' => 'required'
            ], [
                'post_msg.required' => 'Enter a post',
                'post_visible.required' => 'Select post visibility'
            ]);

            if ($validate->fails()) {
                $data = [
                    'status' => 'error',
                    'message' => $validate->errors()->first()
                ];
                return redirect()->back()->with($data);
            }
            $post_type = 'post';
        }


        /* Check if type is public or private */
        if ($request->input('post_visible') == 'public') {
            $post_visibility = 'public';
        }
        elseif ($request->input('post_visible') == 'private') {
            $post_visibility = 'private';
        }
        else
        {
            $post_visibility = 'public';
        }


        /* Create new post */
        do {
            $post_id = Str::uuid();
        } while (PostFeed::where('post_id', '=', $post_id)->first()  instanceof PostFeed);

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

                        /* Check file format */

                        /* Move temporary image to permanent folder */

                        File::move($folderPath.'/'.$value,$storePath.'/'.$value);

                        /* Insert into PostAttachemnt table */
                        PostAttachments::create([
                            'post_uuid' => $post_id,
                            'post_user_uuid' => Auth::guard('web')->user()->uuid,
                            'file_path' => $fileDbPath.'/'.$value,
                            'file_type' => 'attachment',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                }
            }

            /* TODO : Notify all follower for this new post */
            return redirect()->back()->with('response', 'post_created');
        } else {
            if ($post_images > 0) {
                foreach ($post_images as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }

            $data = [
                'status' => 'error',
                'message' => 'Error posting...'
            ];
            return redirect()->back()->with($data);
        }
    }

    public function insert_new_comment(Request $request)
    {
        /* CHECK IF KEY IS SET */
        if (!$request->has('pid') || !$request->has('postComment') || !$request->has('punumber')) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        /* CHECK IF POST ID IS NOT EMPTY */
        if (empty($request->input('pid')) || empty($request->input('punumber'))) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        /* VALIDATE REQUEST */
        $validate = Validator::make($request->all(), [
            'postComment' => 'required'
        ], [
            'postComment.required' => 'Enter you comment'
        ]);

        /* THROW ERROR MESSAGE */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* POST NEW COMMENT */
        $CreateNewComment = PostComments::create([
            'post_id' => $request->input('pid'),
            'uuid' => Auth::guard('web')->user()->uuid,
            'comment' => strip_tags($request->input('postComment')),
            'mentions' => $request->input('punumber'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($CreateNewComment->save()) {
            $dataa = [
                'status' => 'success',
                'message' => 'Successfully post a new comment'
            ];

            $data = [
                'post_id' => $request->input('pid'),
                'iagd_number' => Auth::guard('web')->user()->iagd_number,
                'message' => 'New comment added',
            ];
            broadcast(new YourPostNotification($data))->toOthers();

            $postdet = PostFeed::where('post_id', $request->input('pid'));

            $notifyData = [
                'uuid' => $postdet->first()->uuid,
                'from_uuid' => Auth::guard('web')->user()->uuid,
                'message' => 'commented in your post',
            ];
            $this->memberNotification($notifyData);

            return response()->json($dataa);
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to save comment'
            ];
            return response()->json($data);
        }
    }



    /* PET TRADING */
    public function create_trade(Request $request)
    {
        if (!$request->has('trade_description')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'trade_description' => 'required',
        ], [
            'trade_description.required' => 'Enter your trade description'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* INSERT TRADE */
        do {
            $trade_no = Str::uuid();
        } while (Trade::where('trade_no', '=', $trade_no)->first()  instanceof Trade);
        do {
            $trade_log_no = Str::uuid();
        } while (TradeLog::where('trade_log_no', '=', $trade_log_no)->first()  instanceof TradeLog);

        $create_new_trade = Trade::create([
            'trade_no' => $trade_no,
            'trade_log_no' => $trade_log_no,
            'poster_iagd_number' => Auth::guard('web')->user()->iagd_number,
            'description' => $request->input('trade_description'),
            'trade_status' => 'open',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // strtotime("+1 day")

        if ($create_new_trade->save()) {
            // return redirect()->back()->with('response', 'trade_created');
            return redirect()->route('user.view_trade', ['tradeno' => $trade_no]);
        } else {
            return redirect()->back()->with('response', 'trade_failed');
        }
    }
    public function create_trade_request(Request $request)
    {
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

        $validate = Validator::make($request->all(), [
            'tradeno' => 'required',
        ], [
            'tradeno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR MESSAGE */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $GetTrade_data = Trade::where('trade_no', $request->input('tradeno'));
        if ($GetTrade_data->count() > 0) {

            $gtd = $GetTrade_data->first();

            if ($gtd->poster_iagd_number != Auth::guard('web')->user()->iagd_number) { // don't allow poster to create request
                if (strlen($gtd->requester_iagd_number) < 1) { // don't create request when requester already exists
                    /* GET REQUESTER DETAILS */
                    $RequesterOngoingTrades_data = TradeLog::where('iagd_number', Auth::guard('web')->user()->iagd_number)
                                                    ->where('log_status', 'pending')
                                                    ->orWhere('log_status', 'accepted');
                    if ($RequesterOngoingTrades_data->count() < 1) {
                        $RequesterTrade_data = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                                        ->where('iagd_number', Auth::guard('web')->user()->iagd_number)
                                                        ->where('log_status', 'pending')
                                                        ->orWhere('log_status', 'accepted')
                                                        ->orWhere('log_status', 'fulfilled');
                        if ($RequesterTrade_data->count() < 1) {
                            $create_new_request = TradeLog::create([
                                'trade_log_no' => $gtd->trade_log_no,
                                'trade_no' => $gtd->trade_no,
                                'iagd_number' => Auth::guard('web')->user()->iagd_number,
                                'cash_amount' => '0',
                                'role' => 'requester',
                                'accepted' => '0',
                                'log_status' => 'pending',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);

                            if ($create_new_request->save()) {
                                $id = MembersModel::where('iagd_number', $gtd->poster_iagd_number)->first()->id;
                                $find_notifiable_user = MembersModel::find($id);
                                $data = [
                                    'iagd_number' => Auth::guard('web')->user()->iagd_number,
                                    'message' => 'sent a trade request to Trade #'. $request->input('tradeno')
                                ];
                                Notification::send($find_notifiable_user, new MyPostNotification($data));

                                $data = [
                                    'trade_log_no' => $gtd->trade_log_no,
                                    'iagd_number' => Auth::guard('web')->user()->iagd_number,
                                    'action' => 'trade_request_send',
                                ];
                                broadcast(new YourTradeNotification($data))->toOthers();

                                return response()->json('request_created');
                            } else {
                                return response()->json('request_failed');
                            }
                        } else {
                            return response()->json('request_exists');
                        }
                    } else {
                        return response()->json('requester_has_trades_ongoing');
                    }
                } else {
                    return response()->json('trade_ongoing');
                }
            } else {
                return response()->json('poster_requesting');
            }
        } else {
            return response()->json('trade_not_found');
        }
    }

    /* MEMBER ADS */
    public function add_advertisement(Request $request)
    {
        if (!$request->has('ad_title') || !$request->has('ad_message')) {
            return redirect()->back()->with('response', 'key_error');
        }

        $validate = Validator::make($request->all(), [
            'ad_title' => 'required',
            'ad_message' => 'required',
            'file_path' => 'image|mimes:jpg,png,jpeg,gif',
        ], [
            'ad_title.required' => 'Enter advertisement title',
            'ad_message.required' => 'Enter advertisement message',
            'file_path.image' => 'Uploaded file is not an image',
            'file_path.mimes' => 'Acceptable file format is jpg , png , jpeg or gif',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        if (!empty(Auth::guard('web')->user()->uuid)) {
            /* INSERT AD */
            do {
                $member_ad_no = Str::uuid();
            } while (MembersAd::where('member_ad_no', '=', $member_ad_no)->first()  instanceof MembersAd);
            do {
                $ad_uuid = Str::uuid();
            } while (MembersAd::where('uuid', '=', $ad_uuid)->first()  instanceof MembersAd);

            // UPLOAD IMAGE
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');

                $file_name = 'ad_file_' . $ad_uuid . '_' . time();
                $ad_img_path = 'uploads/advertisements/' . $ad_uuid . '/' . $file_name . '.' . $file->extension();

                $file->move(public_path('uploads/advertisements/' . $ad_uuid), $ad_img_path);
            } else {
                $ad_img_path = NULL;
            }


            $create_new_ad = MembersAd::create([
                'member_ad_no' => $member_ad_no,
                'member_uuid' => Auth::guard('web')->user()->uuid,
                'uuid' => $ad_uuid,
                'title' => $request->input('ad_title'),
                'message' => $request->input('ad_message'),
                'file_path' => $ad_img_path,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($create_new_ad->save()) {
                return redirect()->back()->with('response', 'ad_created');
            } else {
                return redirect()->back()->with('response', 'ad_failed');
            }
        } else {
            return redirect()->back()->with('response', 'not_allowed');
        }
    }

    /* ADD UNREGISTERED DOG */
    // public function add_dog_unregistered(Request $request)
    // {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = [
    //         '_token',
    //         'pet_petname',
    //         'pet_birthdate',
    //         'pet_gender',
    //         'pet_location',
    //         'pet_breed',
    //         'pet_breeder',
    //         'pet_markings',
    //         'pet_petcolor',
    //         'pet_eyecolor',
    //         'pet_height',
    //         'pet_weight',
    //         'pet_co_owner',

    //         'pet_microchip_no',
    //         'pet_age',
    //         'pet_vet_name',
    //         'pet_vet_url',
    //         'pet_shelter',
    //         'pet_shelter_url',
    //         'pet_breeder',
    //         'pet_breeder_url',
    //         'pet_sirename',
    //         'pet_sire_breed',
    //         'pet_sireregno',
    //         'pet_damname',
    //         'pet_dam_breed',
    //         'pet_damregno',
    //         'pet_image',
    //         'pet_sire_image',
    //         'pet_dam_image',
    //         'pet_supporting_documents',
    //         'pet_vet_record_documents',
    //         'pet_sire_supporting_documents',
    //         'pet_dam_supporting_documents',
    //     ];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($key_arr as $key => $value) {
    //         if (!$request->has($value)
    //          && $value != 'pet_image'
    //          && $value != 'pet_sire_image'
    //          && $value != 'pet_dam_image'
    //          && $value != 'pet_supporting_documents'
    //          && $value != 'pet_vet_record_documents'
    //          && $value != 'pet_sire_supporting_documents'
    //          && $value != 'pet_dam_supporting_documents') {
    //             return redirect()->back()->with('response', 'key_error');
    //         }
    //     }

    //     /* VALIDATE INPUTS */
    //     $validate = Validator::make($request->all(),[
    //         'pet_petname' => 'required',
    //         'pet_birthdate' => 'required',
    //         'pet_gender' => 'required',
    //         'pet_breed' => 'required',
    //         'pet_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
    //         'pet_sire_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
    //         'pet_dam_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
    //         'pet_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
    //         'pet_vet_record_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
    //         'pet_sire_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
    //         'pet_dam_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
    //     ],[
    //         'pet_petname.required' => 'Pet name is required.',
    //         'pet_birthdate.required' => 'Birth date is required.',
    //         'pet_gender.required' => 'Gender is required.',
    //         'pet_breed.required' => 'Pet breed is required.',
    //         'pet_image.image' => 'Uploaded pet photo is not an image.',
    //         'pet_image.mimes' => 'Acceptable pet photo format is jpg, png, jpeg, or gif.',
    //         'pet_image.max' => 'Uploaded image must be smaller than 10MB.',
    //         'pet_sire_image.image' => 'Uploaded sire image is not an image.',
    //         'pet_sire_image.mimes' => 'Acceptable sire image format is jpg, png, jpeg, or gif.',
    //         'pet_sire_image.max' => 'Uploaded image must be smaller than 10MB.',
    //         'pet_dam_image.image' => 'Uploaded dam image is not an image.',
    //         'pet_dam_image.mimes' => 'Acceptable dam image format is jpg, png, jpeg, or gif.',
    //         'pet_dam_image.max' => 'Uploaded image must be smaller than 10MB.',

    //         'pet_supporting_documents.file' => 'Uploaded pet supporting document is not a file.',
    //         'pet_supporting_documents.mimes' => 'Supported file types for pet supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
    //         'pet_supporting_documents.max' => 'Uploaded pet supporting document must be smaller than 5MB.',
    //         'pet_vet_record_documents.file' => 'Uploaded vet record document is not a file.',
    //         'pet_vet_record_documents.mimes' => 'Supported file types for vet record document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
    //         'pet_vet_record_documents.max' => 'Uploaded vet record document must be smaller than 5MB.',
    //         'pet_sire_supporting_documents.file' => 'Uploaded sire supporting document is not a file.',
    //         'pet_sire_supporting_documents.mimes' => 'Supported file types for sire supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
    //         'pet_sire_supporting_documents.max' => 'Uploaded sire supporting document must be smaller than 5MB.',
    //         'pet_dam_supporting_documents.file' => 'Uploaded dam supporting document is not a file.',
    //         'pet_dam_supporting_documents.mimes' => 'Supported file types for dam supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
    //         'pet_dam_supporting_documents.max' => 'Uploaded dam supporting document must be smaller than 5MB.',
    //     ]);

    //     /* THROW ERROR IF VALIDATION FAILED */
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate);
    //     }

    //     if (!empty(Auth::guard('web')->user()->uuid)) {
    //         /* INSERT DOG */
    //         do {
    //             $PetUUID = Str::uuid();
    //         } while (MembersDog::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersDog);

    //         $create_new_dog = MembersDog::create([
    //             'PetUUID' => $PetUUID,
    //             'OwnerUUID' => Auth::guard('web')->user()->uuid,
    //             'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
    //             'PetName' => $request->input('pet_petname'),
    //             'BirthDate' => $request->input('pet_birthdate'),
    //             'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
    //             'Location' => $request->input('pet_location'),
    //             'Breed' => $request->input('pet_breed'),
    //             'Breeder' => $request->input('pet_breeder'),
    //             'Markings' => $request->input('pet_markings'),
    //             'PetColor' => $request->input('pet_petcolor'),
    //             'EyeColor' => $request->input('pet_eyecolor'),
    //             'Height' => $request->input('pet_height'),
    //             'Weight' => $request->input('pet_weight'),
    //             'SireName' => $request->input('pet_sirename'),
    //             'DamName' => $request->input('pet_damname'),
    //             'Co_Owner' => $request->input('pet_co_owner'),
    //         ]);

    //         if ($create_new_dog->save()) {

    //             /* CREATE REGISTRATION */
    //             do {
    //                 $UUID = Str::uuid();
    //             } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

    //             $create_new_nm_registration = NonMemberRegistration::create([
    //                 'UUID' => $UUID,
    //                 'FullName' => $request->input('full_name'),
    //                 'ContactNumber' => $request->input('contact_number'),
    //                 'EmailAddress' => $request->input('email_address'),
    //                 'FacebookPage' => $request->input('facebook_page'),

    //                 'MicrochipNo' => $request->input('pet_microchip_no'),
    //                 'AgeInMonths' => $request->input('pet_age'),
    //                 'VetClinicName' => $request->input('pet_vet_name'),
    //                 'VetOnlineProfile' => $request->input('pet_vet_url'),
    //                 'ShelterInfo' => $request->input('pet_shelter'),
    //                 'ShelterOnlineProfile' => $request->input('pet_shelter_url'),
    //                 'BreederInfo' => $request->input('pet_breeder'),
    //                 'BreederOnlineProfile' => $request->input('pet_breeder_url'),
    //                 'SireName' => $request->input('pet_sirename'),
    //                 'SireBreed' => $request->input('pet_sire_breed'),
    //                 'SireRegNo' => $request->input('pet_sireregno'),
    //                 'DamName' => $request->input('pet_damname'),
    //                 'DamBreed' => $request->input('pet_dam_breed'),
    //                 'DamRegNo' => $request->input('pet_damregno'),

    //                 'Type' => 'dog',
    //                 'PetUUID' => $PetUUID,
    //             ]);

    //             // UPLOAD IMAGE TO ML STORAGE
    //             if ($create_new_nm_registration->save()) {

    //                 $nmr = NonMemberRegistration::where('UUID', '=', $UUID);
    //                 $img_token = Str::uuid();

    //                 if ($nmr->count() > 0) {
    //                     $nmr = $nmr->first();
    //                     $pet_images = array(
    //                         'Photo' => 'pet_image',
    //                         'SireImage' => 'pet_sire_image',
    //                         'DamImage' => 'pet_dam_image',
    //                         'PetSupportingDocuments' => 'pet_supporting_documents',
    //                         'VetRecordDocuments' => 'pet_vet_record_documents',
    //                         'SireSupportingDocuments' => 'pet_sire_supporting_documents',
    //                         'DamSupportingDocuments' => 'pet_dam_supporting_documents',
    //                     );
    //                     foreach ($pet_images as $key => $val) {
    //                         if ($request->hasFile($val)) {
    //                             $file_count = 1;
    //                             if (is_array($request->file($val))) $file_count = count($request->file($val));

    //                             for ($i = 0; $i < $file_count; $i++) {
    //                                 do {
    //                                     $file_uuid = Str::uuid();
    //                                 } while (StorageFile::where('uuid', '=', $file_uuid)->first()  instanceof StorageFile);

    //                                 $GetStorageFile_data = StorageFile::create([
    //                                     'uuid' => $file_uuid,
    //                                 ]);
    //                                 $gsfd = $GetStorageFile_data;

    //                                 $folderPath = public_path('uploads/pet_registrations/');

    //                                 if (!file_exists($folderPath)) {
    //                                     mkdir($folderPath, 0777, true);
    //                                 }

    //                                 if (is_array($request->file($val))) {
    //                                     $file = $request->file($val)[$i];
    //                                 } else {
    //                                     $file = $request->file($val);
    //                                 }

    //                                 $fileName = uniqid() . '-' . $file_uuid . '.' . $file->getClientOriginalExtension();
    //                                 $imageFullPath = $folderPath . $fileName;

    //                                 $file->move($folderPath, $fileName);

    //                                 $image = 'uploads/pet_registrations/' . $fileName;


    //                                 $gsfd->file_path = $image;
    //                                 $gsfd->file_name = $file->getClientOriginalName();
    //                                 $gsfd->token = $img_token;

    //                                 $nmr->$key = $file_uuid;

    //                                 $gsfd->save();
    //                             }
    //                         }
    //                         $nmr->FileToken = $img_token;
    //                         $nmr->save();
    //                     }
    //                 }
    //             }

    //             return redirect()->back()->with('response', 'dog_added');
    //         } else {
    //             return redirect()->back()->with('response', 'error_dog_add');
    //         }
    //     } else {
    //         return redirect()->back()->with('response', 'not_allowed');
    //     }
    // }
    // /* ADD UNREGISTERED CAT */
    // public function add_cat_unregistered(Request $request)
    // {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = [
    //         '_token',
    //         'pet_petname',
    //         'pet_birthdate',
    //         'pet_eyecolor',
    //         'pet_petcolor',
    //         'pet_markings',
    //         'pet_location',
    //         'pet_gender',
    //         'pet_height',
    //         'pet_weight',

    //         'pet_co_owner',
    //         'pet_microchip_no',
    //         'pet_age',
    //         'pet_vet_name',
    //         'pet_vet_url',
    //         'pet_shelter',
    //         'pet_shelter_url',
    //         'pet_breeder',
    //         'pet_breeder_url',
    //         'pet_sirename',
    //         'pet_sire_breed',
    //         'pet_sireregno',
    //         'pet_damname',
    //         'pet_dam_breed',
    //         'pet_damregno',
    //         'pet_image',
    //         'pet_sire_image',
    //         'pet_dam_image',
    //         'pet_supporting_documents',
    //         'pet_vet_record_documents',
    //         'pet_sire_supporting_documents',
    //         'pet_dam_supporting_documents',
    //     ];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($key_arr as $key => $value) {
    //         if (!$request->has($value)) {
    //             return redirect()->back()->with('response', 'key_error');
    //         }
    //     }

    //     /* VALIDATE INPUTS */
    //     $validate = Validator::make($request->all(),[
    //         'pet_petname' => 'required',
    //         'pet_birthdate' => 'required',
    //         'pet_gender' => 'required',
    //         'pet_location' => 'required',
    //     ],[
    //         'pet_petname.required' => 'Enter pet_petname',
    //         'pet_birthdate.required' => 'Enter pet_birthdate',
    //         'pet_gender.required' => 'Enter pet_gender',
    //         'pet_location.required' => 'Enter pet_location',
    //     ]);

    //     /* THROW ERROR IF VALIDATION FAILED */
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate);
    //     }

    //     if (!empty(Auth::guard('web')->user()->uuid)) {
    //         /* INSERT CAT */
    //         do {
    //             $PetUUID = Str::uuid();
    //         } while (MembersCat::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersCat);

    //         $create_new_cat = MembersCat::create([
    //             'PetUUID' => $PetUUID,
    //             'OwnerUUID' => Auth::guard('web')->user()->uuid,
    //             'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
    //             'PetName' => $request->input('pet_petname'),
    //             'BirthDate' => $request->input('pet_birthdate'),
    //             'EyeColor' => $request->input('pet_eyecolor'),
    //             'PetColor' => $request->input('pet_petcolor'),
    //             'Markings' => $request->input('pet_markings'),
    //             'Location' => $request->input('pet_location'),
    //             'Gender' => $request->input('pet_gender'),
    //             'Height' => $request->input('pet_height'),
    //             'Weight' => $request->input('pet_weight'),
    //         ]);

    //         if ($create_new_cat->save()) {
    //             return redirect()->back()->with('response', 'cat_added');
    //         } else {
    //             return redirect()->back()->with('response', 'error_cat_add');
    //         }
    //     } else {
    //         return redirect()->back()->with('response', 'not_allowed');
    //     }
    // }
    // /* ADD UNREGISTERED RABBIT */
    // public function add_rabbit_unregistered(Request $request)
    // {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = ['_token','pet_petname','pet_eyecolor','pet_petcolor','pet_markings','pet_birthdate','pet_location','pet_gender','pet_height','pet_weight','pet_sirename','pet_damname','pet_breed'];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($key_arr as $key => $value) {
    //         if (!$request->has($value)) {
    //             return redirect()->back()->with('response', 'key_error');
    //         }
    //     }

    //     /* VALIDATE INPUTS */
    //     $validate = Validator::make($request->all(),[
    //         'pet_petname' => 'required',
    //         'pet_birthdate' => 'required',
    //         'pet_gender' => 'required',
    //         'pet_location' => 'required',
    //         'pet_breed' => 'required',
    //     ],[
    //         'pet_petname.required' => 'Enter pet_petname',
    //         'pet_birthdate.required' => 'Enter pet_birthdate',
    //         'pet_gender.required' => 'Enter pet_gender',
    //         'pet_location.required' => 'Enter pet_location',
    //         'pet_breed.required' => 'Enter pet_breed',
    //     ]);

    //     /* THROW ERROR IF VALIDATION FAILED */
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate);
    //     }

    //     if (!empty(Auth::guard('web')->user()->uuid)) {
    //         /* INSERT RABBIT */
    //         do {
    //             $PetUUID = Str::uuid();
    //         } while (MembersRabbit::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersRabbit);

    //         $create_new_rabbit = MembersRabbit::create([
    //             'PetUUID' => $PetUUID,
    //             'OwnerUUID' => Auth::guard('web')->user()->uuid,
    //             'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
    //             'PetName' => $request->input('pet_petname'),
    //             'EyeColor' => $request->input('pet_eyecolor'),
    //             'PetColor' => $request->input('pet_petcolor'),
    //             'Markings' => $request->input('pet_markings'),
    //             'BirthDate' => $request->input('pet_birthdate'),
    //             'Location' => $request->input('pet_location'),
    //             'Gender' => $request->input('pet_gender'),
    //             'Height' => $request->input('pet_height'),
    //             'Weight' => $request->input('pet_weight'),
    //             'SireName' => $request->input('pet_sirename'),
    //             'DamName' => $request->input('pet_damname'),
    //             'Breed' => $request->input('pet_breed'),
    //         ]);

    //         if ($create_new_rabbit->save()) {
    //             return redirect()->back()->with('response', 'rabbit_added');
    //         } else {
    //             return redirect()->back()->with('response', 'error_rabbit_add');
    //         }
    //     } else {
    //         return redirect()->back()->with('response', 'not_allowed');
    //     }
    // }
    // /* ADD UNREGISTERED BIRD */
    // public function add_bird_unregistered(Request $request)
    // {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = ['_token','pet_petname','pet_eyecolor','pet_petcolor','pet_markings','pet_birthdate','pet_location','pet_gender','pet_height','pet_weight'];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($key_arr as $key => $value) {
    //         if (!$request->has($value)) {
    //             return redirect()->back()->with('response', 'key_error');
    //         }
    //     }

    //     /* VALIDATE INPUTS */
    //     $validate = Validator::make($request->all(),[
    //         'pet_petname' => 'required',
    //         'pet_birthdate' => 'required',
    //         'pet_gender' => 'required',
    //         'pet_location' => 'required',
    //     ],[
    //         'pet_petname.required' => 'Enter pet_petname',
    //         'pet_birthdate.required' => 'Enter pet_birthdate',
    //         'pet_gender.required' => 'Enter pet_gender',
    //         'pet_location.required' => 'Enter pet_location',
    //     ]);

    //     /* THROW ERROR IF VALIDATION FAILED */
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate);
    //     }

    //     if (!empty(Auth::guard('web')->user()->uuid)) {
    //         /* INSERT BIRD */
    //         do {
    //             $PetUUID = Str::uuid();
    //         } while (MembersBird::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersBird);

    //         $create_new_bird = MembersBird::create([
    //             'PetUUID' => $PetUUID,
    //             'OwnerUUID' => Auth::guard('web')->user()->uuid,
    //             'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
    //             'PetName' => $request->input('pet_petname'),
    //             'EyeColor' => $request->input('pet_eyecolor'),
    //             'PetColor' => $request->input('pet_petcolor'),
    //             'Markings' => $request->input('pet_markings'),
    //             'BirthDate' => $request->input('pet_birthdate'),
    //             'Location' => $request->input('pet_location'),
    //             'Gender' => $request->input('pet_gender'),
    //             'Height' => $request->input('pet_height'),
    //             'Weight' => $request->input('pet_weight'),
    //         ]);

    //         if ($create_new_bird->save()) {
    //             return redirect()->back()->with('response', 'bird_added');
    //         } else {
    //             return redirect()->back()->with('response', 'error_bird_add');
    //         }
    //     } else {
    //         return redirect()->back()->with('response', 'not_allowed');
    //     }
    // }
    // /* ADD UNREGISTERED OTHER ANIMAL */
    // public function add_other_animal_unregistered(Request $request)
    // {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = ['_token','pet_petname','pet_animaltype','pet_commonname','pet_familystrain','pet_sizelength','pet_sizewidth','pet_sizeheight','pet_weight','pet_colormarking'];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($key_arr as $key => $value) {
    //         if (!$request->has($value)) {
    //             return redirect()->back()->with('response', 'key_error');
    //         }
    //     }

    //     /* VALIDATE INPUTS */
    //     $validate = Validator::make($request->all(),[
    //         'pet_petname' => 'required',
    //         'pet_animaltype' => 'required',
    //         'pet_commonname' => 'required',
    //         'pet_familystrain' => 'required',
    //     ],[
    //         'pet_petname.required' => 'Enter pet_petname',
    //         'pet_animaltype.required' => 'Enter pet_animaltype',
    //         'pet_commonname.required' => 'Enter pet_commonname',
    //         'pet_familystrain.required' => 'Enter pet_familystrain',
    //     ]);

    //     /* THROW ERROR IF VALIDATION FAILED */
    //     if ($validate->fails()) {
    //         return redirect()->back()->withErrors($validate);
    //     }

    //     if (!empty(Auth::guard('web')->user()->uuid)) {
    //         /* INSERT OTHER */
    //         do {
    //             $PetUUID = Str::uuid();
    //         } while (MembersOtherAnimal::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersOtherAnimal);

    //         $create_new_other_animal = MembersOtherAnimal::create([
    //             'PetUUID' => $PetUUID,
    //             'OwnerUUID' => Auth::guard('web')->user()->uuid,
    //             'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
    //             'PetName' => $request->input('pet_petname'),
    //             'AnimalType' => $request->input('pet_animaltype'),
    //             'CommonName' => $request->input('pet_commonname'),
    //             'FamilyStrain' => $request->input('pet_familystrain'),
    //             'SizeLength' => $request->input('pet_sizelength'),
    //             'SizeWidth' => $request->input('pet_sizewidth'),
    //             'SizeHeight' => $request->input('pet_sizeheight'),
    //             'Weight' => $request->input('pet_weight'),
    //             'ColorMarking' => $request->input('pet_colormarking'),
    //         ]);

    //         if ($create_new_other_animal->save()) {
    //             return redirect()->back()->with('response', 'other_animal_added');
    //         } else {
    //             return redirect()->back()->with('response', 'error_other_animal_add');
    //         }
    //     } else {
    //         return redirect()->back()->with('response', 'not_allowed');
    //     }
    // }



    /* UNREGISTERED PETS */
    public function add_pet_unregistered(Request $request)
    {
        if (!empty(Auth::guard('web')->user()->uuid)) {
            if ($request->input('pet_type') == 'dog') {
                /* STORE KEYS TO ARRAY */
                $key_arr = [
                    'pet_petname',
                    'pet_birthdate',
                    'pet_gender',
                    'pet_location',
                    'pet_breed',
                    'pet_markings',
                    'pet_petcolor',
                    'pet_eyecolor',
                    'pet_height',
                    'pet_weight',
                    'pet_co_owner',
                ];

                /* VALIDATE INPUTS */
                $validate_vars = [
                    'pet_petname' => 'required',
                    'pet_birthdate' => 'required',
                    'pet_gender' => 'required',
                    'pet_breed' => 'required',
                ];
                $validate_messages = [
                    'pet_petname.required' => 'Pet name is required.',
                    'pet_birthdate.required' => 'Birth date is required.',
                    'pet_gender.required' => 'Gender is required.',
                    'pet_breed.required' => 'Pet breed is required.',
                ];
            } elseif ($request->input('pet_type') == 'cat') {
                /* STORE KEYS TO ARRAY */
                $key_arr = [
                    'pet_petname',
                    'pet_birthdate',
                    'pet_eyecolor',
                    'pet_petcolor',
                    'pet_markings',
                    'pet_location',
                    'pet_gender',
                    'pet_height',
                    'pet_weight',
                ];

                /* VALIDATE INPUTS */
                $validate_vars = [
                    'pet_petname' => 'required',
                    'pet_birthdate' => 'required',
                    'pet_gender' => 'required',
                    'pet_location' => 'required',
                ];
                $validate_messages = [
                    'pet_petname.required' => 'Pet name is required.',
                    'pet_birthdate.required' => 'Birth date is required.',
                    'pet_gender.required' => 'Gender is required.',
                    'pet_location.required' => 'Location is required',
                ];
            } elseif ($request->input('pet_type') == 'rabbit') {
                /* STORE KEYS TO ARRAY */
                $key_arr = [
                    'pet_petname',
                    'pet_eyecolor',
                    'pet_petcolor',
                    'pet_markings',
                    'pet_birthdate',
                    'pet_location',
                    'pet_gender',
                    'pet_height',
                    'pet_weight',
                    'pet_breed',
                ];

                /* VALIDATE INPUTS */
                $validate_vars = [
                    'pet_petname' => 'required',
                    'pet_birthdate' => 'required',
                    'pet_gender' => 'required',
                    'pet_location' => 'required',
                    'pet_breed' => 'required',
                ];
                $validate_messages = [
                    'pet_petname.required' => 'Pet name is required.',
                    'pet_birthdate.required' => 'Birth date is required.',
                    'pet_gender.required' => 'Gender is required.',
                    'pet_location.required' => 'Location is required',
                    'pet_breed.required' => 'Pet breed is required.',
                ];
            } elseif ($request->input('pet_type') == 'bird') {
                /* STORE KEYS TO ARRAY */
                $key_arr = [
                    'pet_petname',
                    'pet_eyecolor',
                    'pet_petcolor',
                    'pet_markings',
                    'pet_birthdate',
                    'pet_location',
                    'pet_gender',
                    'pet_height',
                    'pet_weight',
                ];

                /* VALIDATE INPUTS */
                $validate_vars = [
                    'pet_petname' => 'required',
                    'pet_birthdate' => 'required',
                    'pet_gender' => 'required',
                    'pet_location' => 'required',
                ];
                $validate_messages = [
                    'pet_petname.required' => 'Pet name is required.',
                    'pet_birthdate.required' => 'Birth date is required.',
                    'pet_gender.required' => 'Gender is required.',
                    'pet_location.required' => 'Location is required',
                ];
            } elseif ($request->input('pet_type') == 'other') {
                /* STORE KEYS TO ARRAY */
                $key_arr = [
                    'pet_petname',
                    'pet_animaltype',
                    'pet_commonname',
                    'pet_familystrain',
                    'pet_sizelength',
                    'pet_sizewidth',
                    'pet_sizeheight',
                    'pet_weight',
                    'pet_colormarking',
                ];
                /* VALIDATE INPUTS */
                $validate_vars = [
                    'pet_petname' => 'required',
                    'pet_animaltype' => 'required',
                    'pet_commonname' => 'required',
                    'pet_familystrain' => 'required',
                ];
                $validate_messages = [
                    'pet_petname.required' => 'Pet name is required.',
                    'pet_animaltype.required' => 'Enter animal type',
                    'pet_commonname.required' => 'Enter common name',
                    'pet_familystrain.required' => 'Enter family strain',
                ];
            }

            /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
            $key_arr_adtl_info = [
                'pet_microchip_no',
                'pet_age',
                // 'pet_vet_name',
                // 'pet_vet_url',
                // 'pet_shelter',
                // 'pet_shelter_url',
                // 'pet_breeder',
                // 'pet_breeder_url',
                // 'pet_sirename',
                // 'pet_sire_breed',
                // 'pet_sireregno',
                // 'pet_damname',
                // 'pet_dam_breed',
                // 'pet_damregno',
                // 'pet_image',
                // 'pet_sire_image',
                // 'pet_dam_image',
                // 'pet_supporting_documents',
                // 'pet_vet_record_documents',
                // 'pet_sire_supporting_documents',
                // 'pet_dam_supporting_documents',
            ];
            $key_arr = array_merge($key_arr, $key_arr_adtl_info);

            foreach ($key_arr as $key => $value) {
                if (!$request->has($value)
                    //  && $value != 'pet_image'
                    //  && $value != 'pet_sire_image'
                    //  && $value != 'pet_dam_image'
                    //  && $value != 'pet_supporting_documents'
                    //  && $value != 'pet_vet_record_documents'
                    //  && $value != 'pet_sire_supporting_documents'
                    //  && $value != 'pet_dam_supporting_documents'
                    ) {
                    return redirect()->back()->with('response', 'key_error');
                }
            }

            /* THROW ERROR IF VALIDATION FAILED */
            // $validate_vars_registration_contact = [
            //     'pet_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            //     'pet_sire_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            //     'pet_dam_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            //     'pet_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            //     'pet_vet_record_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            //     'pet_sire_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            //     'pet_dam_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            // ];
            // $validate_vars = array_merge($validate_vars, $validate_vars_registration_contact);

            // $validate_messages_registration_contact = [
            //     'pet_image.image' => 'Uploaded pet photo is not an image.',
            //     'pet_image.mimes' => 'Acceptable pet photo format is jpg, png, jpeg, or gif.',
            //     'pet_image.max' => 'Uploaded image must be smaller than 10MB.',
            //     'pet_sire_image.image' => 'Uploaded sire image is not an image.',
            //     'pet_sire_image.mimes' => 'Acceptable sire image format is jpg, png, jpeg, or gif.',
            //     'pet_sire_image.max' => 'Uploaded image must be smaller than 10MB.',
            //     'pet_dam_image.image' => 'Uploaded dam image is not an image.',
            //     'pet_dam_image.mimes' => 'Acceptable dam image format is jpg, png, jpeg, or gif.',
            //     'pet_dam_image.max' => 'Uploaded image must be smaller than 10MB.',

            //     'pet_supporting_documents.file' => 'Uploaded pet supporting document is not a file.',
            //     'pet_supporting_documents.mimes' => 'Supported file types for pet supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            //     'pet_supporting_documents.max' => 'Uploaded pet supporting document must be smaller than 5MB.',
            //     'pet_vet_record_documents.file' => 'Uploaded vet record document is not a file.',
            //     'pet_vet_record_documents.mimes' => 'Supported file types for vet record document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            //     'pet_vet_record_documents.max' => 'Uploaded vet record document must be smaller than 5MB.',
            //     'pet_sire_supporting_documents.file' => 'Uploaded sire supporting document is not a file.',
            //     'pet_sire_supporting_documents.mimes' => 'Supported file types for sire supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            //     'pet_sire_supporting_documents.max' => 'Uploaded sire supporting document must be smaller than 5MB.',
            //     'pet_dam_supporting_documents.file' => 'Uploaded dam supporting document is not a file.',
            //     'pet_dam_supporting_documents.mimes' => 'Supported file types for dam supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            //     'pet_dam_supporting_documents.max' => 'Uploaded dam supporting document must be smaller than 5MB.',
            // ];
            // $validate_messages = array_merge($validate_messages, $validate_messages_registration_contact);

            $validate = Validator::make($request->all(),$validate_vars,$validate_messages);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }

            if ($request->input('pet_type') == 'dog') {
                /* INSERT DOG */
                do {
                    $PetUUID = Str::uuid();
                } while (MembersDog::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersDog);

                $create_new_pet = MembersDog::create([
                    'PetUUID' => $PetUUID,
                    'OwnerUUID' => Auth::guard('web')->user()->uuid,
                    'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
                    'DateAdded' => Carbon::now(),

                    'PetName' => $request->input('pet_petname'),
                    'BirthDate' => $request->input('pet_birthdate'),
                    'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                    'Location' => $request->input('pet_location'),
                    'Breed' => $request->input('pet_breed'),
                    'Breeder' => $request->input('pet_breeder'),
                    'Markings' => $request->input('pet_markings'),
                    'PetColor' => $request->input('pet_petcolor'),
                    'EyeColor' => $request->input('pet_eyecolor'),
                    'Height' => $request->input('pet_height'),
                    'Weight' => $request->input('pet_weight'),
                    'SireName' => $request->input('pet_sirename'),
                    'DamName' => $request->input('pet_damname'),
                    'Co_Owner' => $request->input('pet_co_owner'),

                    'Status' => 4, // for pet verification
                ]);
            } elseif ($request->input('pet_type') == 'cat') {
                /* INSERT CAT */
                do {
                    $PetUUID = Str::uuid();
                } while (MembersCat::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersCat);

                $create_new_pet = MembersCat::create([
                    'PetUUID' => $PetUUID,
                    'OwnerUUID' => Auth::guard('web')->user()->uuid,
                    'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
                    'DateAdded' => Carbon::now(),

                    'PetName' => $request->input('pet_petname'),
                    'BirthDate' => $request->input('pet_birthdate'),
                    'EyeColor' => $request->input('pet_eyecolor'),
                    'PetColor' => $request->input('pet_petcolor'),
                    'Markings' => $request->input('pet_markings'),
                    'Location' => $request->input('pet_location'),
                    'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                    'Height' => $request->input('pet_height'),
                    'Weight' => $request->input('pet_weight'),
                    'Co_Owner' => $request->input('pet_co_owner'),

                    'Status' => 4, // for pet verification
                ]);
            } elseif ($request->input('pet_type') == 'rabbit') {
                /* INSERT RABBIT */
                do {
                    $PetUUID = Str::uuid();
                } while (MembersRabbit::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersRabbit);

                $create_new_pet = MembersRabbit::create([
                    'PetUUID' => $PetUUID,
                    'OwnerUUID' => Auth::guard('web')->user()->uuid,
                    'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
                    'DateAdded' => Carbon::now(),

                    'PetName' => $request->input('pet_petname'),
                    'EyeColor' => $request->input('pet_eyecolor'),
                    'PetColor' => $request->input('pet_petcolor'),
                    'Markings' => $request->input('pet_markings'),
                    'BirthDate' => $request->input('pet_birthdate'),
                    'Location' => $request->input('pet_location'),
                    'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                    'Height' => $request->input('pet_height'),
                    'Weight' => $request->input('pet_weight'),
                    'SireName' => $request->input('pet_sirename'),
                    'DamName' => $request->input('pet_damname'),
                    'Breed' => $request->input('pet_breed'),
                    'Co_Owner' => $request->input('pet_co_owner'),

                    'Status' => 4, // for pet verification
                ]);
            } elseif ($request->input('pet_type') == 'bird') {
                /* INSERT BIRD */
                do {
                    $PetUUID = Str::uuid();
                } while (MembersBird::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersBird);

                $create_new_pet = MembersBird::create([
                    'PetUUID' => $PetUUID,
                    'OwnerUUID' => Auth::guard('web')->user()->uuid,
                    'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
                    'DateAdded' => Carbon::now(),

                    'PetName' => $request->input('pet_petname'),
                    'EyeColor' => $request->input('pet_eyecolor'),
                    'PetColor' => $request->input('pet_petcolor'),
                    'Markings' => $request->input('pet_markings'),
                    'BirthDate' => $request->input('pet_birthdate'),
                    'Location' => $request->input('pet_location'),
                    'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                    'Height' => $request->input('pet_height'),
                    'Weight' => $request->input('pet_weight'),
                    'Co_Owner' => $request->input('pet_co_owner'),

                    'Status' => 4, // for pet verification
                ]);
            } elseif ($request->input('pet_type') == 'other') {
                /* INSERT OTHER */
                do {
                    $PetUUID = Str::uuid();
                } while (MembersOtherAnimal::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersOtherAnimal);

                $create_new_pet = MembersOtherAnimal::create([
                    'PetUUID' => $PetUUID,
                    'OwnerUUID' => Auth::guard('web')->user()->uuid,
                    'OwnerIAGDNo' => Auth::guard('web')->user()->iagd_number,
                    'DateAdded' => Carbon::now(),

                    'PetName' => $request->input('pet_petname'),
                    'AnimalType' => $request->input('pet_animaltype'),
                    'CommonName' => $request->input('pet_commonname'),
                    'FamilyStrain' => $request->input('pet_familystrain'),
                    'SizeLength' => $request->input('pet_sizelength'),
                    'SizeWidth' => $request->input('pet_sizewidth'),
                    'SizeHeight' => $request->input('pet_sizeheight'),
                    'Weight' => $request->input('pet_weight'),
                    'ColorMarking' => $request->input('pet_colormarking'),
                    'Co_Owner' => $request->input('pet_co_owner'),

                    'Status' => 4, // for pet verification
                ]);
            }


            if ($create_new_pet->save()) {

                /* CREATE REGISTRATION */
                do {
                    $UUID = Str::uuid();
                } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                $create_new_nm_registration = NonMemberRegistration::create([
                    'UUID' => $UUID,

                    'MicrochipNo' => $request->input('pet_microchip_no'),
                    'AgeInMonths' => $request->input('pet_age'),
                    // 'VetClinicName' => $request->input('pet_vet_name'),
                    // 'VetOnlineProfile' => $request->input('pet_vet_url'),
                    // 'ShelterInfo' => $request->input('pet_shelter'),
                    // 'ShelterOnlineProfile' => $request->input('pet_shelter_url'),
                    // 'BreederInfo' => $request->input('pet_breeder'),
                    // 'BreederOnlineProfile' => $request->input('pet_breeder_url'),
                    // 'SireName' => $request->input('pet_sirename'),
                    // 'SireBreed' => $request->input('pet_sire_breed'),
                    // 'SireRegNo' => $request->input('pet_sireregno'),
                    // 'DamName' => $request->input('pet_damname'),
                    // 'DamBreed' => $request->input('pet_dam_breed'),
                    // 'DamRegNo' => $request->input('pet_damregno'),

                    'Type' => $request->input('pet_type'),
                    'PetUUID' => $PetUUID,
                ]);

                // UPLOAD IMAGE TO ML STORAGE
                if ($create_new_nm_registration->save()) {

                    // $nmr = NonMemberRegistration::where('UUID', '=', $UUID);
                    // $img_token = Str::uuid();

                    // if ($nmr->count() > 0) {
                    //     $nmr = $nmr->first();
                    //     $pet_images = array(
                    //         'Photo' => 'pet_image',
                    //         'SireImage' => 'pet_sire_image',
                    //         'DamImage' => 'pet_dam_image',
                    //         'PetSupportingDocuments' => 'pet_supporting_documents',
                    //         'VetRecordDocuments' => 'pet_vet_record_documents',
                    //         'SireSupportingDocuments' => 'pet_sire_supporting_documents',
                    //         'DamSupportingDocuments' => 'pet_dam_supporting_documents',
                    //     );
                    //     foreach ($pet_images as $key => $val) {
                    //         if ($request->hasFile($val)) {
                    //             $file_count = 1;
                    //             if (is_array($request->file($val))) $file_count = count($request->file($val));

                    //             for ($i = 0; $i < $file_count; $i++) {
                    //                 do {
                    //                     $file_uuid = Str::uuid();
                    //                 } while (StorageFile::where('uuid', '=', $file_uuid)->first()  instanceof StorageFile);

                    //                 $GetStorageFile_data = StorageFile::create([
                    //                     'uuid' => $file_uuid,
                    //                 ]);
                    //                 $gsfd = $GetStorageFile_data;

                    //                 $folderPath = public_path('uploads/pet_registrations/');

                    //                 if (!file_exists($folderPath)) {
                    //                     mkdir($folderPath, 0777, true);
                    //                 }

                    //                 if (is_array($request->file($val))) {
                    //                     $file = $request->file($val)[$i];
                    //                 } else {
                    //                     $file = $request->file($val);
                    //                 }

                    //                 $fileName = uniqid() . '-' . $file_uuid . '.' . $file->getClientOriginalExtension();
                    //                 $imageFullPath = $folderPath . $fileName;

                    //                 $file->move($folderPath, $fileName);

                    //                 $image = 'uploads/pet_registrations/' . $fileName;


                    //                 $gsfd->file_path = $image;
                    //                 $gsfd->file_name = $file->getClientOriginalName();
                    //                 $gsfd->token = $img_token;

                    //                 $nmr->$key = $file_uuid;

                    //                 $gsfd->save();
                    //             }
                    //         }
                    //         $nmr->FileToken = $img_token;
                    //         $nmr->save();
                    //     }
                    // }


                    return redirect()->back()->with('response', 'pet_added');
                }
                else
                {
                    return redirect()->back()->with('response', 'error_pet_add');
                }
            }
            else
            {
                return redirect()->back()->with('response', 'error_pet_add');
            }
        } else {
            return redirect()->back()->with('response', 'not_allowed');
        }
    }

    /* NON-USER REGISTER PET */
    public function register_pet(Request $request)
    {
        if ($request->input('pet_type') == 'dog') {
            /* STORE KEYS TO ARRAY */
            $key_arr = [
                'pet_petname',
                'pet_birthdate',
                'pet_gender',
                'pet_location',
                'pet_breed',
                'pet_breeder',
                'pet_markings',
                'pet_petcolor',
                'pet_eyecolor',
                'pet_height',
                'pet_weight',
                'pet_co_owner',
            ];

            /* VALIDATE INPUTS */
            $validate_vars = [
                'pet_petname' => 'required',
                'pet_birthdate' => 'required',
                'pet_gender' => 'required',
                'pet_breed' => 'required',
            ];
            $validate_messages = [
                'pet_petname.required' => 'Pet name is required.',
                'pet_birthdate.required' => 'Birth date is required.',
                'pet_gender.required' => 'Gender is required.',
                'pet_breed.required' => 'Pet breed is required.',
            ];
        } elseif ($request->input('pet_type') == 'cat') {
            /* STORE KEYS TO ARRAY */
            $key_arr = [
                'pet_petname',
                'pet_birthdate',
                'pet_eyecolor',
                'pet_petcolor',
                'pet_markings',
                'pet_location',
                'pet_gender',
                'pet_height',
                'pet_weight',
            ];

            /* VALIDATE INPUTS */
            $validate_vars = [
                'pet_petname' => 'required',
                'pet_birthdate' => 'required',
                'pet_gender' => 'required',
                'pet_location' => 'required',
            ];
            $validate_messages = [
                'pet_petname.required' => 'Enter petname',
                'pet_birthdate.required' => 'Enter birthdate',
                'pet_gender.required' => 'Enter gender',
                'pet_location.required' => 'Enter location',
            ];
        } elseif ($request->input('pet_type') == 'rabbit') {
            /* STORE KEYS TO ARRAY */
            $key_arr = [
                'pet_petname',
                'pet_eyecolor',
                'pet_petcolor',
                'pet_markings',
                'pet_birthdate',
                'pet_location',
                'pet_gender',
                'pet_height',
                'pet_weight',
                'pet_breed',
            ];

            /* VALIDATE INPUTS */
            $validate_vars = [
                'pet_petname' => 'required',
                'pet_birthdate' => 'required',
                'pet_gender' => 'required',
                'pet_location' => 'required',
                'pet_breed' => 'required',
            ];
            $validate_messages = [
                'pet_petname.required' => 'Enter petname',
                'pet_birthdate.required' => 'Enter birthdate',
                'pet_gender.required' => 'Enter gender',
                'pet_location.required' => 'Enter location',
                'pet_breed.required' => 'Enter breed',
            ];
        } elseif ($request->input('pet_type') == 'bird') {
            /* STORE KEYS TO ARRAY */
            $key_arr = [
                'pet_petname',
                'pet_eyecolor',
                'pet_petcolor',
                'pet_markings',
                'pet_birthdate',
                'pet_location',
                'pet_gender',
                'pet_height',
                'pet_weight',
            ];

            /* VALIDATE INPUTS */
            $validate_vars = [
                'pet_petname' => 'required',
                'pet_birthdate' => 'required',
                'pet_gender' => 'required',
                'pet_location' => 'required',
            ];
            $validate_messages = [
                'pet_petname.required' => 'Enter petname',
                'pet_birthdate.required' => 'Enter birthdate',
                'pet_gender.required' => 'Enter gender',
                'pet_location.required' => 'Enter location',
            ];
        } elseif ($request->input('pet_type') == 'other') {
            /* STORE KEYS TO ARRAY */
            $key_arr = [
                'pet_petname',
                'pet_animaltype',
                'pet_commonname',
                'pet_familystrain',
                'pet_sizelength',
                'pet_sizewidth',
                'pet_sizeheight',
                'pet_weight',
                'pet_colormarking',
            ];
            /* VALIDATE INPUTS */
            $validate_vars = [
                'pet_petname' => 'required',
                'pet_animaltype' => 'required',
                'pet_commonname' => 'required',
                'pet_familystrain' => 'required',
            ];
            $validate_messages = [
                'pet_petname.required' => 'Enter petname',
                'pet_animaltype.required' => 'Enter animaltype',
                'pet_commonname.required' => 'Enter commonname',
                'pet_familystrain.required' => 'Enter familystrain',
            ];

        }

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        $key_arr_registration_contact = [
            'full_name',
            'contact_number',
            'email_address',
            'facebook_page',
        ];
        $key_arr_adtl_info = [
            'pet_microchip_no',
            'pet_age',
            'pet_vet_name',
            'pet_vet_url',
            'pet_shelter',
            'pet_shelter_url',
            'pet_breeder',
            'pet_breeder_url',
            'pet_sirename',
            'pet_sire_breed',
            'pet_sireregno',
            'pet_damname',
            'pet_dam_breed',
            'pet_damregno',
            'pet_image',
            'pet_sire_image',
            'pet_dam_image',
            'pet_supporting_documents',
            'pet_vet_record_documents',
            'pet_sire_supporting_documents',
            'pet_dam_supporting_documents',
        ];
        $key_arr = array_merge($key_arr, $key_arr_registration_contact);
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents') {
                $data = [
                    'custom_alert' => 'error',
                    'status' => 'key_error',
                    'message' => 'Something\'s wrong, Please refresh the page.',
                    'redirecToUrl' => route('user.pet_registration_form')
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

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
            'full_name' => 'required',
            'contact_number' => 'required|numeric|digits:11',
            // 'email_address' => 'required',
            'pet_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            'pet_sire_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            'pet_dam_image' => 'image|mimes:jpg,png,jpeg,gif|max:10240',
            'pet_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            'pet_vet_record_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            'pet_sire_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
            'pet_dam_supporting_documents' => 'file|mimes:doc,docx,html,htm,odt,pdf,xls,xlsx,ods,txt|max:5120',
        ];
        $validate_vars = array_merge($validate_vars, $validate_vars_registration_contact);

        $validate_messages_registration_contact = [
            'full_name.required' => 'Enter full name.',
            'contact_number.required' => 'Enter contact number.',
            'contact_number.numeric' => 'Please enter valid contact number. (09xxxxxxxxx)',
            'contact_number.digits' => 'Please enter valid contact number. (11 digits)',
            // 'email_address.required' => 'Enter email address',
            'facebook_page.required' => 'Enter facebook page.',
            'pet_image.image' => 'Uploaded pet photo is not an image.',
            'pet_image.mimes' => 'Acceptable pet photo format is jpg, png, jpeg, or gif.',
            'pet_image.max' => 'Uploaded image must be smaller than 10MB.',
            'pet_sire_image.image' => 'Uploaded sire image is not an image.',
            'pet_sire_image.mimes' => 'Acceptable sire image format is jpg, png, jpeg, or gif.',
            'pet_sire_image.max' => 'Uploaded image must be smaller than 10MB.',
            'pet_dam_image.image' => 'Uploaded dam image is not an image.',
            'pet_dam_image.mimes' => 'Acceptable dam image format is jpg, png, jpeg, or gif.',
            'pet_dam_image.max' => 'Uploaded image must be smaller than 10MB.',

            'pet_supporting_documents.file' => 'Uploaded pet supporting document is not a file.',
            'pet_supporting_documents.mimes' => 'Supported file types for pet supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            'pet_supporting_documents.max' => 'Uploaded pet supporting document must be smaller than 5MB.',
            'pet_vet_record_documents.file' => 'Uploaded vet record document is not a file.',
            'pet_vet_record_documents.mimes' => 'Supported file types for vet record document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            'pet_vet_record_documents.max' => 'Uploaded vet record document must be smaller than 5MB.',
            'pet_sire_supporting_documents.file' => 'Uploaded sire supporting document is not a file.',
            'pet_sire_supporting_documents.mimes' => 'Supported file types for sire supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            'pet_sire_supporting_documents.max' => 'Uploaded sire supporting document must be smaller than 5MB.',
            'pet_dam_supporting_documents.file' => 'Uploaded dam supporting document is not a file.',
            'pet_dam_supporting_documents.mimes' => 'Supported file types for dam supporting document are [doc, docx, html, htm, odt, pdf, xls, xlsx, ods, txt].',
            'pet_dam_supporting_documents.max' => 'Uploaded dam supporting document must be smaller than 5MB.',
        ];
        $validate_messages = array_merge($validate_messages, $validate_messages_registration_contact);

        $validate = Validator::make($request->all(),$validate_vars,$validate_messages);
        if ($validate->fails()) {
            $data = [
                'custom_alert' => 'error',
                'status' => 'validation_error',
                'message' => $validate->errors()->first(),
                'redirecToUrl' => route('user.pet_registration_form')
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
            else
            {
                return redirect()->back()->withInput()->with($data);
            }
        }

        if ($request->input('pet_type') == 'dog') {
            /* INSERT DOG */
            do {
                $PetUUID = Str::uuid();
            } while (MembersDog::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersDog);

            $create_new_pet = MembersDog::create([
                'PetUUID' => $PetUUID,
                'PetName' => $request->input('pet_petname'),
                'BirthDate' => $request->input('pet_birthdate'),
                'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                'Location' => $request->input('pet_location'),
                'Breed' => $request->input('pet_breed'),
                'Breeder' => $request->input('pet_breeder'),
                'Markings' => $request->input('pet_markings'),
                'PetColor' => $request->input('pet_petcolor'),
                'EyeColor' => $request->input('pet_eyecolor'),
                'Height' => $request->input('pet_height'),
                'Weight' => $request->input('pet_weight'),
                'SireName' => $request->input('pet_sirename'),
                'DamName' => $request->input('pet_damname'),
                'Co_Owner' => $request->input('pet_co_owner'),

                'non_member' => '1',
            ]);
        } elseif ($request->input('pet_type') == 'cat') {
            /* INSERT CAT */
            do {
                $PetUUID = Str::uuid();
            } while (MembersCat::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersCat);

            $create_new_pet = MembersCat::create([
                'PetUUID' => $PetUUID,
                'PetName' => $request->input('pet_petname'),
                'BirthDate' => $request->input('pet_birthdate'),
                'EyeColor' => $request->input('pet_eyecolor'),
                'PetColor' => $request->input('pet_petcolor'),
                'Markings' => $request->input('pet_markings'),
                'Location' => $request->input('pet_location'),
                'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                'Height' => $request->input('pet_height'),
                'Weight' => $request->input('pet_weight'),
                'Co_Owner' => $request->input('pet_co_owner'),

                'non_member' => '1',
            ]);
        } elseif ($request->input('pet_type') == 'rabbit') {
            /* INSERT RABBIT */
            do {
                $PetUUID = Str::uuid();
            } while (MembersRabbit::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersRabbit);

            $create_new_pet = MembersRabbit::create([
                'PetUUID' => $PetUUID,
                'PetName' => $request->input('pet_petname'),
                'EyeColor' => $request->input('pet_eyecolor'),
                'PetColor' => $request->input('pet_petcolor'),
                'Markings' => $request->input('pet_markings'),
                'BirthDate' => $request->input('pet_birthdate'),
                'Location' => $request->input('pet_location'),
                'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                'Height' => $request->input('pet_height'),
                'Weight' => $request->input('pet_weight'),
                'SireName' => $request->input('pet_sirename'),
                'DamName' => $request->input('pet_damname'),
                'Breed' => $request->input('pet_breed'),
                'Co_Owner' => $request->input('pet_co_owner'),

                'non_member' => '1',
            ]);
        } elseif ($request->input('pet_type') == 'bird') {
            /* INSERT BIRD */
            do {
                $PetUUID = Str::uuid();
            } while (MembersBird::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersBird);

            $create_new_pet = MembersBird::create([
                'PetUUID' => $PetUUID,
                'PetName' => $request->input('pet_petname'),
                'EyeColor' => $request->input('pet_eyecolor'),
                'PetColor' => $request->input('pet_petcolor'),
                'Markings' => $request->input('pet_markings'),
                'BirthDate' => $request->input('pet_birthdate'),
                'Location' => $request->input('pet_location'),
                'Gender' => ($request->input('pet_gender') == 0 ? 'male' : 'female'),
                'Height' => $request->input('pet_height'),
                'Weight' => $request->input('pet_weight'),
                'Co_Owner' => $request->input('pet_co_owner'),

                'non_member' => '1',
            ]);
        } elseif ($request->input('pet_type') == 'other') {
            /* INSERT OTHER */
            do {
                $PetUUID = Str::uuid();
            } while (MembersOtherAnimal::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersOtherAnimal);

            $create_new_pet = MembersOtherAnimal::create([
                'PetUUID' => $PetUUID,
                'PetName' => $request->input('pet_petname'),
                'AnimalType' => $request->input('pet_animaltype'),
                'CommonName' => $request->input('pet_commonname'),
                'FamilyStrain' => $request->input('pet_familystrain'),
                'SizeLength' => $request->input('pet_sizelength'),
                'SizeWidth' => $request->input('pet_sizewidth'),
                'SizeHeight' => $request->input('pet_sizeheight'),
                'Weight' => $request->input('pet_weight'),
                'ColorMarking' => $request->input('pet_colormarking'),
                'Co_Owner' => $request->input('pet_co_owner'),

                'non_member' => '1',
            ]);
        }


        if ($create_new_pet->save()) {

            /* CREATE REGISTRATION */
            do {
                $UUID = Str::uuid();
            } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

            $create_new_nm_registration = NonMemberRegistration::create([
                'UUID' => $UUID,
                'FullName' => $request->input('full_name'),
                'ContactNumber' => $request->input('contact_number'),
                'EmailAddress' => $request->input('email_address'),
                'FacebookPage' => $request->input('facebook_page'),

                'MicrochipNo' => $request->input('pet_microchip_no'),
                'AgeInMonths' => $request->input('pet_age'),
                'VetClinicName' => $request->input('pet_vet_name'),
                'VetOnlineProfile' => $request->input('pet_vet_url'),
                'ShelterInfo' => $request->input('pet_shelter'),
                'ShelterOnlineProfile' => $request->input('pet_shelter_url'),
                'BreederInfo' => $request->input('pet_breeder'),
                'BreederOnlineProfile' => $request->input('pet_breeder_url'),
                'SireName' => $request->input('pet_sirename'),
                'SireBreed' => $request->input('pet_sire_breed'),
                'SireRegNo' => $request->input('pet_sireregno'),
                'DamName' => $request->input('pet_damname'),
                'DamBreed' => $request->input('pet_dam_breed'),
                'DamRegNo' => $request->input('pet_damregno'),

                'Type' => $request->input('pet_type'),
                'PetUUID' => $PetUUID,
            ]);

            // UPLOAD IMAGE TO ML STORAGE
            if ($create_new_nm_registration->save()) {

                $nmr = NonMemberRegistration::where('UUID', '=', $UUID);
                $img_token = Str::uuid();

                if ($nmr->count() > 0) {
                    $nmr = $nmr->first();
                    $pet_images = array(
                        'Photo' => 'pet_image',
                        'SireImage' => 'pet_sire_image',
                        'DamImage' => 'pet_dam_image',
                        'PetSupportingDocuments' => 'pet_supporting_documents',
                        'VetRecordDocuments' => 'pet_vet_record_documents',
                        'SireSupportingDocuments' => 'pet_sire_supporting_documents',
                        'DamSupportingDocuments' => 'pet_dam_supporting_documents',
                    );
                    foreach ($pet_images as $key => $val) {
                        if ($request->hasFile($val)) {
                            $file_count = 1;
                            if (is_array($request->file($val))) $file_count = count($request->file($val));

                            for ($i = 0; $i < $file_count; $i++) {
                                do {
                                    $file_uuid = Str::uuid();
                                } while (StorageFile::where('uuid', '=', $file_uuid)->first()  instanceof StorageFile);

                                $GetStorageFile_data = StorageFile::create([
                                    'uuid' => $file_uuid,
                                ]);
                                $gsfd = $GetStorageFile_data;

                                $folderPath = public_path('uploads/pet_registrations/');

                                if (!file_exists($folderPath)) {
                                    mkdir($folderPath, 0777, true);
                                }

                                if (is_array($request->file($val))) {
                                    $file = $request->file($val)[$i];
                                } else {
                                    $file = $request->file($val);
                                }

                                $fileName = uniqid() . '-' . $file_uuid . '.' . $file->getClientOriginalExtension();
                                $imageFullPath = $folderPath . $fileName;

                                $file->move($folderPath, $fileName);

                                $image = 'uploads/pet_registrations/' . $fileName;


                                $gsfd->file_path = $image;
                                $gsfd->file_name = $file->getClientOriginalName();
                                $gsfd->token = $img_token;

                                $nmr->$key = $file_uuid;

                                $gsfd->save();
                            }
                        }
                        $nmr->FileToken = $img_token;
                        $nmr->save();
                    }
                }

                $data = [
                    'custom_alert' => 'success',
                    'status' => 'registration_success',
                    'message' => 'Registration successful!',
                    'redirecToUrl' => route('user.pet_registration_form')
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
                else
                {
                    return redirect()->route('user.pet_registration_form')->with($data);
                }
            }
            else
            {
                $data = [
                    'custom_alert' => 'warning',
                    'status' => 'registration_fail',
                    'message' => 'Failed to register',
                    'redirecToUrl' => route('user.pet_registration_form')
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
                'custom_alert' => 'warning',
                'status' => 'registration_fail',
                'message' => 'Failed to register',
                'redirecToUrl' => route('user.pet_registration_form')
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

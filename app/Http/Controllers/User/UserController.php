<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Users\MembersModel;
use App\Models\Users\MembersDocModel;
use App\Models\Users\IagdMembers;
use App\Models\Users\EmailVerification;
use App\Models\Users\MembersGallery;
use App\Models\Users\PostFeed;
use App\Models\Users\PostReaction;
use App\Models\Users\PostComments;
use App\Models\Users\MembersDevice;
use App\Models\Users\Trade;
use App\Models\Users\TradeLog;
use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryRabbit;
use App\Models\Users\RegistryBird;
use App\Models\Users\RegistryOtherAnimal;
use App\Models\Users\PetImage;
use App\Models\Users\MembersAd;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersRabbit;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\StorageFile;
use App\Models\Users\VisitorLog;
use App\Models\Users\NonMemberRegistration;

use App\Models\Users\TestAnimals;

use App\Services\UserReferenceService;

use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use JavaScript;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;

/* Custom helper */
use App\Helper\NotificationsForUser_Helper as Notif_Helper;
use App\Models\Admin\AdminModel;

class UserController extends Controller
{
    public function __construct()
    {
        $users_online = MembersModel::where('last_action', '>', Carbon::now()->subMinutes(10))->count();
        $users_registered = MembersModel::count();
        $visitor_count = VisitorLog::all()->count();

        $data = array(
            'users_online' => $users_online,
            'users_registered' => $users_registered,
            'visitor_count' => $visitor_count,
        );

        View::share('analytics', $data);
    }


    /* LOAD VIEWS */
    public function log_in(Request $request)
    {
        /*
            CLEAR OTHER SESSION
            PASSWORD RESET SESSION
            REGISTRATION SESSION
        */
        $request->session()->forget('password_reset_session');
        $request->session()->forget('pass_change');
        $request->session()->forget('register_this_email');
        $request->session()->forget('register_this_googleacount');
        $request->session()->forget('googleLinkAccount');


        JavaScript::put([
            'assetUrl' => asset(''),
            'thisUrl' => URL::to('/')
        ]);

        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        } else {
            $data = array(
                'title' => 'Login | IAGD Members Lounge',
            );
            return view('pages/users/user-login', ['data' => $data]);
        }
    }

    public function user_registered_members(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        } else {
            // if ($request->session()->has('iagd_checking')) {
            //     return redirect()->route('user.verify_iagd_number_email');
            // }
            $data = array(
                'title' => 'Register Member | IAGD Members Lounge',
            );
            return view('pages/users/user_registered_members', ['data' => $data]);
        }
    }
    public function dashboard()
    {
        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        $premium_uuids = MembersModel::where('is_premium', 1)->pluck('uuid');

        /* Javascript variables */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/'),
            'user_timezone' => Auth::guard('web')->user()->timezone,
            'premium_uuids' => $premium_uuids
        ]);

        $data = array(
            'title' => 'Post Feed | IAGD Members Lounge',
            'notif' => $notif,
        );
        return view('pages/users/user_dashboard', ["data" => $data]);
    }
    public function pet_gallery()
    {
        /* GET MEMBER UPLOADS */
        $members_gallery = MembersGallery::where('uuid', Auth::guard('web')->user()->uuid)->get();
        $data = array(
            'title' => 'Gallery | IAGD Members Lounge',
            'members_gallery' => $members_gallery
        );
        return view('pages/users/user_pet_gallery', ["data" => $data]);
    }
    public function user_profile()
    {
        $email_address = Auth::guard('web')->user()->email_address;

        $getEmailVerificaiton = EmailVerification::where('email_address', $email_address)->first();

        $data = array(
            'title' => 'User Profile | IAGD Members Lounge',
            'everify' => $getEmailVerificaiton,
        );
        return view('pages/users/user_profile', ["data" => $data]);
    }
    public function pet_trades()
    {
        $current_trade = TradeLog::where('iagd_number', Auth::guard('web')->user()->iagd_number)
                                    ->where('log_status', 'pending')
                                    ->orWhere('log_status', 'accepted')
                                    ->first();
        $data = array(
            'title' => 'Trades | IAGD Members Lounge',
            'current_trade_log' => $current_trade,
        );
        return view('pages/users/user_pet_trades',["data"=>$data]);
    }
    public function view_trade($tradeno)
    {
        if (empty($tradeno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $GetTrade_data = Trade::where('trade_no', $tradeno)
                                ->where('poster_iagd_number', Auth::guard('web')->user()->iagd_number)
                                ->orWhere('requester_iagd_number', Auth::guard('web')->user()->iagd_number);
        if ($GetTrade_data->count() > 0) {

            $gtd = $GetTrade_data->first();

            if (strlen($gtd->trade_log_no) < 1) { /* GENERATE NEW TRADE LOG NO */
                do {
                    $trade_log_no = Str::uuid();
                } while (TradeLog::where('trade_log_no', '=', $trade_log_no)->first()  instanceof TradeLog);
                $gtd->trade_log_no = $trade_log_no;
                $gtd->save();
            }

            /* GET POSTER DETAILS */
            $PosterTrade_data = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                            ->where('iagd_number', $gtd->poster_iagd_number);
            if ($PosterTrade_data->count() < 1) {
                $gptd = TradeLog::create([
                    'trade_log_no' => $gtd->trade_log_no,
                    'trade_no' => $gtd->trade_no,
                    'iagd_number' => $gtd->poster_iagd_number,
                    'cash_amount' => '0',
                    'role' => 'poster',
                    'accepted' => '0',
                    'log_status' => 'poster',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])->save();
            }
            $gptd = $PosterTrade_data->first();

            /* GET REQUESTER DETAILS */
            $RequesterTrade_data = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                            ->where('iagd_number', $gtd->requester_iagd_number);
            if ($RequesterTrade_data->count() > 0) {
                $grtd = $RequesterTrade_data->first();
                $trade_requests = NULL;
            } else {
                $grtd = NULL;

                /* GET REQUESTS */
                $TradeRequests = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                                ->where('log_status', 'pending');
                if ($TradeRequests->count() > 0) {
                    $trade_requests = $TradeRequests->with('MembersModel:id,iagd_number,profile_image,first_name,last_name')
                                                        ->get();
                } else {
                    $trade_requests = NULL;
                }
            }

            /* GET TEST ANIMALS DETAILS */
            $test_animals = TestAnimals::all();

            $data = array(
                'title' => 'Trading | IAGD Members Lounge',
                'trade_data' => $gtd,
                'poster_data' => $gptd,
                'requester_data' => $grtd,
                'trade_requests' => $trade_requests,
                'test_animals' => $test_animals,
            );
            JavaScript::put([ // get trade_log details
                'trade_no' => $gtd->trade_no,
            ]);

            return view('pages/users/user_pet_trading', ["data" => $data]);
        } else {
            return redirect()->route('pet_trades')->with('response', 'trade_not_found');
        }
    }
    // ADVERTISEMENTS
    public function advertisements(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_advertisements = MembersAd::where('member_uuid', Auth::guard('web')->user()->uuid)
                                    ->paginate(10);
        $data = array(
            'title' => 'Advertisements | IAGD Members Lounge',
            'member_advertisements' => $member_advertisements,
        );
        return view('pages/users/user_advertisements',["data"=>$data]);
    }
    public function advertisements_info($uuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($uuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $GetAd_data = MembersAd::where('uuid', $uuid)
                                ->where('member_uuid', Auth::guard('web')->user()->uuid);
        if ($GetAd_data->count() > 0) {

            $gad = $GetAd_data->first();

            $data = array(
                'title' => 'Advertisements | IAGD Members Lounge',
                'ad_data' => $gad,
            );
            return view('pages/users/user_advertisements_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }

    // KENNEL
    public function kennel(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('kennel_unregistered');
        // }

        $member_dogs = RegistryDog::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->paginate(10);
        $data = array(
            'title' => 'Dogs | IAGD Members Lounge',
            'member_dogs' => $member_dogs,
            'kennel_count' => MembersDog::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->where('Status', '<>', 0)
                                        ->count(),
        );
        return view('pages/users/user_kennel',["data"=>$data]);
    }
    public function kennel_info($petno)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('kennel_unregistered');
        // }
        if (empty($petno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => $petno,
            'pet_uuid' => NULL,
            'pet_type' => 'dog_reg',
        ];

        $GetPet_data = RegistryDog::where('PetNo', $petno)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                // ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Dogs | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $gpd->PetUUID)
                ->where('Type', 'dog');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_kennel_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    public function kennel_unregistered(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_dogs = MembersDog::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->where('Status', '<>', 0)
                                    ->paginate(10);
        $data = array(
            'title' => 'Dog Registration | IAGD Members Lounge',
            'member_dogs' => $member_dogs,
            'kennel_count' => RegistryDog::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->count(),
        );
        return view('pages/users/user_kennel_unregistered',["data"=>$data]);
    }
    public function kennel_unregistered_info($petuuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => NULL,
            'pet_uuid' => $petuuid,
            'pet_type' => 'dog_mem',
        ];

        $GetPet_data = MembersDog::where('PetUUID', $petuuid)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ;
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Dog Registration | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $petuuid)
                ->where('Type', 'dog');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_kennel_unregistered_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    // CATTERY
    public function cattery()
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('cattery_unregistered');
        // }
        $member_cats = RegistryCat::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->paginate(10);
        $data = array(
            'title' => 'Cats | IAGD Members Lounge',
            'member_cats' => $member_cats,
            'cattery_count' => MembersCat::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                        ->where('Status', '<>', 0)
                                        ->count(),
        );
        return view('pages/users/user_cattery',["data"=>$data]);
    }
    public function cattery_info($petno)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('cattery_unregistered');
        // }
        if (empty($petno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => $petno,
            'pet_uuid' => NULL,
            'pet_type' => 'cat_reg',
        ];

        $GetPet_data = RegistryCat::where('PetNo', $petno)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                // ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Cats | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $gpd->PetUUID)
                ->where('Type', 'cat');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_cattery_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    public function cattery_unregistered(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_cats = MembersCat::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->where('Status', '<>', 0)
                                    ->paginate(10);
        $data = array(
            'title' => 'Cat Registration | IAGD Members Lounge',
            'member_cats' => $member_cats,
            'cattery_count' => RegistryCat::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->count(),
        );
        return view('pages/users/user_cattery_unregistered',["data"=>$data]);
    }
    public function cattery_unregistered_info($petuuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => NULL,
            'pet_uuid' => $petuuid,
            'pet_type' => 'cat_mem',
        ];

        $GetPet_data = MembersCat::where('PetUUID', $petuuid)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ;
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Cat Registration | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $petuuid)
                ->where('Type', 'cat');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_cattery_unregistered_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    // RABBITRY
    public function rabbitry()
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('rabbitry_unregistered');
        // }
        $member_rabbits = RegistryRabbit::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->paginate(10);
        $data = array(
            'title' => 'Rabbits | IAGD Members Lounge',
            'member_rabbits' => $member_rabbits,
            'rabbitry_count' => MembersRabbit::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                        ->where('Status', '<>', 0)
                                        ->count(),
        );
        return view('pages/users/user_rabbitry',["data"=>$data]);
    }
    public function rabbitry_info($petno)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('rabbitry_unregistered');
        // }
        if (empty($petno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => $petno,
            'pet_uuid' => NULL,
            'pet_type' => 'rabbit_reg',
        ];

        $GetPet_data = RegistryRabbit::where('PetNo', $petno)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                // ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Rabbits | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $gpd->PetUUID)
                ->where('Type', 'rabbit');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_rabbitry_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    public function rabbitry_unregistered(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_rabbits = MembersRabbit::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->where('Status', '<>', 0)
                                    ->paginate(10);
        $data = array(
            'title' => 'Rabbit Registration | IAGD Members Lounge',
            'member_rabbits' => $member_rabbits,
            'rabbitry_count' => RegistryRabbit::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->count(),
        );
        return view('pages/users/user_rabbitry_unregistered',["data"=>$data]);
    }
    public function rabbitry_unregistered_info($petuuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => NULL,
            'pet_uuid' => $petuuid,
            'pet_type' => 'rabbit_mem',
        ];

        $GetPet_data = MembersRabbit::where('PetUUID', $petuuid)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ;
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Rabbit Registration | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $petuuid)
                ->where('Type', 'rabbit');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_rabbitry_unregistered_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    // COOP
    public function coop()
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('coop_unregistered');
        // }
        $member_birds = RegistryBird::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->paginate(10);
        $data = array(
            'title' => 'Birds | IAGD Members Lounge',
            'member_birds' => $member_birds,
            'coop_count' => MembersBird::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                        ->where('Status', '<>', 0)
                                        ->count(),
        );
        return view('pages/users/user_coop',["data"=>$data]);
    }
    public function coop_info($petno)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('coop_unregistered');
        // }
        if (empty($petno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => $petno,
            'pet_uuid' => NULL,
            'pet_type' => 'bird_reg',
        ];

        $GetPet_data = RegistryBird::where('PetNo', $petno)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                // ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Birds | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $gpd->PetUUID)
                ->where('Type', 'bird');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_coop_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    public function coop_unregistered(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_birds = MembersBird::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->where('Status', '<>', 0)
                                    ->paginate(10);
        $data = array(
            'title' => 'Bird Registration | IAGD Members Lounge',
            'member_birds' => $member_birds,
            'coop_count' => RegistryBird::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->count(),
        );
        return view('pages/users/user_coop_unregistered',["data"=>$data]);
    }
    public function coop_unregistered_info($petuuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => NULL,
            'pet_uuid' => $petuuid,
            'pet_type' => 'bird_mem',
        ];

        $GetPet_data = MembersBird::where('PetUUID', $petuuid)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ;
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Bird Registration | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $petuuid)
                ->where('Type', 'bird');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_coop_unregistered_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    // OTHER ANIMALS
    public function other_animal()
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('other_animal_unregistered');
        // }
        $member_other_animals = RegistryOtherAnimal::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->paginate(10);
        $data = array(
            'title' => 'Other Animals | IAGD Members Lounge',
            'member_other_animals' => $member_other_animals,
            'other_animal_count' => MembersOtherAnimal::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                        ->where('Status', '<>', 0)
                                        ->count(),
        );
        return view('pages/users/user_other_animal',["data"=>$data]);
    }
    public function other_animal_info($petno)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     // return redirect()->back();
        //     return redirect()->route('other_animal_unregistered');
        // }
        if (empty($petno)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => $petno,
            'pet_uuid' => NULL,
            'pet_type' => 'other_animal_reg',
        ];

        $GetPet_data = RegistryOtherAnimal::where('PetNo', $petno)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                // ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Other Animals | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $gpd->PetUUID)
                ->where('Type', 'other');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_other_animal_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }
    public function other_animal_unregistered(Request $request)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }

        $member_other_animals = MembersOtherAnimal::where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                    ->with('AdtlInfo', 'AdtlInfo.FilePhoto')
                                    ->where('Status', '<>', 0)
                                    ->paginate(10);
        $data = array(
            'title' => 'Other Animal Registration | IAGD Members Lounge',
            'member_other_animals' => $member_other_animals,
            'other_animal_count' => RegistryOtherAnimal::select('id')
                                        ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                        ->count(),
        );
        return view('pages/users/user_other_animal_unregistered',["data"=>$data]);
    }
    public function other_animal_unregistered_info($petuuid)
    {
        // if (empty(Auth::guard('web')->user()->iagd_number)) {
        //     return redirect()->back();
        // }
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        $js_var = [
            'pet_no' => NULL,
            'pet_uuid' => $petuuid,
            'pet_type' => 'other_animal_mem',
        ];

        $GetPet_data = MembersOtherAnimal::where('PetUUID', $petuuid)
                                // ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ;
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $data = array(
                'title' => 'Other Animal Registration | IAGD Members Lounge',
                'pet_data' => $gpd,
                'js_var' => $js_var,
            );

            // get adtl pet data - unregistered
            $GetAdtl_data = NonMemberRegistration::where('PetUUID', $petuuid)
                ->where('Type', 'other');
            if ($GetAdtl_data->count() > 0) {
                $gadtl = $GetAdtl_data->first();
                $data['adtl_data'] = $gadtl;

                // get file details
                $pet_files = array(
                    'Photo',
                    'SireImage',
                    'DamImage',
                    'PetSupportingDocuments',
                    'VetRecordDocuments',
                    'SireSupportingDocuments',
                    'DamSupportingDocuments',
                );

                foreach ($pet_files as $file_name) {
                    $GetStorageFile_data = StorageFile::where('uuid', $gadtl->$file_name)
                        ->where('token', $gadtl->FileToken);
                    if ($GetStorageFile_data->count() > 0) {
                        $gsfd = $GetStorageFile_data->first();
                        $data[$file_name] = array(
                            'file_name' => $gsfd->file_name,
                            'file_path' => $gsfd->file_path,
                        );
                    }
                }
            }

            return view('pages/users/user_other_animal_unregistered_info',["data"=>$data]);
        } else {
            return redirect()->back()->with('response', 'pet_not_found');
        }
    }

    public function verify_iagd_number_email(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        if (!$request->session()->has('iagd_checking')) {
            return redirect()->route('user.user_registered_members')->with('response', 'enter_iagd_num');
        }
        $data = array(
            'title' => 'Verify your IAGD number | IAGD Members Lounge',
        );
        return view('pages/users/user_verification_page', ["data" => $data]);
    }

    public function create_password_foruser(Request $request)
    {
        /* CHECK IF USER IS LOGGED IN */
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        /* SET VARIABLES */
        $iagd_number = $request->input('in');
        $token = $request->input('tk');

        /* CHECK IF INPUT IS NULL AND SET */
        if (!$request->input('in') || !$request->input('tk') || empty($request->input('in')) || empty($request->input('tk'))) {
            return redirect()->route('user.user_registered_members')->with('response', 'enter_iagd_num');
        }

        /* GET DATA */
        $CheckIagdDetails = EmailVerification::where('iagd_number', $iagd_number)->where('token', $token);



        if ($CheckIagdDetails->count() > 0) {

            if ((time() - $CheckIagdDetails->first()->expiration) > 600) {
                return redirect()->route('user.user_registered_members')->with('response', 'page_expired');
            }

            if ($CheckIagdDetails->first()->verified == 1) {
                return redirect()->route('user.login');
            }

            /* IF SESSION NOT FOUND CREATE NEW */
            if (!$request->session()->has('iagd_checking')) {
                $sess_data = array(
                    'iagd_number' => $CheckIagdDetails->first()->iagd_number,
                    'email_address' => $CheckIagdDetails->first()->email_address,
                    'token' => $CheckIagdDetails->first()->token,
                );
                $request->session()->put('iagd_checking', $sess_data);
            }

            $data = array(
                'title' => 'Create password | IAGD Members Lounge',
            );
            return view('pages/users/user_create_password', ["data" => $data]);
        } else {
            return redirect()->route('user.user_registered_members')->with('response', 'enter_iagd_num');
        }
    }
    public function view_post(Request $request)
    {
        if (!$request->has('postid') || empty($request->input('postid'))) {
            return redirect()->back()->with('response', 'key_error');
        }

        $validate = Validator::make($request->all(), [
            'postid' => 'required'
        ], [
            'postid.required' => 'Something\'s wrong, Please try again later'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $GetPost_data = PostFeed::where('post_id', $request->input('postid'));
        if ($GetPost_data->count() > 0) {

            $gpd = $GetPost_data->first();

            /* GET REACTIONS */

            $PostReaction = DB::table('post_reaction')->where('post_id', '=', $gpd->post_id)
                ->get();
            $PostReaction_c = $PostReaction->count();

            /* GET COMMENTS */

            $PostComments = DB::table('post_comments')->where('post_id', '=', $gpd->post_id);

            $PostComments_c = $PostComments->count();

            $PostComments = $PostComments->first();

            $memdata = MembersModel::where('uuid',$gpd->uuid)->first();

            $title =  $memdata->iagd_number .'\'s post ';
            $data = array(
                'title' => $title . ' | IAGD Members Lounge',
                'post_data' => $gpd,
                'post_reaction' => $PostReaction,
                'post_reaction_c' => $PostReaction_c,
                'PostComments' => $PostComments,
                'PostComments_c' => $PostComments_c,
            );
            JavaScript::put([
                'rid' => $gpd->id,
                'post_id' => $gpd->post_id,
                'ownpun' => $gpd->uuid,
                'pun' => Auth::guard('web')->user()->uuid
            ]);

            return view('pages/users/user_view_post', ["data" => $data]);
        } else {
            return redirect()->back()->with('response', 'post_not_found');
        }
    }

    /* VIEW PET IN GALLERY */
    public function view_pet_details(Request $request)
    {
        /* CHECK IF ROW ID EXIST */
        if (empty($request->input('rid')) || !$request->has('rid')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $id = $request->input('rid');

        $members_gallery = MembersGallery::where('id', $id);

        if ($members_gallery->count() > 0) {

            $mg = $members_gallery->first();


            $data = array(
                'title' => $mg->name . ' | IAGD Members Lounge',
                'mg' => $mg,
            );
            return view('pages/users/user-view-pet', ["data" => $data]);
        } else {
            echo 'null';
        }
    }



    /* TEMPLATE FOR PASWORD RESET EMAIL */
    public function password_reset_template()
    {
        return view('pages/users/template/emails/mail-forgot-password');
    }

    /* END VIEWS */

    /* ACTIONS */

    public function user_loginvalidation(Request $request)
    {
        /* CHECK OF KEY IS SET */
        if (!$request->has('unique_id') || !$request->has('password')) {
            return redirect()->back()->withInput()->with('response', 'key_error');
        }

        /* RUN VALIDATION */
        $validate = Validator::make($request->all(), [
            'unique_id' => 'required',
            'password' => 'required',
        ], [
            'unique_id.required' => 'Enter your IAGD # or Email address',
            'password.required' => 'Enter your password',
        ]);

        /* CATCH VALIDATION ERROR AND THROW RESPONSE */
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        $uniqueid = $request->input('unique_id');
        $password = $request->input('password');

        $fieldType = filter_var($uniqueid, FILTER_VALIDATE_EMAIL) ? 'email_address' : 'iagd_number';

        if (Auth::guard('web')->attempt(array($fieldType => $uniqueid, 'password' => $password))) {
            /* LOG DEVICE */
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

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withInput()->with('response', 'incorrect_cred');
        }
    }

    /* END ACTIONS */

    /* AJAX FUNCTIONS */
    public function upload_cropped_image(Request $request)
    {

        $folderPath = public_path('img/user/' . Auth::guard('web')->user()->uuid . '/');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        /* CHECK IF PROFILE IMAGE IS NOT NULL REMOVE IMAGE IN PUBLIC */
        if (!empty(Auth::guard('web')->user()->profile_image)) {
            $old_image = Auth::guard('web')->user()->profile_image;
            File::delete($old_image);
        }


        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.jpg';

        $imageFullPath = $folderPath . $imageName;

        file_put_contents($imageFullPath, $image_base64);

        $image = 'img/user/' . Auth::guard('web')->user()->uuid . '/' . $imageName;

        $member = Auth::guard('web')->user();

        $member->profile_image = $image;

        /** @var - $member */
        if ($member->save()) {

            $data = 'profile_updated';
        } else {
            $data = 'profile_update_error';
        }

        return response()->json(['response' => $data]);
    }

    public function upload_pet_image(Request $request)
    {

        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','image','pet_no','pet_type'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'image' => 'required',
            'pet_no' => 'required',
            'pet_type' => 'required',
        ],[
            'image.required' => 'Something\'s wrong! Please try again.',
            'pet_no.required' => 'Something\'s wrong! Please try again.',
            'pet_type.required' => 'Something\'s wrong! Please try again.',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        // DOG IMAGE
        if ($request->input('pet_type') == 'dog') {
            $pet_path = 'img/pets/dogs/';
            $GetPet_data = RegistryDog::where('PetNo', $request->input('pet_no'))
                                    ->where('OwnerIAGDNo', Auth::guard('web')->user()->iagd_number)
                                    ->where('Approval', 1);
        }
        elseif ($request->input('pet_type') == 'unregistered_dog') {
            $pet_path = 'img/pets/dogs_unregistered/';
            $GetPet_data = MembersDog::where('PetUUID', $request->input('pet_no'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // CAT IMAGE
        elseif ($request->input('pet_type') == 'cat') {
            $pet_path = 'img/pets/cats/';
            $GetPet_data = RegistryCat::where('PetNo', $request->input('pet_no'))
                                    ->where('OwnerIAGDNo', Auth::guard('web')->user()->iagd_number)
                                    ->where('Approval', 1);
        }
        elseif ($request->input('pet_type') == 'unregistered_cat') {
            $pet_path = 'img/pets/cats_unregistered/';
            $GetPet_data = MembersCat::where('PetUUID', $request->input('pet_no'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // RABBIT IMAGE
        elseif ($request->input('pet_type') == 'rabbit') {
            $pet_path = 'img/pets/rabbits/';
            $GetPet_data = RegistryRabbit::where('PetNo', $request->input('pet_no'))
                                    ->where('OwnerIAGDNo', Auth::guard('web')->user()->iagd_number)
                                    ->where('Approval', 1);
        }
        elseif ($request->input('pet_type') == 'unregistered_rabbit') {
            $pet_path = 'img/pets/rabbits_unregistered/';
            $GetPet_data = MembersRabbit::where('PetUUID', $request->input('pet_no'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // BIRD IMAGE
        elseif ($request->input('pet_type') == 'bird') {
            $pet_path = 'img/pets/birds/';
            $GetPet_data = RegistryBird::where('PetNo', $request->input('pet_no'))
                                    ->where('OwnerIAGDNo', Auth::guard('web')->user()->iagd_number)
                                    ->where('Approval', 1);
        }
        elseif ($request->input('pet_type') == 'unregistered_bird') {
            $pet_path = 'img/pets/birds_unregistered/';
            $GetPet_data = MembersBird::where('PetUUID', $request->input('pet_no'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // OTHER ANIMAL IMAGE
        elseif ($request->input('pet_type') == 'other_animal') {
            $pet_path = 'img/pets/other_animals/';
            $GetPet_data = RegistryOtherAnimal::where('PetNo', $request->input('pet_no'))
                                    ->where('OwnerIAGDNo', Auth::guard('web')->user()->iagd_number)
                                    ->where('Approval', 1);
        }
        elseif ($request->input('pet_type') == 'unregistered_other_animal') {
            $pet_path = 'img/pets/other_animals_unregistered/';
            $GetPet_data = MembersOtherAnimal::where('PetUUID', $request->input('pet_no'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }

        if (isset($GetPet_data) && $GetPet_data->count() > 0) {
            if ($request->input('pet_type') == 'unregistered_dog' ||
                $request->input('pet_type') == 'unregistered_cat' ||
                $request->input('pet_type') == 'unregistered_rabbit' ||
                $request->input('pet_type') == 'unregistered_bird' ||
                $request->input('pet_type') == 'unregistered_other_animal') {
                $GetPetImage_data = PetImage::where('pet_uuid', $request->input('pet_no'))
                                    ->where('pet_type', $request->input('pet_type'));
            } else {
                $GetPetImage_data = PetImage::where('pet_no', $request->input('pet_no'))
                                    ->where('pet_type', $request->input('pet_type'));
            }
            if ($GetPetImage_data->count() < 1) { // IF PET IMAGE NOT EXIST

                do {
                    $pet_image_no = Str::uuid();
                } while (PetImage::where('pet_image_no', '=', $pet_image_no)->first()  instanceof PetImage);

                if ($request->input('pet_type') == 'unregistered_dog' ||
                    $request->input('pet_type') == 'unregistered_cat' ||
                    $request->input('pet_type') == 'unregistered_rabbit' ||
                    $request->input('pet_type') == 'unregistered_bird' ||
                    $request->input('pet_type') == 'unregistered_other_animal') {
                    $GetPetImage_data = PetImage::create([
                        'pet_image_no' => $pet_image_no,
                        'pet_uuid' => $request->input('pet_no'),
                        'pet_type' => $request->input('pet_type'),
                    ]);
                } else {
                    $GetPetImage_data = PetImage::create([
                        'pet_image_no' => $pet_image_no,
                        'pet_no' => $request->input('pet_no'),
                        'pet_type' => $request->input('pet_type'),
                    ]);
                }
            } else {
                $GetPetImage_data = $GetPetImage_data->first();
            }

            $gpid = $GetPetImage_data;

            $pet_image_no = $gpid->pet_image_no;

            // print_r($gpid->pet_image_no);exit();

            $folderPath = public_path($pet_path . $pet_image_no . '/');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            /* CHECK IF PROFILE IMAGE IS NOT NULL REMOVE IMAGE IN PUBLIC */
            if (!empty($gpid->file_path)) {
                $old_image = $gpid->file_path;
                File::delete($old_image);
            }


            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $imageName = uniqid() . '.jpg';

            $imageFullPath = $folderPath . $imageName;

            file_put_contents($imageFullPath, $image_base64);

            $image = $pet_path . $pet_image_no . '/' . $imageName;

            $gpid->file_path = $image;

            if ($gpid->save()) {
                return redirect()->back()->with('response','pet_image_upload_success');
            } else {
                return redirect()->back()->with('response','pet_image_upload_error');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function upload_receipt(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_uuid','pet_type','receipt_image'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_uuid' => 'required',
            'pet_type' => 'required',
            'receipt_image' => 'required|image|mimes:jpg,png,jpeg,gif',
        ],[
            'pet_uuid.required' => 'Something\'s wrong! Please try again.',
            'pet_type.required' => 'Something\'s wrong! Please try again.',
            'receipt_image.required' => 'Image is required',
            'receipt_image.image' => 'Uploaded file is not an image',
            'receipt_image.mimes' => 'Acceptable file format is jpg , png , jpeg or gif',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        // DOG IMAGE
        if ($request->input('pet_type') == 'unregistered_dog') {
            $GetPet_data = MembersDog::where('PetUUID', $request->input('pet_uuid'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // CAT IMAGE
        elseif ($request->input('pet_type') == 'unregistered_cat') {
            $GetPet_data = MembersCat::where('PetUUID', $request->input('pet_uuid'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // RABBIT IMAGE
        elseif ($request->input('pet_type') == 'unregistered_rabbit') {
            $GetPet_data = MembersRabbit::where('PetUUID', $request->input('pet_uuid'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // BIRD IMAGE
        elseif ($request->input('pet_type') == 'unregistered_bird') {
            $GetPet_data = MembersBird::where('PetUUID', $request->input('pet_uuid'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }
        // OTHER ANIMAL IMAGE
        elseif ($request->input('pet_type') == 'unregistered_other_animal') {
            $GetPet_data = MembersOtherAnimal::where('PetUUID', $request->input('pet_uuid'))
                                    ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        }


        // if (isset($GetPet_data) && $GetPet_data->count() > 0) {

        //     $gpd = $GetPet_data->first();


        //     $GetStorageFile_data = StorageFile::where('uuid', $gpd->storage_img_uuid);
        //     if ($GetStorageFile_data->count() < 1) { // IF FILE NOT EXIST

        //         do {
        //             $file_uuid = Str::uuid();
        //         } while (StorageFile::where('uuid', '=', $file_uuid)->first()  instanceof StorageFile);

        //         $GetStorageFile_data = StorageFile::create([
        //             'uuid' => $file_uuid,
        //         ]);
        //     } else {
        //         $GetStorageFile_data = $GetStorageFile_data->first();
        //         if (Storage::disk('local')->exists($GetStorageFile_data->file_path)) {
        //             Storage::disk('local')->delete($GetStorageFile_data->file_path);
        //         }
        //     }

        //     $gsfd = $GetStorageFile_data;

        //     $imageName = $gsfd->uuid .'.'. $request->file('receipt_image')->extension();
        //     $imagePath = 'receipts/'. $imageName;

        //     $content = file_get_contents($request->file('receipt_image')->getRealPath());

        //     Storage::disk('local')->put($imagePath, $content);

        //     $img_token = Str::uuid();

        //     $gsfd->file_path = $imagePath;
        //     $gsfd->token = $img_token;

        //     $gpd->storage_img_uuid = $gsfd->uuid;
        //     $gpd->img_token = $img_token;

        //     if ($gsfd->save() && $gpd->save()) {
        //         return redirect()->back()->with('response','receipt_upload_success');
        //     } else {
        //         return redirect()->back()->with('response','receipt_upload_error');
        //     }
        // } else {
        //     return redirect()->back()->with('response','not_allowed');
        // }

        if (isset($GetPet_data) && $GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $GetStorageFile_data = StorageFile::where('uuid', $gpd->storage_img_uuid);
            if ($GetStorageFile_data->count() < 1) { // IF FILE NOT EXIST

                do {
                    $file_uuid = Str::uuid();
                } while (StorageFile::where('uuid', '=', $file_uuid)->first()  instanceof StorageFile);

                $GetStorageFile_data = StorageFile::create([
                    'uuid' => $file_uuid,
                ]);
            } else {
                $GetStorageFile_data = $GetStorageFile_data->first();
            }

            $gsfd = $GetStorageFile_data;

            $uuid = $gsfd->uuid;

            $folderPath = public_path('receipts/');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            /* CHECK IF PROFILE IMAGE IS NOT NULL REMOVE IMAGE IN PUBLIC */
            if (!empty($gsfd->file_path)) {
                $old_image = $gsfd->file_path;
                File::delete($old_image);
            }


            $imageName = uniqid() . '.jpg';

            $imageFullPath = $folderPath . $imageName;


            /* CREATE NEW ROW DATA */
            if (!$request->hasFile('receipt_image')) {
                return Redirect()->back()->with('status', 'image_is_null');
            }
            $file = $request->file('receipt_image');

            $file->move($folderPath, $imageName);



            $image = 'receipts/' . $imageName;


            $img_token = Str::uuid();

            $gsfd->file_path = $image;
            $gsfd->token = $img_token;

            $gpd->storage_img_uuid = $gsfd->uuid;
            $gpd->img_token = $img_token;

            if ($gsfd->save() && $gpd->save()) {
                return redirect()->back()->with('response','receipt_upload_success');
            } else {
                return redirect()->back()->with('response','receipt_upload_error');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }


    /* AJAX END */


    public function get_file(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['token','uuid'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                echo 0;
            }
        }

        $GetStorageFile_data = StorageFile::where('uuid', $request->input('uuid'))
            ->where('token', $request->input('token'));
        if ($GetStorageFile_data->count() > 0) { // IF FILE NOT EXIST

            $gsfd = $GetStorageFile_data->first();

            echo json_encode([$gsfd->file_path, $gsfd->file_name]);
        } else {
            echo json_encode('error' . $request->input('uuid') .','. $request->input('token'));
        }
        // return response()->download(public_path('img/user/user.png'));

        // $path = public_path().'/img/user/user.png';
        // // $result = Response::download($path);
        // // return $result;

        // // return $file_path;


        // $contents = file_get_contents($path);

        // Storage::disk('local')->put('temp_file.png', $contents);

        // $path = Storage::url('temp_file.png');

        // if (Storage::disk('local')->exists('file.jpg'))

    }
    // public function download_file(Request $request) {
    //     /* STORE KEYS TO ARRAY */
    //     $key_arr = ['token','uuid'];

    //     /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
    //     foreach ($request->input() as $key => $value) {
    //         if (!in_array($key,$key_arr)) {
    //             echo 0;
    //         }
    //     }

    //     $GetStorageFile_data = StorageFile::where('uuid', $request->input('uuid'))
    //         ->where('token', $request->input('token'));
    //     if ($GetStorageFile_data->count() > 0) { // IF FILE EXIST
    //         $gsfd = $GetStorageFile_data->first();
    //         $baseurl = url('/') . '/';
    //         echo json_encode([$baseurl . $gsfd->file_path]);
    //     } else {
    //         echo NULL;
    //     }
    // }

    /* REGISTER PET */
    public function pet_registration()
    {
        return redirect()->route('user.landing');
        // $data = array(
        //     'title' => 'Pet Registration | IAGD Members Lounge',
        // );
        // return view('pages/users/pet-registration/user-pet-registration', ["data" => $data]);
    }
    public function pet_registration_form(Request $request)
    {
        return redirect()->route('user.landing');
        // /* VALIDATE INPUTS */
        // $validate = Validator::make($request->all(),[
        //     'type' => 'required',
        // ],[
        //     'type.required' => 'Something\'s wrong! Please try again.',
        // ]);

        // /* THROW ERROR IF VALIDATION FAILED */
        // if ($validate->fails()) {
        //     return redirect()->route('user.pet_registration')->withErrors($validate);
        // }


        // $data = array(
        //     'title' => ucfirst($request->input('type')) . ' Registration | IAGD Members Lounge',
        //     'pet_type' => $request->input('type'),
        // );
        // return view('pages/users/pet-registration/user-pet-registration-form', ["data" => $data]);
    }
    public function my_referrals(UserReferenceService $userReferenceService)
    {
        $user = Auth::guard('web')->user();
        $iagd_number = $user->iagd_number;
    
        // Attempt to get user references
        $references = $userReferenceService->getUserReferences($iagd_number);
        if (isset($references['error'])) {
            Log::info('Reference error');
            return redirect()->back()->with('response', 'key_error');
        }
    
        // Define the API base URL and parameters
        $baseApiUrl = "https://attendance.metaanimals.org/api/v1/referrals";
        $authToken = 'tewi-3DhkGogQqmPS6S_ww_Tpb9!kQtXc__Bya';
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
    
        // First API call for user calculations
        $calculationResponse = Http::withHeaders($headers)->asForm()->post(
            "$baseApiUrl/get_user_calculations",
            [
                'auth_token' => $authToken,
                'iagd_number' => $iagd_number,
                'downline_data' => $references['downline_data'],
            ]
        );
    
        if (!$calculationResponse->successful()) {
            Log::info('API response error for user calculations', ['status' => $calculationResponse->status()]);
            return redirect()->back()->with('response', 'api_error');
        }
    
        $calculationData = $calculationResponse->json();
    
        if (!isset($calculationData['data'])) {
            Log::info('Unexpected API response structure for user calculations');
            return redirect()->back()->with('response', 'unexpected_response');
        }
    
        // Second API call for withdrawal status
        $withdrawStatusResponse = Http::withHeaders($headers)
                               ->asForm()
                               ->post("$baseApiUrl/check_iagd_withdrawal_status?auth_token=$authToken&iagd_number=$iagd_number");
    
        if (!$withdrawStatusResponse->successful()) {
            Log::info('API response error for withdrawal status', ['status' => $withdrawStatusResponse->status()]);
            return redirect()->back()->with('response', 'api_error');
        }
    
        $withdrawStatusData = $withdrawStatusResponse->json();
    
        // Initialize withdraw_status with a default message
        $withdraw_status = 'Withdrawal status not available';
        $withdraw_valid = 0;
        
        // Parse the response based on the 'code' received
        if (isset($withdrawStatusData['code'])) {
            switch ($withdrawStatusData['code']) {
                case 0:
                    $withdraw_status = 'Forbidden access or invalid token.';
                    break;
                case 1:
                    $withdraw_status = 'iagd_number does not exist.' . ' iagd_number: ' . $iagd_number;
                    break;
                case 2:
                    $withdraw_status = 'User is active and can proceed with withdrawal.';
                    $withdraw_valid = 1;
                    break;
                case 3:
                    $withdraw_status = 'User is not active and cannot proceed with withdrawal.';
                    break;
            }
        } else {
            Log::info('Unexpected API response structure for withdrawal status');
        }
    
        // Prepare the data array for the view
        $data = [
            'title' => 'My Referrals',
            'references' => $references,
            'commissions' => $calculationData['data']['commissions'] ?? [],
            'withdraw_valid' => $withdraw_valid,
            'withdraw_status' => $withdraw_status,
        ];
    
        return view('pages/users/user-my_referrals', ['data' => $data]);
    }
}

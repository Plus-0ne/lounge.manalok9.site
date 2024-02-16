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
use App\Models\Users\Trade;
use App\Models\Users\TradeLog;
use App\Models\Users\ResetPassword;
use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryRabbit;
use App\Models\Users\RegistryBird;
use App\Models\Users\RegistryOtherAnimal;
use App\Models\Users\MembersAd;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersRabbit;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\NonMemberRegistration;
use App\Models\Users\StorageFile;

use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;

/* EVENTS */
use App\Events\YourPostNotification;
use App\Events\YourTradeNotification;

/* NOTIFICATION */
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyPostNotification;

class UpdateController extends Controller
{

    /* TIMEZONE UPDATE */
    public function UpdateTimezUser(Request $request)
    {
        try {
            if ($request->ajax()) {
                if (!$request->has('timez') || empty($request->input('timez'))) {
                    return response()->json(['response'=> 'key_error']);
                }
                else
                {
                    /* UPDATE TIMEZONE */

                    $member = Auth::guard('web')->user();

                    $member->timezone = $request->input('timez');

                    $member->save();

                    return response()->json(['response'=> 'success']);
                }
            }
            else
            {
                return response()->json(['response'=> 'not_ajax']);
            }
        } catch (\Throwable $th) {
            return response()->json(['response'=> $th]);
        }

    }

    /* UPDATE USER PROFILE */
    public function update_my_profile(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','last_name','first_name','mid','contact_num','comp_address'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'last_name' => 'required',
            'first_name' => 'required',
            'contact_num' => 'required',
        ],[
            'last_name.required' => 'Enter your last name',
            'first_name.required' => 'Enter your first name',
            'contact_num.required' => 'Enter your contact number',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE MEMBER PROFILE */

        $member = Auth::guard('web')->user();

        $member->last_name = Str::ucfirst($request->input('last_name'));
        $member->first_name = Str::ucfirst($request->input('first_name'));
        $member->middle_name = Str::ucfirst($request->input('mid'));
        $member->contact_number = $request->input('contact_num');
        $member->address = $request->input('comp_address');
        $member->updated_at = Carbon::now();

        /* CHECK IF MEMBER DATA UPDATED THROW FLASH DATA RESPONSE */
        if ($member->save()) {
            return redirect()->back()->with('response','member_updated');
        }
        else
        {
            return redirect()->back()->with('response','member_fail_update');
        }
    }

    /* UPDTE PASSWORD */
    public function update_my_password(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','c_pass','n_pass','v_pass'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'c_pass' => 'required',
            'n_pass' => 'required',
            'v_pass' => 'required',
        ],[
            'c_pass.required' => 'Enter your current password',
            'n_pass.required' => 'Enter your new password',
            'v_pass.required' => 'Enter your new password',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $c_pass = $request->input('c_pass');
        $n_pass = $request->input('n_pass');
        $v_pass = $request->input('v_pass');

        /* CHECK PASSWORD IS CORRECT */
        if (!Hash::check($c_pass, Auth::guard('web')->user()->password)) {
            return redirect()->back()->with('response','incorrect_password');
        }

        /* CHECK IF PASSWORD IS EQUAL TO VERIFY PASSWORD */
        if ($n_pass !== $v_pass) {
            return redirect()->back()->with('response','pass_did_not_matched');
        }

        $member = Auth::guard('web')->user();

        $member->password = Hash::make($n_pass);
        $member->updated_at = Carbon::now();

        if ($member->save()) {
            return redirect()->back()->with('response','pass_changed');
        }
        else
        {
            return redirect()->back()->with('response','error_changed_pass');
        }
    }

    /* CANCEL TRADE REQUEST */
    public function cancel_trade_request(Request $request)
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

        $GetTrade_data = Trade::where('trade_no', $request->input('tradeno'))
                                        ->where('trade_status', 'open');
        if ($GetTrade_data->count() > 0) {

            $gtd = $GetTrade_data->first();

            $GetTradeLog_data = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                            ->where('iagd_number', Auth::guard('web')->user()->iagd_number)
                                            ->where('log_status', 'pending');
            if ($GetTradeLog_data->count() > 0) {

                $gtld = $GetTradeLog_data->first();

                $gtld->log_status = 'cancelled';

                if ($gtld->save()) {
                    $id = MembersModel::where('iagd_number', $gtd->poster_iagd_number)->first()->id;
                    $find_notifiable_user = MembersModel::find($id);
                    $data = [
                        'iagd_number' => Auth::guard('web')->user()->iagd_number,
                        'message' => 'cancelled trade request to Trade #'. $request->input('tradeno')
                    ];
                    Notification::send($find_notifiable_user, new MyPostNotification($data));

                    $data = [
                        'trade_log_no' => $gtd->trade_log_no,
                        'iagd_number' => Auth::guard('web')->user()->iagd_number,
                        'action' => 'trade_request_cancel',
                        'trade_log_id' => $gtld->id
                    ];
                    broadcast(new YourTradeNotification($data))->toOthers();

                    return response()->json('trade_request_cancelled');
                }
                else
                {
                    return response()->json('error_trade_request_cancel');
                }

            } else {
                return response()->json('trade_log_not_found');
            }
        } else {
            return response()->json('trade_not_found');
        }
    }
    /* REJECT TRADE REQUEST */
    public function reject_trade_request(Request $request)
    {
        if (!$request->has('trade_log_id')) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        /* CHECK IF INPUT IS NOT EMPTY */
        if (empty($request->input('trade_log_id'))) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        $validate = Validator::make($request->all(), [
            'trade_log_id' => 'required',
        ], [
            'trade_log_id.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR MESSAGE */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $GetTradeLog_data = TradeLog::find($request->input('trade_log_id'))
                                        ->where('log_status', 'pending');
        if ($GetTradeLog_data->count() > 0) {

            $gtld = $GetTradeLog_data->first();

            $gtld->log_status = 'rejected';

            if ($gtld->save()) {
                $id = MembersModel::where('iagd_number', $gtld->iagd_number)->first()->id;
                $find_notifiable_user = MembersModel::find($id);
                $data = [
                    'iagd_number' => Auth::guard('web')->user()->iagd_number,
                    'message' => 'rejected your trade request to Trade #'. $gtld->trade_no
                ];
                Notification::send($find_notifiable_user, new MyPostNotification($data));

                // $data = [
                //     'trade_log_no' => $gtld->trade_log_no,
                //     'iagd_number' => Auth::guard('web')->user()->iagd_number,
                //     'action' => 'trade_request_reject',
                //     'trade_log_id' => $gtld->id
                // ];
                // broadcast(new YourTradeNotification($data))->toOthers();

                return response()->json('trade_request_rejected');
            }
            else
            {
                return response()->json('error_trade_request_reject');
            }

        } else {
            return response()->json('trade_log_not_found');
        }
    }
    /* ACCEPT TRADE REQUEST */
    public function accept_trade_request(Request $request)
    {
        if (!$request->has('trade_log_id')) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        /* CHECK IF INPUT IS NOT EMPTY */
        if (empty($request->input('trade_log_id'))) {
            $data = [
                'status' => 'error',
                'message' => 'Somethin\'s wrong! Please try again'
            ];
            return response()->json($data);
        }

        $validate = Validator::make($request->all(), [
            'trade_log_id' => 'required',
        ], [
            'trade_log_id.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR MESSAGE */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $GetTradeLog_data = TradeLog::find($request->input('trade_log_id'))
                                        ->where('log_status', 'pending');
        if ($GetTradeLog_data->count() > 0) {

            $gtld = $GetTradeLog_data->first();

            $gtld->log_status = 'rejected';

            if ($gtld->save()) {
                $id = MembersModel::where('iagd_number', $gtld->iagd_number)->first()->id;
                $find_notifiable_user = MembersModel::find($id);
                $data = [
                    'iagd_number' => Auth::guard('web')->user()->iagd_number,
                    'message' => 'rejected your trade request to Trade #'. $gtld->trade_no
                ];
                Notification::send($find_notifiable_user, new MyPostNotification($data));

                // $data = [
                //     'trade_log_no' => $gtld->trade_log_no,
                //     'iagd_number' => Auth::guard('web')->user()->iagd_number,
                //     'action' => 'trade_request_reject',
                //     'trade_log_id' => $gtld->id
                // ];
                // broadcast(new YourTradeNotification($data))->toOthers();

                return response()->json('trade_request_rejected');
            }
            else
            {
                return response()->json('error_trade_request_reject');
            }

        } else {
            return response()->json('trade_log_not_found');
        }
    }
    /* CLOSE TRADE */
    public function close_trade(Request $request)
    {
        if (!$request->has('tradeno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'tradeno' => 'required',
        ], [
            'tradeno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetTrade_data = Trade::where('trade_no', $request->input('tradeno'))
                                        ->where('poster_iagd_number', Auth::guard('web')->user()->iagd_number)
                                        ->where('trade_status', 'open')
                                        ->orWhere('trade_status', 'ongoing');
        if ($GetTrade_data->count() > 0) {

            $gtd = $GetTrade_data->first();

            $gtd->trade_status = 'closed';

            $GetTradeLog_data = TradeLog::where('trade_log_no', $gtd->trade_log_no)
                                            ->where('trade_no', $request->input('tradeno'))
                                            ->where('log_status', 'pending')
                                            ->orWhere('log_status', 'accepted');
            if ($GetTradeLog_data->count() > 0) {
                // REJECT PENDING OR ACCEPTED TRADE REQUESTS
                $gtld = $GetTradeLog_data->update(['log_status' => 'rejected']);
            }
            if ($gtd->save()) {
                return redirect()->back()->with('response','trade_closed');
            } else {
                return redirect()->back()->with('response','error_trade_close');
            }
        } else {
            return redirect()->back()->with('response', 'trade_not_found');
        }
    }
    /* ADD DOG */
    public function add_dog(Request $request)
    {
        if (!$request->has('petno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'petno' => 'required',
        ], [
            'petno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetDog_data = RegistryDog::where('PetNo', $request->input('petno'));
        if ($GetDog_data->count() > 0) {

            $gdd = $GetDog_data->first();

            if (empty($gdd->OwnerIAGDNo) && empty($gdd->OwnerUUID)) {
                $gdd->OwnerIAGDNo = Auth::guard('web')->user()->iagd_number;
                $gdd->OwnerUUID = Auth::guard('web')->user()->uuid;

                if ($gdd->save()) {
                    return redirect()->back()->with('response','dog_added');
                } else {
                    return redirect()->back()->with('response','error_dog_add');
                }
            } elseif ($gdd->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number && $gdd->Approval == 0) {
                return redirect()->back()->with('response','dog_approval_pending');
            } else {
                return redirect()->back()->with('response','dog_claimed');
            }

        } else {
            return redirect()->back()->with('response', 'dog_not_found');
        }
    }
    /* UPDATE USER DOG */
    public function update_dog(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_petno','pet_petname','pet_birthdate','pet_gender','pet_location','pet_breed','pet_owner','pet_co_owner','pet_breeder','pet_markings','pet_petcolor','pet_eyecolor','pet_height','pet_weight','pet_sirename','pet_damname'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_petno' => 'required',
            'pet_petname' => 'required',
            'pet_birthdate' => 'required',
            'pet_gender' => 'required',
            'pet_location' => 'required',
            'pet_breed' => 'required',
        ],[
            'pet_petno.required' => 'Something\'s wrong! Please try again.',
            'pet_petname.required' => 'Enter pet_petname',
            'pet_birthdate.required' => 'Enter pet_birthdate',
            'pet_gender.required' => 'Enter pet_gender',
            'pet_location.required' => 'Enter pet_location',
            'pet_breed.required' => 'Enter pet_breed',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE DOG INFO */
        $GetPet_data = RegistryDog::where('PetNo', $request->input('pet_petno'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->PetName = $request->input('pet_petname');
            $gpd->BirthDate = $request->input('pet_birthdate');
            $gpd->Gender = $request->input('pet_gender');
            $gpd->Location = $request->input('pet_location');
            $gpd->Breed = $request->input('pet_breed');
            $gpd->Owner = $request->input('pet_owner');
            $gpd->Co_Owner = $request->input('pet_co_owner');
            // $gpd->Breeder = $request->input('pet_breeder');
            $gpd->Markings = $request->input('pet_markings');
            $gpd->PetColor = $request->input('pet_petcolor');
            $gpd->EyeColor = $request->input('pet_eyecolor');
            $gpd->Height = $request->input('pet_height');
            $gpd->Weight = $request->input('pet_weight');
            $gpd->SireName = $request->input('pet_sirename');
            $gpd->DamName = $request->input('pet_damname');

            /* CHECK IF DOG DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gpd->save()) {
                return redirect()->back()->with('response','dog_updated');
            }
            else
            {
                return redirect()->back()->with('response','dog_fail_update');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function update_dog_unregistered(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            '_token',
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

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
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
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents'
                ) {
                return redirect()->back()->with('response', 'key_error');
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
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
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE DOG INFO */
        $GetPet_data = MembersDog::where('PetUUID', $request->input('pet_petuuid'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            if ($gpd->Status != 4) { // if petreg status not for user verification, don't proceed
                return redirect()->back()->with('response','dog_update_not_allowed');
            } else {
                $gpd->PetName = $request->input('pet_petname');
                $gpd->BirthDate = $request->input('pet_birthdate');
                $gpd->Gender = ($request->input('pet_gender') == 0 ? 'male' : 'female');
                $gpd->Location = $request->input('pet_location');
                $gpd->Breed = $request->input('pet_breed');
                $gpd->Breeder = $request->input('pet_breeder');
                $gpd->Markings = $request->input('pet_markings');
                $gpd->PetColor = $request->input('pet_petcolor');
                $gpd->EyeColor = $request->input('pet_eyecolor');
                $gpd->Height = $request->input('pet_height');
                $gpd->Weight = $request->input('pet_weight');
                $gpd->SireName = $request->input('pet_sirename');
                $gpd->DamName = $request->input('pet_damname');
                $gpd->Co_Owner = $request->input('pet_co_owner');

                $gpd->Status = 1; // for user registration

                /* CHECK IF DOG DATA UPDATED THROW FLASH DATA RESPONSE */
                if ($gpd->save()) {

                    // CHECK IF ADTL DETAILS ALREADY EXISTS UPDATE DETAILS; IF NO CREATE DATA
                    $PetUUID = $request->input('pet_petuuid');
                    $gadtl = NonMemberRegistration::where('PetUUID', $PetUUID)->where('Type', 'dog');
                    $adtlUUID = NULL;

                    if ($gadtl->count() < 1) {
                        /* CREATE REGISTRATION */
                        do {
                            $UUID = Str::uuid();
                        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                        $create_new_nm_registration = NonMemberRegistration::create([
                            'UUID' => $UUID,

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

                            'Type' => 'dog',
                            'PetUUID' => $PetUUID,
                        ]);

                        if ($create_new_nm_registration->save()) {
                            $adtlUUID = $UUID;
                        }
                    } else {
                        $gadtl = $gadtl->first();

                        $gadtl->MicrochipNo = $request->input('pet_microchip_no');
                        $gadtl->AgeInMonths = $request->input('pet_age');
                        $gadtl->VetClinicName = $request->input('pet_vet_name');
                        $gadtl->VetOnlineProfile = $request->input('pet_vet_url');
                        $gadtl->ShelterInfo = $request->input('pet_shelter');
                        $gadtl->ShelterOnlineProfile = $request->input('pet_shelter_url');
                        $gadtl->BreederInfo = $request->input('pet_breeder');
                        $gadtl->BreederOnlineProfile = $request->input('pet_breeder_url');
                        $gadtl->SireName = $request->input('pet_sirename');
                        $gadtl->SireBreed = $request->input('pet_sire_breed');
                        $gadtl->SireRegNo = $request->input('pet_sireregno');
                        $gadtl->DamName = $request->input('pet_damname');
                        $gadtl->DamBreed = $request->input('pet_dam_breed');
                        $gadtl->DamRegNo = $request->input('pet_damregno');

                        if ($gadtl->save()) {
                            $adtlUUID = $gadtl->UUID;
                        }
                    }

                    // UPDATE IMAGES
                    if (!empty($adtlUUID)) {

                        $nmr = NonMemberRegistration::where('UUID', '=', $adtlUUID);

                        if ($nmr->count() > 0) {
                            $nmr = $nmr->first();

                            if (!empty($nmr->FileToken)) {
                                $file_token = $nmr->FileToken;
                            } else {
                                $file_token = Str::uuid();
                                $nmr->FileToken = $file_token;
                            }

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
                                        $gsfd->token = $file_token;

                                        $nmr->$key = $file_uuid;

                                        $gsfd->save();
                                    }
                                }
                            }
                            $nmr->save();
                        }
                    }
                    return redirect()->back()->with('response','dog_updated');
                }
                else
                {
                    return redirect()->back()->with('response','dog_fail_update');
                }
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    /* ADD CAT */
    public function add_cat(Request $request)
    {
        if (!$request->has('petno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'petno' => 'required',
        ], [
            'petno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetCat_data = RegistryCat::where('PetNo', $request->input('petno'));
        if ($GetCat_data->count() > 0) {

            $gcd = $GetCat_data->first();

            if (empty($gcd->OwnerIAGDNo) && empty($gcd->OwnerUUID)) {
                $gcd->OwnerIAGDNo = Auth::guard('web')->user()->iagd_number;
                $gcd->OwnerUUID = Auth::guard('web')->user()->uuid;

                if ($gcd->save()) {
                    return redirect()->back()->with('response','cat_added');
                } else {
                    return redirect()->back()->with('response','error_cat_add');
                }
            } elseif ($gcd->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number && $gcd->Approval == 0) {
                return redirect()->back()->with('response','cat_approval_pending');
            } else {
                return redirect()->back()->with('response','cat_claimed');
            }

        } else {
            return redirect()->back()->with('response', 'cat_not_found');
        }
    }
    /* UPDATE USER CAT */
    public function update_cat(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_petno','pet_petname','pet_birthdate','pet_eyecolor','pet_petcolor','pet_markings','pet_location','pet_gender','pet_height','pet_weight','pet_owner'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_petno' => 'required',
            'pet_petname' => 'required',
            'pet_birthdate' => 'required',
            'pet_gender' => 'required',
            'pet_location' => 'required',
        ],[
            'pet_petno.required' => 'Something\'s wrong! Please try again.',
            'pet_petname.required' => 'Enter pet_petname',
            'pet_birthdate.required' => 'Enter pet_birthdate',
            'pet_gender.required' => 'Enter pet_gender',
            'pet_location.required' => 'Enter pet_location',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE CAT INFO */
        $GetPet_data = RegistryCat::where('PetNo', $request->input('pet_petno'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->PetName = $request->input('pet_petname');
            $gpd->BirthDate = $request->input('pet_birthdate');
            $gpd->EyeColor = $request->input('pet_eyecolor');
            $gpd->PetColor = $request->input('pet_petcolor');
            $gpd->Markings = $request->input('pet_markings');
            $gpd->Location = $request->input('pet_location');
            $gpd->Gender = $request->input('pet_gender');
            $gpd->Height = $request->input('pet_height');
            $gpd->Weight = $request->input('pet_weight');
            $gpd->Owner = $request->input('pet_owner');

            /* CHECK IF CAT DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gpd->save()) {
                return redirect()->back()->with('response','cat_updated');
            }
            else
            {
                return redirect()->back()->with('response','cat_fail_update');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function update_cat_unregistered(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            '_token',
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

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
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
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents'
                ) {
                return redirect()->back()->with('response', 'key_error');
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
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
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE CAT INFO */
        $GetPet_data = MembersCat::where('PetUUID', $request->input('pet_petuuid'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            if ($gpd->Status != 4) { // if petreg status not for user verification, don't proceed
                return redirect()->back()->with('response','cat_update_not_allowed');
            } else {
                $gpd->PetName = $request->input('pet_petname');
                $gpd->BirthDate = $request->input('pet_birthdate');
                $gpd->EyeColor = $request->input('pet_eyecolor');
                $gpd->PetColor = $request->input('pet_petcolor');
                $gpd->Markings = $request->input('pet_markings');
                $gpd->Location = $request->input('pet_location');
                $gpd->Gender = $request->input('pet_gender');
                $gpd->Height = $request->input('pet_height');
                $gpd->Weight = $request->input('pet_weight');
                $gpd->Co_Owner = $request->input('pet_co_owner');

                $gpd->Status = 1; // for user registration

                /* CHECK IF CAT DATA UPDATED THROW FLASH DATA RESPONSE */
                if ($gpd->save()) {

                    // CHECK IF ADTL DETAILS ALREADY EXISTS UPDATE DETAILS; IF NO CREATE DATA
                    $PetUUID = $request->input('pet_petuuid');
                    $gadtl = NonMemberRegistration::where('PetUUID', $PetUUID)->where('Type', 'cat');
                    $adtlUUID = NULL;

                    if ($gadtl->count() < 1) {
                        /* CREATE REGISTRATION */
                        do {
                            $UUID = Str::uuid();
                        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                        $create_new_nm_registration = NonMemberRegistration::create([
                            'UUID' => $UUID,

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

                            'Type' => 'cat',
                            'PetUUID' => $PetUUID,
                        ]);

                        if ($create_new_nm_registration->save()) {
                            $adtlUUID = $UUID;
                        }
                    } else {
                        $gadtl = $gadtl->first();

                        $gadtl->MicrochipNo = $request->input('pet_microchip_no');
                        $gadtl->AgeInMonths = $request->input('pet_age');
                        $gadtl->VetClinicName = $request->input('pet_vet_name');
                        $gadtl->VetOnlineProfile = $request->input('pet_vet_url');
                        $gadtl->ShelterInfo = $request->input('pet_shelter');
                        $gadtl->ShelterOnlineProfile = $request->input('pet_shelter_url');
                        $gadtl->BreederInfo = $request->input('pet_breeder');
                        $gadtl->BreederOnlineProfile = $request->input('pet_breeder_url');
                        $gadtl->SireName = $request->input('pet_sirename');
                        $gadtl->SireBreed = $request->input('pet_sire_breed');
                        $gadtl->SireRegNo = $request->input('pet_sireregno');
                        $gadtl->DamName = $request->input('pet_damname');
                        $gadtl->DamBreed = $request->input('pet_dam_breed');
                        $gadtl->DamRegNo = $request->input('pet_damregno');

                        if ($gadtl->save()) {
                            $adtlUUID = $gadtl->UUID;
                        }
                    }

                    // UPDATE IMAGES
                    if (!empty($adtlUUID)) {

                        $nmr = NonMemberRegistration::where('UUID', '=', $adtlUUID);

                        if ($nmr->count() > 0) {
                            $nmr = $nmr->first();

                            if (!empty($nmr->FileToken)) {
                                $file_token = $nmr->FileToken;
                            } else {
                                $file_token = Str::uuid();
                                $nmr->FileToken = $file_token;
                            }

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
                                        $gsfd->token = $file_token;

                                        $nmr->$key = $file_uuid;

                                        $gsfd->save();
                                    }
                                }
                            }
                            $nmr->save();
                        }
                    }
                    return redirect()->back()->with('response','cat_updated');
                }
                else
                {
                    return redirect()->back()->with('response','cat_fail_update');
                }
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    /* ADD RABBIT */
    public function add_rabbit(Request $request)
    {
        if (!$request->has('petno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'petno' => 'required',
        ], [
            'petno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetRabbit_data = RegistryRabbit::where('PetNo', $request->input('petno'));
        if ($GetRabbit_data->count() > 0) {

            $gdd = $GetRabbit_data->first();

            if (empty($gdd->OwnerIAGDNo) && empty($gdd->OwnerUUID)) {
                $gdd->OwnerIAGDNo = Auth::guard('web')->user()->iagd_number;
                $gdd->OwnerUUID = Auth::guard('web')->user()->uuid;

                if ($gdd->save()) {
                    return redirect()->back()->with('response','rabbit_added');
                } else {
                    return redirect()->back()->with('response','error_rabbit_add');
                }
            } elseif ($gdd->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number && $gdd->Approval == 0) {
                return redirect()->back()->with('response','rabbit_approval_pending');
            } else {
                return redirect()->back()->with('response','rabbit_claimed');
            }

        } else {
            return redirect()->back()->with('response', 'rabbit_not_found');
        }
    }
    /* UPDATE USER RABBIT */
    public function update_rabbit(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_petno','pet_petname','pet_eyecolor','pet_petcolor','pet_markings','pet_birthdate','pet_location','pet_gender','pet_height','pet_weight','pet_owner','pet_sirename','pet_damname','pet_breed'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_petno' => 'required',
            'pet_petname' => 'required',
            'pet_birthdate' => 'required',
            'pet_gender' => 'required',
            'pet_location' => 'required',
            'pet_breed' => 'required',
        ],[
            'pet_petno.required' => 'Something\'s wrong! Please try again.',
            'pet_petname.required' => 'Enter pet_petname',
            'pet_birthdate.required' => 'Enter pet_birthdate',
            'pet_gender.required' => 'Enter pet_gender',
            'pet_location.required' => 'Enter pet_location',
            'pet_breed.required' => 'Enter pet_breed',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE RABBIT INFO */
        $GetPet_data = RegistryRabbit::where('PetNo', $request->input('pet_petno'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->PetName = $request->input('pet_petname');
            $gpd->EyeColor = $request->input('pet_eyecolor');
            $gpd->PetColor = $request->input('pet_petcolor');
            $gpd->Markings = $request->input('pet_markings');
            $gpd->BirthDate = $request->input('pet_birthdate');
            $gpd->Location = $request->input('pet_location');
            $gpd->Gender = $request->input('pet_gender');
            $gpd->Height = $request->input('pet_height');
            $gpd->Weight = $request->input('pet_weight');
            $gpd->Owner = $request->input('pet_owner');
            $gpd->SireName = $request->input('pet_sirename');
            $gpd->DamName = $request->input('pet_damname');
            $gpd->Breed = $request->input('pet_breed');

            /* CHECK IF RABBIT DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gpd->save()) {
                return redirect()->back()->with('response','rabbit_updated');
            }
            else
            {
                return redirect()->back()->with('response','rabbit_fail_update');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function update_rabbit_unregistered(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            '_token',
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

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
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
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents'
                ) {
                return redirect()->back()->with('response', 'key_error');
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
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
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE RABBIT INFO */
        $GetPet_data = MembersRabbit::where('PetUUID', $request->input('pet_petuuid'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            if ($gpd->Status != 4) { // if petreg status not for user verification, don't proceed
                return redirect()->back()->with('response','rabbit_update_not_allowed');
            } else {
                $gpd->PetName = $request->input('pet_petname');
                $gpd->EyeColor = $request->input('pet_eyecolor');
                $gpd->PetColor = $request->input('pet_petcolor');
                $gpd->Markings = $request->input('pet_markings');
                $gpd->BirthDate = $request->input('pet_birthdate');
                $gpd->Location = $request->input('pet_location');
                $gpd->Gender = ($request->input('pet_gender') == 0 ? 'male' : 'female');
                $gpd->Height = $request->input('pet_height');
                $gpd->Weight = $request->input('pet_weight');
                $gpd->SireName = $request->input('pet_sirename');
                $gpd->DamName = $request->input('pet_damname');
                $gpd->Breed = $request->input('pet_breed');
                $gpd->Co_Owner = $request->input('pet_co_owner');

                $gpd->Status = 1; // for user registration

                /* CHECK IF RABBIT DATA UPDATED THROW FLASH DATA RESPONSE */
                if ($gpd->save()) {

                    // CHECK IF ADTL DETAILS ALREADY EXISTS UPDATE DETAILS; IF NO CREATE DATA
                    $PetUUID = $request->input('pet_petuuid');
                    $gadtl = NonMemberRegistration::where('PetUUID', $PetUUID)->where('Type', 'rabbit');
                    $adtlUUID = NULL;

                    if ($gadtl->count() < 1) {
                        /* CREATE REGISTRATION */
                        do {
                            $UUID = Str::uuid();
                        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                        $create_new_nm_registration = NonMemberRegistration::create([
                            'UUID' => $UUID,

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

                            'Type' => 'rabbit',
                            'PetUUID' => $PetUUID,
                        ]);

                        if ($create_new_nm_registration->save()) {
                            $adtlUUID = $UUID;
                        }
                    } else {
                        $gadtl = $gadtl->first();

                        $gadtl->MicrochipNo = $request->input('pet_microchip_no');
                        $gadtl->AgeInMonths = $request->input('pet_age');
                        $gadtl->VetClinicName = $request->input('pet_vet_name');
                        $gadtl->VetOnlineProfile = $request->input('pet_vet_url');
                        $gadtl->ShelterInfo = $request->input('pet_shelter');
                        $gadtl->ShelterOnlineProfile = $request->input('pet_shelter_url');
                        $gadtl->BreederInfo = $request->input('pet_breeder');
                        $gadtl->BreederOnlineProfile = $request->input('pet_breeder_url');
                        $gadtl->SireName = $request->input('pet_sirename');
                        $gadtl->SireBreed = $request->input('pet_sire_breed');
                        $gadtl->SireRegNo = $request->input('pet_sireregno');
                        $gadtl->DamName = $request->input('pet_damname');
                        $gadtl->DamBreed = $request->input('pet_dam_breed');
                        $gadtl->DamRegNo = $request->input('pet_damregno');

                        if ($gadtl->save()) {
                            $adtlUUID = $gadtl->UUID;
                        }
                    }

                    // UPDATE IMAGES
                    if (!empty($adtlUUID)) {

                        $nmr = NonMemberRegistration::where('UUID', '=', $adtlUUID);

                        if ($nmr->count() > 0) {
                            $nmr = $nmr->first();

                            if (!empty($nmr->FileToken)) {
                                $file_token = $nmr->FileToken;
                            } else {
                                $file_token = Str::uuid();
                                $nmr->FileToken = $file_token;
                            }

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
                                        $gsfd->token = $file_token;

                                        $nmr->$key = $file_uuid;

                                        $gsfd->save();
                                    }
                                }
                            }
                            $nmr->save();
                        }
                    }
                    return redirect()->back()->with('response','rabbit_updated');
                }
                else
                {
                    return redirect()->back()->with('response','rabbit_fail_update');
                }
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    /* ADD BIRD */
    public function add_bird(Request $request)
    {
        if (!$request->has('petno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'petno' => 'required',
        ], [
            'petno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetBird_data = RegistryBird::where('PetNo', $request->input('petno'));
        if ($GetBird_data->count() > 0) {

            $gdd = $GetBird_data->first();

            if (empty($gdd->OwnerIAGDNo) && empty($gdd->OwnerUUID)) {
                $gdd->OwnerIAGDNo = Auth::guard('web')->user()->iagd_number;
                $gdd->OwnerUUID = Auth::guard('web')->user()->uuid;

                if ($gdd->save()) {
                    return redirect()->back()->with('response','bird_added');
                } else {
                    return redirect()->back()->with('response','error_bird_add');
                }
            } elseif ($gdd->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number && $gdd->Approval == 0) {
                return redirect()->back()->with('response','bird_approval_pending');
            } else {
                return redirect()->back()->with('response','bird_claimed');
            }

        } else {
            return redirect()->back()->with('response', 'bird_not_found');
        }
    }
    /* UPDATE USER BIRD */
    public function update_bird(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_petno','pet_petname','pet_eyecolor','pet_petcolor','pet_markings','pet_birthdate','pet_location','pet_gender','pet_height','pet_weight','pet_owner','pet_co_owner'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_petno' => 'required',
            'pet_petname' => 'required',
            'pet_birthdate' => 'required',
            'pet_gender' => 'required',
            'pet_location' => 'required',
        ],[
            'pet_petno.required' => 'Something\'s wrong! Please try again.',
            'pet_petname.required' => 'Enter pet_petname',
            'pet_birthdate.required' => 'Enter pet_birthdate',
            'pet_gender.required' => 'Enter pet_gender',
            'pet_location.required' => 'Enter pet_location',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE BIRD INFO */
        $GetPet_data = RegistryBird::where('PetNo', $request->input('pet_petno'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->PetName = $request->input('pet_petname');
            $gpd->EyeColor = $request->input('pet_eyecolor');
            $gpd->PetColor = $request->input('pet_petcolor');
            $gpd->Markings = $request->input('pet_markings');
            $gpd->BirthDate = $request->input('pet_birthdate');
            $gpd->Location = $request->input('pet_location');
            $gpd->Gender = $request->input('pet_gender');
            $gpd->Height = $request->input('pet_height');
            $gpd->Weight = $request->input('pet_weight');
            $gpd->Owner = $request->input('pet_owner');
            $gpd->Co_Owner = $request->input('pet_co_owner');

            /* CHECK IF BIRD DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gpd->save()) {
                return redirect()->back()->with('response','bird_updated');
            }
            else
            {
                return redirect()->back()->with('response','bird_fail_update');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function update_bird_unregistered(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            '_token',
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

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
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
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents'
                ) {
                return redirect()->back()->with('response', 'key_error');
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
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
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE BIRD INFO */
        $GetPet_data = MembersBird::where('PetUUID', $request->input('pet_petuuid'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            if ($gpd->Status != 4) { // if petreg status not for user verification, don't proceed
                return redirect()->back()->with('response','bird_update_not_allowed');
            } else {
                $gpd->PetName = $request->input('pet_petname');
                $gpd->EyeColor = $request->input('pet_eyecolor');
                $gpd->PetColor = $request->input('pet_petcolor');
                $gpd->Markings = $request->input('pet_markings');
                $gpd->BirthDate = $request->input('pet_birthdate');
                $gpd->Location = $request->input('pet_location');
                $gpd->Gender = ($request->input('pet_gender') == 0 ? 'male' : 'female');
                $gpd->Height = $request->input('pet_height');
                $gpd->Weight = $request->input('pet_weight');
                $gpd->Co_Owner = $request->input('pet_co_owner');

                $gpd->Status = 1; // for user registration

                /* CHECK IF BIRD DATA UPDATED THROW FLASH DATA RESPONSE */
                if ($gpd->save()) {

                    // CHECK IF ADTL DETAILS ALREADY EXISTS UPDATE DETAILS; IF NO CREATE DATA
                    $PetUUID = $request->input('pet_petuuid');
                    $gadtl = NonMemberRegistration::where('PetUUID', $PetUUID)->where('Type', 'bird');
                    $adtlUUID = NULL;

                    if ($gadtl->count() < 1) {
                        /* CREATE REGISTRATION */
                        do {
                            $UUID = Str::uuid();
                        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                        $create_new_nm_registration = NonMemberRegistration::create([
                            'UUID' => $UUID,

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

                            'Type' => 'bird',
                            'PetUUID' => $PetUUID,
                        ]);

                        if ($create_new_nm_registration->save()) {
                            $adtlUUID = $UUID;
                        }
                    } else {
                        $gadtl = $gadtl->first();

                        $gadtl->MicrochipNo = $request->input('pet_microchip_no');
                        $gadtl->AgeInMonths = $request->input('pet_age');
                        $gadtl->VetClinicName = $request->input('pet_vet_name');
                        $gadtl->VetOnlineProfile = $request->input('pet_vet_url');
                        $gadtl->ShelterInfo = $request->input('pet_shelter');
                        $gadtl->ShelterOnlineProfile = $request->input('pet_shelter_url');
                        $gadtl->BreederInfo = $request->input('pet_breeder');
                        $gadtl->BreederOnlineProfile = $request->input('pet_breeder_url');
                        $gadtl->SireName = $request->input('pet_sirename');
                        $gadtl->SireBreed = $request->input('pet_sire_breed');
                        $gadtl->SireRegNo = $request->input('pet_sireregno');
                        $gadtl->DamName = $request->input('pet_damname');
                        $gadtl->DamBreed = $request->input('pet_dam_breed');
                        $gadtl->DamRegNo = $request->input('pet_damregno');

                        if ($gadtl->save()) {
                            $adtlUUID = $gadtl->UUID;
                        }
                    }

                    // UPDATE IMAGES
                    if (!empty($adtlUUID)) {

                        $nmr = NonMemberRegistration::where('UUID', '=', $adtlUUID);

                        if ($nmr->count() > 0) {
                            $nmr = $nmr->first();

                            if (!empty($nmr->FileToken)) {
                                $file_token = $nmr->FileToken;
                            } else {
                                $file_token = Str::uuid();
                                $nmr->FileToken = $file_token;
                            }

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
                                        $gsfd->token = $file_token;

                                        $nmr->$key = $file_uuid;

                                        $gsfd->save();
                                    }
                                }
                            }
                            $nmr->save();
                        }
                    }
                    return redirect()->back()->with('response','bird_updated');
                }
                else
                {
                    return redirect()->back()->with('response','bird_fail_update');
                }
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }

    /* ADD OTHER ANIMAL */
    public function add_other_animal(Request $request)
    {
        if (!$request->has('petno')) {
            return redirect()->back()->with('response', 'key_error');
        }
        $validate = Validator::make($request->all(), [
            'petno' => 'required',
        ], [
            'petno.required' => 'Something\'s wrong! Please try again',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $GetOtherAnimal_data = RegistryOtherAnimal::where('PetNo', $request->input('petno'));
        if ($GetOtherAnimal_data->count() > 0) {

            $gdd = $GetOtherAnimal_data->first();

            if (empty($gdd->OwnerIAGDNo) && empty($gdd->OwnerUUID)) {
                $gdd->OwnerIAGDNo = Auth::guard('web')->user()->iagd_number;
                $gdd->OwnerUUID = Auth::guard('web')->user()->uuid;

                if ($gdd->save()) {
                    return redirect()->back()->with('response','other_animal_added');
                } else {
                    return redirect()->back()->with('response','error_other_animal_add');
                }
            } elseif ($gdd->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number && $gdd->Approval == 0) {
                return redirect()->back()->with('response','other_animal_approval_pending');
            } else {
                return redirect()->back()->with('response','other_animal_claimed');
            }

        } else {
            return redirect()->back()->with('response', 'other_animal_not_found');
        }
    }
    /* UPDATE USER OTHER ANIMAL */
    public function update_other_animal(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','pet_petno','pet_petname','pet_animaltype','pet_commonname','pet_familystrain','pet_sizelength','pet_sizewidth','pet_sizeheight','pet_weight','pet_colormarking'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'pet_petno' => 'required',
            'pet_petname' => 'required',
            'pet_animaltype' => 'required',
            'pet_commonname' => 'required',
            'pet_familystrain' => 'required',
        ],[
            'pet_petno.required' => 'Something\'s wrong! Please try again.',
            'pet_petname.required' => 'Enter pet_petname',
            'pet_animaltype.required' => 'Enter pet_animaltype',
            'pet_commonname.required' => 'Enter pet_commonname',
            'pet_familystrain.required' => 'Enter pet_familystrain',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE OTHER ANIMAL INFO */
        $GetPet_data = RegistryOtherAnimal::where('PetNo', $request->input('pet_petno'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid)
                                ->orWhere('OwnerIAGDNo', (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : 'NONE'))
                                ->where('Approval', 1);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->PetName = $request->input('pet_petname');
            $gpd->AnimalType = $request->input('pet_animaltype');
            $gpd->CommonName = $request->input('pet_commonname');
            $gpd->FamilyStrain = $request->input('pet_familystrain');
            $gpd->SizeLength = $request->input('pet_sizelength');
            $gpd->SizeWidth = $request->input('pet_sizewidth');
            $gpd->SizeHeight = $request->input('pet_sizeheight');
            $gpd->Weight = $request->input('pet_weight');
            $gpd->ColorMarking = $request->input('pet_colormarking');

            /* CHECK IF OTHER ANIMAL DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gpd->save()) {
                return redirect()->back()->with('response','other_animal_updated');
            }
            else
            {
                return redirect()->back()->with('response','other_animal_fail_update');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function update_other_animal_unregistered(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            '_token',
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

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
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
        $key_arr = array_merge($key_arr, $key_arr_adtl_info);

        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)
                 && $value != 'pet_image'
                 && $value != 'pet_sire_image'
                 && $value != 'pet_dam_image'
                 && $value != 'pet_supporting_documents'
                 && $value != 'pet_vet_record_documents'
                 && $value != 'pet_sire_supporting_documents'
                 && $value != 'pet_dam_supporting_documents'
                ) {
                return redirect()->back()->with('response', 'key_error');
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate_vars_registration_contact = [
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
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE OTHER ANIMAL INFO */
        $GetPet_data = MembersOtherAnimal::where('PetUUID', $request->input('pet_petuuid'))
                                ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            if ($gpd->Status != 4) { // if petreg status not for user verification, don't proceed
                return redirect()->back()->with('response','other_animal_update_not_allowed');
            } else {
                $gpd->PetName = $request->input('pet_petname');
                $gpd->AnimalType = $request->input('pet_animaltype');
                $gpd->CommonName = $request->input('pet_commonname');
                $gpd->FamilyStrain = $request->input('pet_familystrain');
                $gpd->SizeLength = $request->input('pet_sizelength');
                $gpd->SizeWidth = $request->input('pet_sizewidth');
                $gpd->SizeHeight = $request->input('pet_sizeheight');
                $gpd->Weight = $request->input('pet_weight');
                $gpd->ColorMarking = $request->input('pet_colormarking');
                $gpd->Co_Owner = $request->input('pet_co_owner');

                $gpd->Status = 1; // for user registration

                /* CHECK IF OTHER ANIMAL DATA UPDATED THROW FLASH DATA RESPONSE */
                if ($gpd->save()) {

                    // CHECK IF ADTL DETAILS ALREADY EXISTS UPDATE DETAILS; IF NO CREATE DATA
                    $PetUUID = $request->input('pet_petuuid');
                    $gadtl = NonMemberRegistration::where('PetUUID', $PetUUID)->where('Type', 'other');
                    $adtlUUID = NULL;

                    if ($gadtl->count() < 1) {

                        /* CREATE REGISTRATION */
                        do {
                            $UUID = Str::uuid();
                        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);

                        $create_new_nm_registration = NonMemberRegistration::create([
                            'UUID' => $UUID,

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

                            'Type' => 'other',
                            'PetUUID' => $PetUUID,
                        ]);

                        if ($create_new_nm_registration->save()) {
                            $adtlUUID = $UUID;
                        }
                    } else {

                        $gadtl = $gadtl->first();

                        $gadtl->MicrochipNo = $request->input('pet_microchip_no');
                        $gadtl->AgeInMonths = $request->input('pet_age');
                        $gadtl->VetClinicName = $request->input('pet_vet_name');
                        $gadtl->VetOnlineProfile = $request->input('pet_vet_url');
                        $gadtl->ShelterInfo = $request->input('pet_shelter');
                        $gadtl->ShelterOnlineProfile = $request->input('pet_shelter_url');
                        $gadtl->BreederInfo = $request->input('pet_breeder');
                        $gadtl->BreederOnlineProfile = $request->input('pet_breeder_url');
                        $gadtl->SireName = $request->input('pet_sirename');
                        $gadtl->SireBreed = $request->input('pet_sire_breed');
                        $gadtl->SireRegNo = $request->input('pet_sireregno');
                        $gadtl->DamName = $request->input('pet_damname');
                        $gadtl->DamBreed = $request->input('pet_dam_breed');
                        $gadtl->DamRegNo = $request->input('pet_damregno');

                        if ($gadtl->save()) {
                            $adtlUUID = $gadtl->UUID;
                        }
                    }

                    // UPDATE IMAGES
                    if (!empty($adtlUUID)) {

                        $nmr = NonMemberRegistration::where('UUID', '=', $adtlUUID);

                        if ($nmr->count() > 0) {
                            $nmr = $nmr->first();

                            if (!empty($nmr->FileToken)) {
                                $file_token = $nmr->FileToken;
                            } else {
                                $file_token = Str::uuid();
                                $nmr->FileToken = $file_token;
                            }

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
                                        $gsfd->token = $file_token;

                                        $nmr->$key = $file_uuid;

                                        $gsfd->save();
                                    }
                                }
                            }
                            $nmr->save();
                        }
                    }
                    return redirect()->back()->with('response','other_animal_updated');
                }
                else
                {
                    return redirect()->back()->with('response','other_animal_fail_update');
                }
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }

    /* PASSWORD RESET UPDATE */

    public function update_new_password(Request $request)
    {
        /* CHECK IF KEYS ARE VALID */
        if (!$request->has('pass1') || !$request->has('pass2')) {
            $data = [
                'status' => 'key_not_set',
                'message' => 'Something went wrong',
            ];
            return response()->json($data);
        }

        /* VALIDATE INPUT */
        $validate = Validator::make($request->all(),[
            'pass1' => 'required',
            'pass2' => 'required',
        ],[
            'pass1.required' => 'Enter your new password',
            'pass2.required' => 'Enter your new password',
        ]);
        if ($validate->fails()) {
            $data = [
                'status' => 'required_pass',
                'message' => $validate->errors()->first(),
            ];
            return response()->json($data);
        }
        /* CHECK SESSIOn */
        if (!$request->session()->has('pass_change')) {
            $data = [
                'status' => 'invalid_pass_change',
                'message' => 'Please send a new password reset request',
            ];
            return response()->json($data);
        }
        /* CHECK USER */
        $id = $request->session()->get('pass_change.user_id');
        $token = $request->session()->get('pass_change.token');

        $member = MembersModel::where('id',$id);

        if ($member->exists()) {
            $mem = $member->first();

            /* CHECK EMAIL VALIDATION */
            $verify_email = EmailVerification::where('email_address','=',$mem->email_address);
            if (!$verify_email->count() > 0 || !$verify_email->first()->verified == 1) {
                $data = [
                    'status' => 'not_verified',
                    'message' => 'Please verify your email address',
                ];
                return response()->json($data);
            }
            /* CHECK IF PASSWORD RESET IS VALID */
            $CheckResetPass = ResetPassword::where('email_address','=',$mem->email_address)->where('token','=',$token);
            $crp = $CheckResetPass->first();

            /* PASSWORD RESET DOESNT EXIST */
            if (!$CheckResetPass->count() > 0) {
                $data = [
                    'status' => 'request_null',
                    'message' => 'Please send a password reset request',
                ];
                return response()->json($data);
            }

            /* CHECK REQUEST VALIDITY */

            $time_elapse = (time() - $crp->expiration);

            if ($time_elapse > 600) { // GREATER THAN 600 INVALID PASSWORD RESET REQUEST
                $data = [
                    'status' => 'page_expired',
                    'message' => 'Please send a new password reset request',
                ];
                return response()->json($data);
            }

            $pass1 = $request->input('pass1');
            $pass2 = $request->input('pass2');
            if ($request->input('timez')) {
                $up_at = Carbon::now();
            }
            else
            {
                $up_at = Carbon::now();
            }
            /* COMPARE PASSWORD */
            if ($pass1 !== $pass2) {
                $data = [
                    'status' => 'pass_not_matched',
                    'message' => 'Password did not matched',
                ];
                return response()->json($data);
            }

            $mu = MembersModel::find($id);

            $mu->password = Hash::make($pass2);
            $mu->updated_at = $up_at;

            if ($mu->save()) {

                DB::table('members_password_reset')
                ->where('email_address', $mem->email_address)
                ->limit(1)
                ->update(array(
                    'token' => null,
                    'expiration' => time(),
                    'updated_at' => $up_at
                ));

                $data = [
                    'status' => 'password_reset',
                    'message' => 'Password changed. Use your new password when you login',
                    'redirectTo' => route('user.login'),
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 'failed_to_reset',
                    'message' => 'Password changed failed',
                ];
                return response()->json($data);
            }

        }
        else
        {
            $data = [
                'status' => 'user_not_found',
                'message' => 'Invalid user request',
            ];
            return response()->json($data);
        }
    }
    /* UPDATE USER ADVERTIsEMENT */
    public function update_advertisement(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['_token','ad_uuid','ad_title','ad_message','file_path'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'ad_uuid' => 'required',
            'ad_title' => 'required',
            'ad_message' => 'required',
            'file_path' => 'image|mimes:jpg,png,jpeg,gif',
        ],[
            'ad_uuid.required' => 'Something\'s wrong! Please try again.',
            'ad_title.required' => 'Enter ad_title',
            'ad_message.required' => 'Enter ad_message',
            'file_path.image' => 'Uploaded file is not an image',
            'file_path.mimes' => 'Acceptable file format is jpg , png , jpeg or gif',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* UPDATE AD INFO */
        $GetAd_data = MembersAd::where('uuid', $request->input('ad_uuid'))
                                ->where('member_uuid', Auth::guard('web')->user()->uuid);
        if ($GetAd_data->count() > 0) {

            $gad = $GetAd_data->first();

            $gad->title = $request->input('ad_title');
            $gad->message = $request->input('ad_message');

            // UPLOAD IMAGE
            if ($request->hasFile('file_path')) {

                if (File::exists($gad->file_path)) {
                    File::delete($gad->file_path);
                }

                $file = $request->file('file_path');

                $file_name = 'ad_file_' . $gad->uuid . '_' . time();
                $ad_img_path = 'uploads/advertisements/' . $gad->uuid . '/' . $file_name . '.' . $file->extension();

                $file->move(public_path('uploads/advertisements/' . $gad->uuid), $ad_img_path);

                $gad->file_path = $ad_img_path;
            }

            /* CHECK IF AD DATA UPDATED THROW FLASH DATA RESPONSE */
            if ($gad->save()) {
                return redirect()->back()->with('response','ad_updated');
            }
            else
            {
                return redirect()->back()->with('response','ad_fail_update');
            }
        } else {
            return redirect()->back()->with('response','ad_not_found');
        }
    }


    // CANCEL PET REGISTRATION
    public function cancel_dog_registration($petuuid)
    {
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* UPDATE DOG INFO */
        $GetPet_data = MembersDog::where('PetUUID', $petuuid)
            ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Status = 0; // deleted registration status

            if ($gpd->save()) {
                return redirect()->back()->with('response','registration_cancel_success');
            }
            else
            {
                return redirect()->back()->with('response','registration_cancel_fail');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function cancel_cat_registration($petuuid)
    {
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* UPDATE CAT INFO */
        $GetPet_data = MembersCat::where('PetUUID', $petuuid)
            ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Status = 0; // deleted registration status

            if ($gpd->save()) {
                return redirect()->back()->with('response','registration_cancel_success');
            }
            else
            {
                return redirect()->back()->with('response','registration_cancel_fail');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function cancel_rabbit_registration($petuuid)
    {
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* UPDATE RABBIT INFO */
        $GetPet_data = MembersRabbit::where('PetUUID', $petuuid)
            ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Status = 0; // deleted registration status

            if ($gpd->save()) {
                return redirect()->back()->with('response','registration_cancel_success');
            }
            else
            {
                return redirect()->back()->with('response','registration_cancel_fail');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function cancel_bird_registration($petuuid)
    {
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* UPDATE BIRD INFO */
        $GetPet_data = MembersBird::where('PetUUID', $petuuid)
            ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Status = 0; // deleted registration status

            if ($gpd->save()) {
                return redirect()->back()->with('response','registration_cancel_success');
            }
            else
            {
                return redirect()->back()->with('response','registration_cancel_fail');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }
    public function cancel_other_animal_registration($petuuid)
    {
        if (empty($petuuid)) {
            return redirect()->back()->with('response', 'key_error');
        }

        /* UPDATE OTHER ANIMAL INFO */
        $GetPet_data = MembersOtherAnimal::where('PetUUID', $petuuid)
            ->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Status = 0; // deleted registration status

            if ($gpd->save()) {
                return redirect()->back()->with('response','registration_cancel_success');
            }
            else
            {
                return redirect()->back()->with('response','registration_cancel_fail');
            }
        } else {
            return redirect()->back()->with('response','pet_not_found');
        }
    }

    public function toggle_pet_visibility(Request $request) {
        /* STORE KEYS TO ARRAY */
        $key_arr = [
            'pet_no',
            'pet_uuid',
            'pet_type',
            'visibility',
        ];

        /* VALIDATE INPUTS */
        $validate_vars = [
            'pet_type' => 'required',
            'visibility' => 'required',
        ];
        $validate_messages = [
            'pet_type.required' => 'Gender is required.',
            'visibility.required' => 'Pet breed is required.',
        ];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($key_arr as $key => $value) {
            if (!$request->has($value)) {
                $data = [
                    'custom_alert' => 'error',
                    'status' => 'key_error',
                    'message' => 'Something\'s wrong, Please refresh the page.'.$value,
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
            }
        }

        /* THROW ERROR IF VALIDATION FAILED */
        $validate = Validator::make($request->all(),$validate_vars,$validate_messages);
        if ($validate->fails()) {
            $data = [
                'custom_alert' => 'error',
                'status' => 'validation_error',
                'message' => $validate->errors()->first(),
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
        }

        // check visibility val if valid
        if ($request->input('visibility') != 'public' && $request->input('visibility') != 'private') {
            $data = [
                'custom_alert' => 'error',
                'status' => 'value_error',
                'message' => 'Invalid value.',
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
        }
        /* UPDATE PET INFO */
        switch ($request->input('pet_type')) {
            case 'dog_reg': $GetPet_data = RegistryDog::where('PetNo', $request->input('pet_no')); break;
            case 'cat_reg': $GetPet_data = RegistryCat::where('PetNo', $request->input('pet_no')); break;
            case 'rabbit_reg': $GetPet_data = RegistryRabbit::where('PetNo', $request->input('pet_no')); break;
            case 'bird_reg': $GetPet_data = RegistryBird::where('PetNo', $request->input('pet_no')); break;
            case 'other_animal_reg': $GetPet_data = RegistryOtherAnimal::where('PetNo', $request->input('pet_no')); break;
            case 'dog_mem': $GetPet_data = MembersDog::where('PetUUID', $request->input('pet_uuid')); break;
            case 'cat_mem': $GetPet_data = MembersCat::where('PetUUID', $request->input('pet_uuid')); break;
            case 'rabbit_mem': $GetPet_data = MembersRabbit::where('PetUUID', $request->input('pet_uuid')); break;
            case 'bird_mem': $GetPet_data = MembersBird::where('PetUUID', $request->input('pet_uuid')); break;
            case 'other_animal_mem': $GetPet_data = MembersOtherAnimal::where('PetUUID', $request->input('pet_uuid')); break;
        }
        $GetPet_data->where('OwnerUUID', Auth::guard('web')->user()->uuid);
        if ($GetPet_data->count() > 0) {

            $gpd = $GetPet_data->first();

            $gpd->Visibility = ($request->input('visibility') == 'public' ? 1 : 0); // 0=private;1=public;

            if ($gpd->save()) {
                $data = [
                    'custom_alert' => 'success',
                    'status' => 'visibility_toggle_success',
                    'message' => 'Visibility toggle successful!',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
            }
            else
            {
                $data = [
                    'custom_alert' => 'warning',
                    'status' => 'visibility_toggle_fail',
                    'message' => 'Failed to register',
                ];
                if ($request->ajax()) {
                    return response()->json($data);
                }
            }
        } else {
            $data = [
                'custom_alert' => 'warning',
                'status' => 'pet_not_found',
                'message' => 'Pet not found.',
            ];
            if ($request->ajax()) {
                return response()->json($data);
            }
        }
    }
}

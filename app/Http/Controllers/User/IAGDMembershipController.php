<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;
use Auth;

/* User models */
use App\Models\Users\IagdDetails;
use App\Models\Users\IagdDetailsUploads;
use App\Models\Users\MembersModel;
use App\Models\Users\IagdDetailsComission;


class IAGDMembershipController extends Controller
{
    public function be_a_member(Request $request)
    {
        $data = array(
            'title' => 'Upgrade your IAGD membership | IAGD Members Lounge',
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/user_be_a_member', ['data' => $data]);
    }

    /* Ajax function register as a member */
    public function register_as_a_member(Request $request)
    {
        /* Validate request */
        $validate = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required',
            'address' => 'required',
            'ship_address' => 'required',
            'near_lblc' => 'required',
            'name_card' => 'required',
            'membership_package' => 'required|in:0,1,2',
            'valid_id.*' => 'mimes:jpg,jpeg,png,gif,bmp',
            'clear_11image.*' => 'mimes:jpg,jpeg,png,gif,bmp',
            'payment_proof.*' => 'mimes:jpg,jpeg,png,gif,bmp',
        ],[
            'first_name.required' => 'Enter your first name',
            'last_name.required' => 'Enter your last name',
            'email_address.required' => 'Enter your email address',
            'email_address.email' => 'Enter a valid email address',
            'contact_number.required' => 'Enter your contact number',
            'address.required' => 'Enter your address',
            'ship_address.required' => 'Enter your shipping address',
            'near_lblc.required' => 'Enter the nearest LBC branch in your location',
            'name_card.required' => 'Enter your ID card display name',
            'membership_package.required' => 'Please select a membership package.',
            'membership_package.in' => 'Invalid membership package.',

            'valid_id.*.mimes' => 'Valid ID acceptable image format: JPG , JPEG , PNG , BMP or GIF',
            'clear_11image.*.mimes' => '1x1 acceptable image format: JPG , JPEG , PNG , BMP or GIF',
            'payment_proof.*.mimes' => 'Payment proof acceptable image format: JPG , JPEG , PNG , BMP or GIF',

        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ];
            return response()->json($data);
        }

        /* Null and Max upload validation  */
        // if ($request->totaValidIDs > 3 || $request->totaValidIDs < 1) {
        //     $data = [
        //         'status' => 'error',
        //         'message' => 'Max 3 valid ID can be uploaded',
        //     ];
        //     return response()->json($data);
        // }

        // if ($request->totalClear_11image > 2 || $request->totalClear_11image < 1) {
        //     $data = [
        //         'status' => 'error',
        //         'message' => 'Max 2 clear 1x1 image can be uploaded',
        //     ];
        //     return response()->json($data);
        // }

        /* Check width and height if equal image should be 1x1 or 2x2 */
        // foreach ($request->clear_11image as $row) {
        //     $imgSize1x1 = getimagesize($row);
        //     $width = $imgSize1x1[0];
        //     $height = $imgSize1x1[1];
        //     if ($width != $height) {
        //         $data = [
        //             'status' => 'error',
        //             'message' => 'Upload 1x1 image size. You uploaded an image with height '.$height.'px and width '.$width.'px',
        //         ];
        //         return response()->json($data);
        //     }
        // }

        // if ($request->totalpayment_proof > 2 || $request->totalpayment_proof < 1) {
        //     $data = [
        //         'status' => 'error',
        //         'message' => 'Max 2 payment proof can be uploaded',
        //     ];
        //     return response()->json($data);
        // }


        /* TODO : Transaction remove registration if user upload failed*/

        /* Check if user has a registration pending */
        $user_uuid = Auth::guard('web')->user()->uuid;

        $CheckRegistration = IagdDetails::where('user_uuid',$user_uuid);
        $cRegis = $CheckRegistration->first();

        if ($CheckRegistration->count() > 0) {
            /* if user has registration check if verified */
            if ($cRegis->status == 1) {
                $data = [
                    'status' => 'warning',
                    'message' => 'You\'re already a verified member',
                ];
                return response()->json($data);
            }
            if ($cRegis->status == 0) {
                $data = [
                    'status' => 'info',
                    'message' => 'We received your registration. Please wait while we review your application.',
                ];
                return response()->json($data);
            }
        }

        /* CHECK IF REFERRAL CODE IS IAGD # */
        $referred_by_uuid = NULL;
        if (!empty($request->input('referral_code'))) {
            $check_referral_iagd_no = MembersModel::where('iagd_number', $request->input('referral_code'));
            if ($check_referral_iagd_no->count() > 0) {
                /* SET REFERRED BY AS UUID IF CODE IS IAGD# */
                $referred_by_uuid = $check_referral_iagd_no->first()->uuid;
            }
        }

        /* Upload all images to temporary folder */
        $folderPath = public_path('img/user/' . Auth::guard('web')->user()->uuid . '/temporary/images');
        $storePath = public_path('img/user/' . Auth::guard('web')->user()->uuid . '/registration_uploads');
        $fileDbPath = 'img/user/' . Auth::guard('web')->user()->uuid . '/registration_uploads';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        if (!file_exists($storePath)) {
            mkdir($storePath, 0777, true);
        }

        /* Wrap with try to catch error during uploads */
        try {

            if ($request->file('valid_id') != null) {
                foreach($request->file('valid_id') as $valid_id)
                {
                    $filename = 'vid-'.Auth::guard('web')->user()->uuid.'-'.time().'.'.$valid_id->extension();
                    $valid_id->move($folderPath, $filename);
                    $valid_ids[] = $filename;
                }
            }

            if ($request->file('clear_11image') != null) {
                foreach($request->file('clear_11image') as $clear_11image)
                {
                    $filename = 'oxo-'.Auth::guard('web')->user()->uuid.'-'.time().'.'.$clear_11image->extension();
                    $clear_11image->move($folderPath, $filename);
                    $clear_11images[] = $filename;
                }
            }

            if ($request->file('payment_proof') != null) {
                foreach($request->file('payment_proof') as $payment_proof)
                {
                    $filename = 'pp-'.Auth::guard('web')->user()->uuid.'-'.time().'.'.$payment_proof->extension();
                    $payment_proof->move($folderPath, $filename);
                    $payment_proofs[] = $filename;
                }
            }

        } catch (\Throwable $th) {
            /* If upload got errors remove temporary files and throw error response */

            /* Remove vaild ids */
            if ($valid_ids > 0) {
                foreach ($valid_ids as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }
            /* Remove 1x1 image */
            if ($clear_11images > 0) {
                foreach ($clear_11images as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }
            /* Remove payment proofs */
            if ($payment_proofs > 0) {
                foreach ($payment_proofs as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }

            $data = [
                'status' => 'error',
                'message' => 'Error encounter while uploading. Please try again!',
            ];
            return response()->json($data);
        }

        /* SET REGISTRATION UUID */
        do {
            $registration_uuid = Str::uuid();
        } while (IagdDetails::where("registration_uuid", $registration_uuid)->first() instanceof IagdDetails);


        /* If upload images is successfull ? insert new record and move files from temporary folder to permanent */
        /* Insert new record */
        $CreateNewRegistration = IagdDetails::create([
            'registration_uuid' => $registration_uuid,
            'user_uuid' => $user_uuid,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_initial' => $request->input('middle_initial'),
            'email_address' => $request->input('email_address'),
            'contact_number' => $request->input('contact_number'),

            'address' => $request->input('address'),
            'shipping_address' => $request->input('ship_address'),

            'nearest_lbc_branch' => $request->input('near_lblc'),
            'name_on_card' => $request->input('name_card'),
            'fb_url' => $request->input('fb_url'),

            'membership_package' => $request->input('membership_package'),

            'referral_code' => $request->input('referral_code'),
            'referred_by' => $referred_by_uuid, // USER UUID
            // 'premium_registration_comission_uuid' => $premium_registration_comission_uuid,

            'status' => 0,
        ]);

        if ($CreateNewRegistration->save()) {

            /* Move vaild ids to registration_uploads folder */
            if (!empty($valid_ids) && $valid_ids > 0) {
                foreach ($valid_ids as $key => $value) {
                    if ($value != null) {
                        File::move($folderPath.'/'.$value,$storePath.'/'.$value);

                        /* Insert file path to table */
                        IagdDetailsUploads::create([
                            'registration_uuid' => $registration_uuid,
                            'user_uuid' => $user_uuid,
                            'type' => 'valid_id',
                            'file_path' => $fileDbPath.'/'.$value,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
            /* Move 1x1 image to registration_uploads folder */
            if (!empty($clear_11images) && $clear_11images > 0) {
                foreach ($clear_11images as $key => $value) {
                    if ($value != null) {
                        File::move($folderPath.'/'.$value,$storePath.'/'.$value);
                        /* Insert file path to table */
                        IagdDetailsUploads::create([
                            'registration_uuid' => $registration_uuid,
                            'user_uuid' => $user_uuid,
                            'type' => '1x1_image',
                            'file_path' => $fileDbPath.'/'.$value,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
            /* Move payment proofs to registration_uploads folder */
            if (!empty($payment_proofs) && $payment_proofs > 0) {
                foreach ($payment_proofs as $key => $value) {
                    if ($value != null) {
                        File::move($folderPath.'/'.$value,$storePath.'/'.$value);
                        /* Insert file path to table */
                        IagdDetailsUploads::create([
                            'registration_uuid' => $registration_uuid,
                            'user_uuid' => $user_uuid,
                            'type' => 'payment_proof',
                            'file_path' => $fileDbPath.'/'.$value,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }

            $data = [
                'status' => 'success',
                'message' => 'Your registration is being processed.',
            ];
            return response()->json($data);
        }
        else {
            /* If registration error occur remove temporary images */

            /* Remove vaild ids */
            if ($valid_ids > 0) {
                foreach ($valid_ids as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }
            /* Remove 1x1 image */
            if ($clear_11images > 0) {
                foreach ($clear_11images as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }
            /* Remove payment proofs */
            if ($payment_proofs > 0) {
                foreach ($payment_proofs as $key => $value) {
                    if ($value != null) {
                        File::delete($folderPath.'/'.$value);
                    }
                }
            }
        }
    }
}

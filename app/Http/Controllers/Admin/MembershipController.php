<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Admin\MembershipDetailsModel;
use App\Models\Admin\MembershipDetailsUploadsModel;
use App\Models\Admin\RegistrationModel;
use App\Models\Admin\MembershipDetailsComissionModel;
use Auth;

class MembershipController extends Controller
{

    /* -------------------------------------------------------------------------- */
    /*                           Get admin user details                           */
    /* -------------------------------------------------------------------------- */
    public function adminUserDetails()
    {
        /* Get user details */
        $adminDetails = AdminModel::find(Auth::guard('web_admin')->user()->id)
        ->with('userAccount')
        ->first();
        return $adminDetails;
    }

	public function Membership_Upgrade(Request $request)
	{
        /* Get user details */
        $adminDetails = $this->adminUserDetails();

		$membership_upgrade = MembershipDetailsModel::with('MemberAccount');

        $search = $request->input('search');
        if ($search != null) {
            $membership_upgrade = $membership_upgrade->where(function($q) use ($search) {
                $q->where('registration_uuid', 'like', '%'. $search .'%')
                    ->orWhere('user_uuid', 'like', '%'. $search .'%')
                    ->orWhere('iagd_number', 'like', '%'. $search .'%')
                    ->orWhere('first_name', 'like', '%'. $search .'%')
                    ->orWhere('last_name', 'like', '%'. $search .'%')
                    ->orWhere('middle_initial', 'like', '%'. $search .'%')
                    ->orWhere('email_address', 'like', '%'. $search .'%')
                    ->orWhere('contact_number', 'like', '%'. $search .'%')
                    ->orWhere('address', 'like', '%'. $search .'%')
                    ->orWhere('shipping_address', 'like', '%'. $search .'%')
                    ->orWhere('nearest_lbc_branch', 'like', '%'. $search .'%')
                    ->orWhere('name_on_card', 'like', '%'. $search .'%')
                    ->orWhere('fb_url', 'like', '%'. $search .'%');
            });
        }

        $data = array(
			'title' => 'Membership Upgrade | International Animal Genetics Database',
			'membership_upgrade' => $membership_upgrade->paginate(10),
            'adminDetails' => $adminDetails

		);

		/* GET ALL IAGD MEMBER IN IAGD MEMBER DATABASE */
		return view('pages/admins/admin-membership-upgrade',['data'=>$data]);
	}

    public function upgrade_membership(Request $request)
    {
        /* STORE KEYS TO ARRAY */
        $key_arr = ['m_uuid'];

        /* LOOP CHECK IF KEYS ARE IDENTICAL TO FORM NAMES */
        foreach ($request->input() as $key => $value) {
            if (!in_array($key,$key_arr)) {
                return redirect()->back()->with('response','key_error');
            }
        }

        /* VALIDATE INPUTS */
        $validate = Validator::make($request->all(),[
            'm_uuid' => 'required',
        ],[
            'm_uuid.required' => 'Something\'s wrong! Please try again.',
        ]);

        /* THROW ERROR IF VALIDATION FAILED */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /* SET REGISTRATION COMISSION UUID */
        do {
            $premium_registration_comission_uuid = Str::uuid();
        } while (MembershipDetailsComissionModel::where("premium_registration_comission_uuid", $premium_registration_comission_uuid)->first() instanceof MembershipDetailsComissionModel);

        /* UPDATE MEMBERSHIP INFO */
        $GetMember_data = RegistrationModel::where('uuid', $request->input('m_uuid'));
        $GetMemberUpgrade_data = MembershipDetailsModel::where('user_uuid', $request->input('m_uuid'));
        if ($GetMember_data->count() > 0 && $GetMemberUpgrade_data->count() > 0) {

            // upgrade lounge account
            $gmd = $GetMember_data->first();
            $gmd->is_premium = 1;

            // update upgrade record
            $gmud = $GetMemberUpgrade_data->first();
            $gmud->premium_registration_comission_uuid = $premium_registration_comission_uuid;
            $gmud->status = 1;

            if ($gmd->save() && $gmud->save()) {
                /* > MEMBERSHIP UPGRADE COMISSION */
                if (!empty($gmud->membership_package) && $gmud->membership_package != NULL) {
                    /* Insert new comission record */
                    switch ($gmud->membership_package) {
                        case '0':
                            $sale_total = 3000;
                            $comission_total = 1000;
                            break;
                        case '1':
                            $sale_total = 7000;
                            $comission_total = 2000;
                            break;
                        case '2':
                            $sale_total = 12000;
                            $comission_total = 3000;
                            break;

                        default:
                            print('Something went wrong with the record.');exit();
                            break;
                    }
                    /* CHECK REFERRER PREMIUM REGISTRATION */
                    $referred_by_referrer_uuid = NULL;
                    $first_referrer_comission = 0;
                    $second_referrer_comission = 0;

                    if (!empty($gmud->referred_by)) {
                        $check_ref_1_account = RegistrationModel::where('uuid', $gmud->referred_by);
                        $check_ref_1_registration = MembershipDetailsModel::where('user_uuid', $gmud->referred_by);
                        if ($check_ref_1_account-> count() > 0) {
                            $referrer_1_account = $check_ref_1_account->first();

                            // IF R1 PREMIUM AND NO REFERRER
                            if ($referrer_1_account->is_premium == 1) {
                                $first_referrer_comission = $comission_total * 1;
                            } else { // IF R1 NOT PREMIUM AND NO REFERRER
                                $first_referrer_comission = $comission_total * 0.7;
                            }

                            if ($check_ref_1_registration-> count() > 0 && $referrer_1_account->is_premium == 1) { // CHECK IF THERE IS SECOND REFERRER
                                // NO NEED TO CHECK FOR SECOND REFERRER IF R1 IS NOT PREMIUM
                                $referrer_1_registration = $check_ref_1_registration->first();
                                // UPDATE COMISSION IF R1 HAS REFERRER
                                if (!empty($referrer_1_registration->referred_by)) {
                                    /* GET SECONDARY REFERRER INFO */
                                    $check_ref_2_account = RegistrationModel::where('uuid', $referrer_1_registration->referred_by);
                                    if ($check_ref_2_account-> count() > 0) {
                                        $referrer_2_account = $check_ref_2_account->first();

                                        // IF R1 PREMIUM AND R2 PREMIUM
                                        if ($referrer_2_account->is_premium == 1) {
                                            $first_referrer_comission = $comission_total * 0.7;

                                            // RECORD COMISSION TO SECOND REFERRER IF HE/SHE IS PREMIUM
                                            $referred_by_referrer_uuid = $referrer_2_account->uuid;
                                        } else { // IF R1 PREMIUM AND R2 NOT PREMIUM
                                            $first_referrer_comission = $comission_total * 0.7;

                                            $referred_by_referrer_uuid = NULL; // NULL MEANS COMISSION IS RETURNED TO COMP
                                        }
                                    }
                                }
                            }

                            // REMAINING COMISSION AFTER FIRST REFERRERS COMISSION
                            $second_referrer_comission = $comission_total - $first_referrer_comission;
                        }
                    }
                    $CreateNewRegistrationComission = MembershipDetailsComissionModel::create([
                        'premium_registration_comission_uuid' => $premium_registration_comission_uuid,
                        'sale_total' => $sale_total,
                        'comission_total' => $comission_total,

                        'lounge_registration_uuid' => $gmud->registration_uuid,
                        'registered_member_lounge_uuid' => $gmud->user_uuid,

                        'first_referrer_lounge_uuid' => $gmud->referred_by,
                        'second_referrer_lounge_uuid' => $referred_by_referrer_uuid,

                        'first_referrer_comission' => $first_referrer_comission,
                        'second_referrer_comission' => $second_referrer_comission,

                        'status' => 1,
                    ]);
                    $CreateNewRegistrationComission->save();
                }
                /* < MEMBERSHIP UPGRADE COMISSION */


                $response = array(
                    'alert' => 'success',
                    'title' => 'Success',
                    'message' => 'Membership upgraded.',
                );
                return redirect()->back()->with('response', $response);
            }
            else
            {
                $response = array(
                    'alert' => 'error',
                    'title' => 'Error',
                    'message' => 'Membership upgrade unsuccessful.',
                );
                return redirect()->back()->with('response', $response);
            }
        } else {
            $response = array(
                'alert' => 'warning',
                'title' => 'Warning',
                'message' => 'Member not found.',
            );
            return redirect()->back()->with('response', $response);
        }
    }
}

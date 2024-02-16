<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AdminLogsHelper;
use App\Helper\AjaxRequestHelper;
use App\Helper\UserAccountHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\RegistrationModel;
use App\Models\Users\MembersModel;
use Auth;
use Carbon;
use JavaScript;
use URL;

class LoungeMembersController extends Controller
{

	/**
	 * Lounge members page
	 *
	 * @param  mixed $request
	 * @return View
	 */
	public function Lounge_Members(Request $request)
	{

		$lounge_members = RegistrationModel::where('id', '<>', NULL);

        $search = $request->input('search');
        if ($search != null) {
            $lounge_members = $lounge_members->where(function($q) use ($search) {
                $q->where('uuid', 'like', '%'. $search .'%')
                    ->orWhere('iagd_number', 'like', '%'. $search .'%')
                    ->orWhere('email_address', 'like', '%'. $search .'%')
                    ->orWhere('profile_image', 'like', '%'. $search .'%')
                    ->orWhere('first_name', 'like', '%'. $search .'%')
                    ->orWhere('last_name', 'like', '%'. $search .'%')
                    ->orWhere('middle_name', 'like', '%'. $search .'%')
                    ->orWhere('gender', 'like', '%'. $search .'%')
                    ->orWhere('birth_date', 'like', '%'. $search .'%')
                    ->orWhere('contact_number', 'like', '%'. $search .'%')
                    ->orWhere('address', 'like', '%'. $search .'%');
            });
        }

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);
		$data = array(
			'title' => 'Lounge Members | International Animal Genetics Database',
			'lounge_members' => $lounge_members->paginate(10),
		);

		/* GET ALL IAGD MEMBER IN IAGD MEMBER DATABASE */
		return view('pages/admins/admin-lounge-members',['data'=>$data]);
	}

    /**
     * Update user referral number
     *
     * @param  mixed $request
     * @return JSON
     */
    public function updateReferralNumber(Request $request)
    {
        /*
            * Check ajax request
        */
        $ajaxReq = AjaxRequestHelper::checkAjaxRequest($request);
        if ($ajaxReq) {
            return response()->json($ajaxReq);
        }

        /*
            * Validate request and throw validation errors
        */
        $validate = Validator::make($request->all(),[
            'uuid' => 'required',
            'referred_by' => 'required'
        ],[
            'uuid.required' => 'User uuid is null.',
            'referred_by.required' => 'Please enter referral number.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /*
            * Check if user exist
        */
        $user_uuid = $request->input('uuid');
        $userCount = UserAccountHelper::UserUuidExist($user_uuid);
        if ($userCount) {
            return response()->json($userCount);
        }

        /*
            * Get user using uuid and update
        */
        $user = UserAccountHelper::getUserIdUsingUuid($user_uuid);
        $referral_number = $request->input('referred_by');

        $updateUser = MembersModel::find($user->id);
        $updateUser->referred_by = $referral_number;
        $updateUser->updated_at = Carbon::now();

        /*
            * If update fails throw error
        */
        if (!$updateUser->save()) {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to update referral number!'
            ];
            return response()->json($data);
        }

        /*
            * Log admin action
        */
        $admin = Auth::guard('web_admin')->user();
        $userName = $user->first_name .' '.$user->last_name;
        $userLink = '<a class="adminlog-link" href="'.route('user.view_members').'?rid='.$user->uuid.'" target="_BLANK">user</a>';
        $adminUserName = $admin->userAccount->first_name .' '.$admin->userAccount->last_name;
        $logAction = 'update';
        $logDescription = $adminUserName.' updated '.$userLink.' '.$userName.' referral number from '.$user->referred_by.' to '.$referral_number.'.';
        $logAlertLevel = 0;
        AdminLogsHelper::addAdminAction($logAction,$logDescription,$logAlertLevel);
        /*
            * Throw JSON response on success
        */
        $data = [
            'status' => 'success',
            'message' => 'Referral number has been updated'
        ];
        return response()->json($data);

    }
}

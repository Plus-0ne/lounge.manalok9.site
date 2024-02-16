<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AdminRolesAndRestrictions;
use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use App\Models\Users\MembersModel;
use Auth;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;
use Str;
use URL;
use Validator;
use Illuminate\Support\Facades\Hash;

class AdminAccountsController extends Controller
{

    /* -------------------------------------------------------------------------- */
    /*                             Admin account page                             */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        /* Check admin roles */
        $adminRole = AdminRolesAndRestrictions::checkRole();

        if ($adminRole != 1) {
            return redirect()->back();
        }

        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $adminAccounts = AdminModel::with('userAccount')->get();

        $data = array(
            'title' => 'Admin accounts | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'adminAccounts' => $adminAccounts
        );
        return view('pages/admins/admin-accounts', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                             Admin account form                             */
    /* -------------------------------------------------------------------------- */
    public function admin_account_form(Request $request)
    {
        /* Check admin roles */
        $adminRole = AdminRolesAndRestrictions::checkRole();

        if ($adminRole != 1) {
            return redirect()->back();
        }

        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        /* Get all users */
        $users_with_account = AdminModel::pluck('user_uuid')->all();
        $users = MembersModel::whereNotIn('uuid', $users_with_account)->get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Admin accounts form | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'users' => $users
        );
        return view('pages/admins/admin-accounts/admin-accounts-form', ['data' => $data]);
    }
    /* -------------------------------------------------------------------------- */
    /*                           Get all admin accounts                           */
    /* -------------------------------------------------------------------------- */
    public function account_all(Request $request)
    {
        /* Check if ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        $adminAccounts = AdminModel::with('userAccount')->get();

        $data = [
            'status' => 'success',
            'message' => 'Admin accounts fetched.',
            'aacounts' => $adminAccounts
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                            Delete account by id                            */
    /* -------------------------------------------------------------------------- */
    public function delete_account_byid(Request $request)
    {
        /* Check if ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Check admin role superuser can only be deleted by superuser account */
        if (Auth::guard('web_admin')->user()->roles != 1) {
            $data = [
                'status' => 'warning',
                'message' => 'You don\'t have the required role to delete.'
            ];
            return response()->json($data);
        }


        /* Validate request */
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ], [
            'id.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Check if admin account exist */
        $adminAccount = AdminModel::find($request->input('id'));

        /* Throw response if admin did not exist */
        if ($adminAccount->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Admin does not exist.'
            ];
            return response()->json($data);
        }

        /* Throw response if last admin is being deleted */
        if ($adminAccount->count() < 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Cant delete admin! App needs 1 admin.'
            ];
            return response()->json($data);
        }

        /* If account is authenticated admin ? delete account then logout */
        if ($adminAccount->id == Auth::guard('web_admin')->user()->id) {


            $data = [
                'status' => 'success',
                'message' => 'Failed to delete your account.'
            ];
            return response()->json($data);
        }

        $adminAccount->forceDelete();

        $data = [
            'status' => 'success',
            'message' => 'Admin has been deleted.'
        ];
        return response()->json($data);
    }


    /* -------------------------------------------------------------------------- */
    /*                                LOGOUT ADMIN                                */
    /* -------------------------------------------------------------------------- */
    public function logout_admin($request)
    {
        // Auth::guard('web')->logout();
        Auth::guard('web_admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard');
    }

    /* -------------------------------------------------------------------------- */
    /*                            Ajax user get details                           */
    /* -------------------------------------------------------------------------- */
    public function user_get(Request $request)
    {
        /* Check admin roles */
        $adminRole = AdminRolesAndRestrictions::checkRole();

        if ($adminRole != 1) {
            $data = [
                'status' => 'warning',
                'message' => 'You don\'t have the proper role to add new admin.'
            ];
            return response()->json($data);
        }

        /* Check ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(), [
            'uuid' => 'required'
        ], [
            'uuid.required' => 'Invalid request! Uuid required.'
        ]);

        /* Throw message if validation failed */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Check if user exist in admin table */
        $isAdminAlready = AdminModel::where('user_uuid', $request->input('uuid'));

        if ($isAdminAlready->count() > 0) {

            $data = [
                'status' => 'warning',
                'message' => 'This user has been assigned as admin already.'
            ];
            return response()->json($data);
        }

        /* Get user details */
        $userDetails = MembersModel::where('uuid', $request->input('uuid'));

        if ($userDetails->count() < 1) {

            $data = [
                'status' => 'warning',
                'message' => 'User does not exist.'
            ];
            return response()->json($data);
        }

        $userD = $userDetails->first();
        $data = [
            'status' => 'success',
            'message' => 'User exist.',
            'user' => $userD
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Create new admin                              */
    /* -------------------------------------------------------------------------- */
    public function useradmin_create(Request $request)
    {
        /* Check admin roles */
        $adminRole = AdminRolesAndRestrictions::checkRole();

        if ($adminRole != 1) {
            $data = [
                'status' => 'warning',
                'message' => 'You don\'t have the proper role to add new admin.'
            ];
            return response()->json($data);
        }

        /* Check ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Validate post request */
        $validate = Validator::make($request->all(), [
            'user_uuid' => 'required',
            'email_address' => 'required',
            'department' => 'required',
            'position' => 'required',
            'roles' => 'required',
            'password' => 'required',
            'verifyPassword' => 'required',
        ], [
            'user_uuid.required' => 'User uuid not found!',
            'email_address.required' => 'Email address not found!',
            'department.required' => 'Please enter the department!',
            'position.required' => 'Please enter the position!',
            'roles.required' => 'Please select the role!',
            'password.required' => 'Please enter a password!',
            'verifyPassword.required' => 'Please verify the password!',
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Compare password */
        if ($request->input('password') != $request->input('verifyPassword')) {
            $data = [
                'status' => 'warning',
                'message' => 'Password did not matched!'
            ];
            return response()->json($data);
        }

        /* Check if uuid exist in admin table */
        $Checkuuid = AdminModel::where('user_uuid', $request->input('user_uuid'));
        if ($Checkuuid->count() > 0) {
            $data = [
                'status' => 'warning',
                'message' => 'This user is already added as admin!'
            ];
            return response()->json($data);
        }

        /* Check if email exist in admin table */
        $CheckEmail = AdminModel::where('email_address', $request->input('email_address'));
        if ($CheckEmail->count() > 0) {
            $data = [
                'status' => 'warning',
                'message' => 'This user is already added as admin!'
            ];
            return response()->json($data);
        }

        /* Switch data for roles */
        $roles = $request->input('roles');
        switch ($roles) {
            case 'superuser':
                $roles = 1;
                break;

            default:
                $roles = 2;
                break;
        }

        do {
            $admin_uuid = Str::uuid();
        } while (AdminModel::where('admin_id', '=', $admin_uuid)->first() instanceof AdminModel);
        /* Create new admin */
        $newAdmin = AdminModel::create([
            'admin_id' => $admin_uuid,
            'user_uuid' => $request->input('user_uuid'),
            'email_address' => $request->input('email_address'),
            'password' => Hash::make($request->input('password')),
            'department' => $request->input('department'),
            'position' => $request->input('position'),
            'roles' => $roles,
            'added_by' => Auth::guard('web_admin')->user()->admin_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        if (!$newAdmin->save()) {
            $data = [
                'status' => 'error',
                'message' => 'Failed to add new admin!'
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Admin successfully saved!'
        ];
        return response()->json($data);
    }
}

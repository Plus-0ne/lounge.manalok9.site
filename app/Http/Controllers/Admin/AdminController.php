<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Mail;

use App\Models\Admin\IagdModel;
use App\Models\Admin\RegistrationModel;

use Session;
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;

class AdminController extends Controller
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

    /* -------------------------------------------------------------------------- */
    /*                                 Login page                                 */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        if (Auth::guard('web_admin')->check()) {
            return redirect()->route('admin.Dashboard');
        } else {
            $data = array(
                'title' => 'Login | International Animal Genetics Database',
            );
            return view('pages/admins/admin-login', ['data' => $data]);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               Dashboard page                               */
    /* -------------------------------------------------------------------------- */
    public function Dashboard()
    {
        /* Get user details */
        $adminDetails = $this->adminUserDetails();

        /* Count all user account */
        $userAccountTotal = MembersModel::all();

        /* Count admin */
        $adminAccountTotal = AdminModel::all();

        /* Count all post */
        $postTotal = PostFeed::all();

        $data = array(
            'title' => 'Dashboard | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'userAccountTotal' => $userAccountTotal,
            'adminAccountTotal' => $adminAccountTotal,
            'postTotal' => $postTotal
        );

        return view('pages/admins/admin-dashboard', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                              IAGD members page                             */
    /* -------------------------------------------------------------------------- */
    public function IAGD_Members()
    {
        /* Get user details */
        $adminDetails = $this->adminUserDetails();

        $iagd_m = IagdModel::all();
        $data = array(
            'title' => 'Members | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'iagd_members' => $iagd_m,
        );

        /* GET ALL IAGD MEMBER IN IAGD MEMBER DATABASE */
        return view('pages/admins/admin-iagd-members', ['data' => $data]);
    }

    public function users_post()
    {
        $data = array(
            'title' => 'Users Post | International Animal Genetics Database',
        );
        return view('pages/admins/admin-post-list', ['data' => $data]);
    }
    public function member_registration()
    {
        /* CHECK ADMIN SESSION */
        $memberss = RegistrationModel::all();
        $data = array(
            'title' => 'Member Registration | International Animal Genetics Database',
            'mem_data' => $memberss->toArray(),
        );
        return view('pages/admins/admin-registration', ['data' => $data]);
    }

    /* END VIEWS */

    /* LOGIN VALIDATION */
    public function LoginValidation(Request $request)
    {
        $cred_need = ['_token', 'email_address', 'password'];

        foreach ($request->input() as $key => $value) {
            if (!in_array($key, $cred_need)) {
                return redirect('/admin')->with('status', 'not set');
            }
            if (empty($value)) {
                return redirect('/admin')->with('status', 'null');
            }
        }
        $email_address = $request->input('email_address');
        $password = $request->input('password');

        if (Auth()->guard('web_admin')->attempt([
            'email_address' => $email_address,
            'password' => $password
        ])) {

            return redirect('/admin/Dashboard')->with('status', 'success');
        } else {
            return redirect('/admin')->with('status', 'null admin');
        }
    }
    /* LOGOUT ADMIN */
    public function logout_admin(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('web_admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /* SEND EMAIL VERIFICATION TO NEW REGISTER MEMBER */
    public function send_emailverification(Request $request)
    {
        $id = $request->input('id');
        $validated = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validated->fails()) {
            echo 'error';
        } else {
            $md = RegistrationModel::find($id);
            if ($md->count() > 0) {
                $md = $md->first();

                $to_name = $md->name;
                $to_email = $md->email_address;
                $data = array(
                    'name' => 'Ogbonna Vitalis(sender_name)',
                    'body' => 'A test mail'
                );

                Mail::send('pages/admins/template/mail-verification', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Laravel Test Mail');
                    $message->from('manalok9inventory@gmail.com', 'Test Mail');
                });
            } else {
                echo 'not_found';
            }
        }
    }
    /* EMAIL VERIFICATION TEMPLATE TO BE SENT */
    public function template_email_verification()
    {
        return view('pages/admins/template/mail-verification');
    }

    /* Signin as admin */
    public function admin_sign_validation(Request $request)
    {
        /* Signin as admin */
        $isAdmin = AdminModel::where('user_uuid',Auth::guard('web')->user()->uuid);

        if ($isAdmin->count() > 0) {
            $signin_admin = Auth::guard('web_admin')->loginUsingId($isAdmin->first()->id);

            if ($signin_admin) {

                /* Redirect to admin page */
                return redirect()->route('admin.Dashboard');
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to sign-in account.'
                ];
                return redirect()->back()->with($data);
            }

        } else {
            $data = [
                'status' => 'error',
                'message' => 'Admin account did not exist.'
            ];
            return redirect()->back()->with($data);
        }
    }
}

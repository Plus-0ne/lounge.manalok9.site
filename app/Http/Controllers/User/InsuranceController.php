<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminInsuranceModel;
use App\Models\Users\InsuranceOrdered;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use Auth;
use Carbon;
use Str;
use URL;
use Validator;

class InsuranceController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Request Insurance | IAGD Members Lounge',
            'notif' => $notif
        );

        return view('pages.users.animal-pages.user-insurance-request', ['data' => $data]);
    }

    /**
     * Get insurance page
     *
     * @return View
     */
    public function insuranceView()
    {
        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        /*
            * Get all insurance
        */
        $user = Auth::guard('web')->user();
        $insurance = AdminInsuranceModel::orderBy('id', 'DESC')->with('insruanceAvailedByUser', function ($q) use ($user) {
            $q->where([
                ['user_uuid', '=', $user->uuid],
                ['status', '=', 1]
            ]);
        })->get();

        $data = array(
            'title' => 'Insurance | IAGD Members Lounge',
            'notif' => $notif,
            'insurance' => $insurance,
            'analytics' => CustomHelper::analytics()
        );

        return view('pages.users.product-services.user-insurance', ['data' => $data]);
    }

    /**
     * View insurance details
     *
     * @param  mixed $request
     * @return View
     */
    public function insuranceDetails(Request $request)
    {
        /*
            * Validate insurance uuid
        */
        $validate = Validator::make($request->all(), [
            'insuranceUuid' => 'required'
        ], [
            'insuranceUuid.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return redirect()->back()->with($data);
        }

        /*
            * get all notification
        */
        $notif = Notif_Helper::GetUserNotification();

        /*
            * Javascript variables
        */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/'),
            'insuranceUuid' => $request->input('insuranceUuid')
        ]);

        /*
            * Get all insurance
        */
        $user = Auth::guard('web')->user();
        $insurance = AdminInsuranceModel::where('uuid', $request->input('insuranceUuid'))->with('insruanceAvailedByUser', function ($q) use ($user) {
            $q->where([
                ['user_uuid', '=', $user->uuid],
                ['status', '=', 1]
            ]);
        })->first();

        $data = array(
            'title' => 'Insurance | IAGD Members Lounge',
            'notif' => $notif,
            'insurance' => $insurance
        );

        return view('pages.users.product-services.user-insurance-details', ['data' => $data]);
    }

    /**
     * Avail the insurance
     *
     * @param  mixed $request
     * @return JSON
     */
    public function insuranceAvail(Request $request)
    {
        /*
            * Check if request is ajax
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->input(), [
            'insuranceUuid' => 'required'
        ], [
            'insuranceUuid.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }
        /*
            * Check if insurance still exist
        */
        $insurance = AdminInsuranceModel::where('uuid', $request->input('insuranceUuid'));
        if ($insurance->count() < 1) {
            $data = [
                'status' => 'error',
                'message' => 'Insurance doesn\'t exist!'
            ];
            return response()->json($data);
        }
        /*
            * Check if insurance is still available
        */
        if ($insurance->first()->status < 1) {
            $data = [
                'status' => 'error',
                'message' => 'This insurance is not available at the moment.'
            ];
            return response()->json($data);
        }

        /*
            * Check if user already avail the insurance and active
        */
        $availInsurance = InsuranceOrdered::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['insurance_uuid', '=', $insurance->first()->uuid],
            ['status', '=', 1],
        ]);
        if ($availInsurance->count() > 0) {
            $data = [
                'status' => 'error',
                'message' => 'You already avail this insurance.'
            ];
            return response()->json($data);
        }

        /*
            * Save avail insurance to table
        */
        do {
            $uuid = Str::uuid();
        } while (InsuranceOrdered::where("uuid", $uuid)->first() instanceof InsuranceOrdered);

        do {
            $order_id = rand(0, 9999999999);
        } while (InsuranceOrdered::where("order_id", $order_id)->first() instanceof InsuranceOrdered);


        $data = [
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,
            'insurance_uuid' => $insurance->first()->uuid,
            'order_id' => $order_id,
            'price' => $insurance->first()->price,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $availInsurance = InsuranceOrdered::create($data);

        if (!$availInsurance->save()) {
            $data = [
                'status' => 'error',
                'message' => 'Failed to avail this insurance. Please try again.'
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Insurance avail successfully.'
        ];
        return response()->json($data);
    }


    /**
     * Get user availed insurance plans
     *
     * @param  mixed $request
     * @return JSON
     */
    public function getUserAvailedInsurance(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Get user insurance plan availed
        */
        $insurancePlans = InsuranceOrdered::with('user')
        ->with('insuranceDetails')
        ->get();

        $data = [
            'status' => 'success',
            'message' => 'User availed insurance plans fetched.',
            'insurancePlans' => $insurancePlans
        ];
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Helper\InsuranceHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminInsuranceModel;
use DB;
use File;
use Illuminate\Http\Request;
use JavaScript;
use Session;
use URL;
use Validator;

class InsuranceController extends Controller
{
    /**
     * View insurance page
     *
     * @return View
     */
    public function index()
    {
        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        /*
            * Get list of insurance
        */
        $insurance = AdminInsuranceModel::orderBy('id', 'DESC')->get();

        $data = array(
            'title' => 'Insurance | International Animal Genetics Database',
            'insurance' => $insurance
        );

        return view('pages/admins/admin-insurance', ['data' => $data]);
    }

    /**
     * View insurance form page
     *
     * @return view
     */
    public function insuranceFormCreate(Request $request) {
        /*
            * Validate step count
        */
        $validate = Validator::make($request->all(),[
            'step' => 'required'
        ],[
            'step.required' => 'Something\'s wrong! Please try again later.'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /*
            * Create javascript variables
        */
        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Create new insurance plan | International Animal Genetics Database',
        );

        return view('pages/admins/admin-insurance-add', ['data' => $data]);
    }
    /**
     * Create new insurance
     *
     * @return JSON
     */
    public function insuranceCreate(Request $request)
    {
        /*
            * Check ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = InsuranceHelper::validateRequest($request);
        if ($validate) {
            $data = [
                'status' => 'warning',
                'message' => $validate
            ];
            return response()->json($data);
        }
        /*
            * Upload image file
        */
        $imageUpload = InsuranceHelper::uploadInsuranceImage($request);
        if ($imageUpload) {

            /*
                * Clear image session
            */
            InsuranceHelper::clearInsuranceImageSession();

            $data = [
                'status' => 'warning',
                'message' => $imageUpload
            ];
            return response()->json($data);
        }
        /*
            * Begin transaction
        */
        DB::beginTransaction();

        /*
            * Insert data to table
        */
        $createInsurance = InsuranceHelper::insertNewInsurance($request);
        if ($createInsurance) {

            /*
                * Rollback DB
            */
            DB::rollBack();

            /*
                * Delete image in public
            */
            InsuranceHelper::removeInsuranceImageUpload();
            $data = [
                'status' => 'warning',
                'message' => $createInsurance
            ];
            return response()->json($data);
        }
        /*
            * Commit DB
        */
        DB::commit();

        /*
            * Clear image session
        */
        InsuranceHelper::clearInsuranceImageSession();

        $data = [
            'status' => 'success',
            'message' => 'New insurance option has been added.'
        ];
        return response()->json($data);
    }

    /**
     * Delete insurance row
     *
     * @return void
     */
    public function insuranceDelete(Request $request)
    {
        /*
            * Validate request
        */
        $validate = Validator($request->all(),[
            'uuid' => 'required'
        ],[
            'uuid.required' => 'Something\'s wrong! Please try again later.'
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
            * Check if insurance exist
        */
        $insuranceDetails = AdminInsuranceModel::where('uuid',$request->input('uuid'));
        if ($insuranceDetails->count() < 1) {
            $data = [
                'status' => 'error',
                'message' => 'Insurance not found.'
            ];
            return redirect()->back()->with($data);
        }

        /*
            * Get image path
        */
        $imagePath = $insuranceDetails->first()->image_path;
        /*
            * Delete insurance
        */
        if (!$insuranceDetails->delete()) {
            $data = [
                'status' => 'error',
                'message' => 'Failed to delete insurance'
            ];
            return redirect()->back()->with($data);
        }

        File::delete(public_path($imagePath));

        $data = [
            'status' => 'success',
            'message' => 'Insurance has been deleted.'
        ];
        return redirect()->back()->with($data);
    }
}

<?php

namespace App\Helper;

use App\Models\Admin\AdminInsuranceModel;
use Auth;
use Carbon;
use File;
use Session;
use Str;
use Validator;

class InsuranceHelper
{
    /**
     * validateRequest
     *
     * @param  mixed $request
     * @return void
     */
    public static function validateRequest($request)
    {

        $rules = [
            'title' => 'required',
            'price' => 'required|numeric',
            'coverageType' => 'required',
            'coveragePeriod' => 'required|numeric'
        ];


        $validationErrors = [
            'title.required' => 'Please enter the title.',
            'price.required' => 'Please enter the price.',
            'price.numeric' => 'Entered price is not a valid number.',
            'coverageType.required' => 'Please select coverage type.',
            'coveragePeriod.required' => 'Please enter coverage period.',
            'coveragePeriod.numeric' => 'Entered coverage period is not numeric value.',
        ];

        if ($request->hasFile('imageFile')) {
            $rules['imageFile'] = 'image|mimes:jpg,jpeg,png';
            $validationErrors['imageFile']['image'] = 'Uploded file is not an image.';
            $validationErrors['imageFile']['mimes'] = 'Upload a valid image format!';
        }

        $validate = Validator::make($request->all(), $rules, $validationErrors);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            return $validate->errors()->first();
        }
    }

    /**
     * Upload insurance image file
     *
     * @param  mixed $request
     * @return void
     */
    public static function uploadInsuranceImage($request)
    {
        /*
            * Check if imageFile exist
        */
        if (!$request->hasFile('imageFile')) {
            return;
        }

        /*
            * Try uploading the file
        */
        try {


            $file = $request->file('imageFile');

            $destinationPath = public_path('insurance_files/img');


            $imageName = str_replace(' ', '-', $request->input('imageFile'));

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }


            $image = $imageName . $file->getClientOriginalName();


            $file->move($destinationPath, $image);

            /*
                * Store file path in session
            */
            $sessionData = [
                'insuranceImageFile' => 'insurance_files/img/' . $image
            ];
            Session::put($sessionData);
        } catch (\Exception $ex) {
            return 'Failed to upload image.';
        }
    }

    /**
     * Insert new insurance
     *
     * @return void
     */
    public static function insertNewInsurance($request)
    {
        do {
            $uuid = Str::uuid();
        } while (AdminInsuranceModel::where('uuid', '=', $uuid)->first()  instanceof AdminInsuranceModel);

        $coverageType = null;
        switch ($request->input('coverageType')) {
            case 'weeks':
                $coverageType = 'weeks';
                break;
            case 'months':
                $coverageType = 'months';
                break;
            case 'years':
                $coverageType = 'years';
                break;
            default:
                $coverageType = 'days';
                break;
        }
        $data = [
            'uuid' => $uuid,
            'added_by' => Auth::guard('web_admin')->user()->admin_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'available_discount' => 0,
            'status' => 1,
            'image_path' => (Session::has('insuranceImageFile')) ? Session::get('insuranceImageFile') : null,
            'coverage_type' => $coverageType,
            'coverage_period' => $request->input('coveragePeriod'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $createInsurance = AdminInsuranceModel::create($data);
        if (!$createInsurance->save()) {
            return 'Failed to add new insurance option.';
        }
    }

    /**
     * Clear insurance stored image in session
     *
     * @return void
     */
    public static function clearInsuranceImageSession()
    {
        if (Session::has('insuranceImageFile')) {
            Session::forget('insuranceImageFile');
        }
    }

    /**
     * Remove insurance image upload
     *
     * @return void
     */
    public static function removeInsuranceImageUpload()
    {
        if (Session::has('insuranceImageFile')) {

            File::delete(public_path(Session::get('insuranceImageFile')));
            Session::forget('insuranceImageFile');
        }
    }
}

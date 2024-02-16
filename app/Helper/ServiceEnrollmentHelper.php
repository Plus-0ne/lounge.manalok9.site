<?php

namespace App\Helper;

use App\Models\Users\ServiceOrders;
use Auth;
use File;
use Session;
use Storage;
use Validator;

class ServiceEnrollmentHelper
{


    /**
     * Count services in cart
     *
     * @return void
     */
    public static function countServicesInCart()
    {
        $serviceInCart = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);
        return $serviceInCart->count();
    }

    /**
     * getServicesInCart
     *
     * @return void
     */
    public static function getServicesInCart()
    {
        $serviceInCart = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);
        return $serviceInCart;
    }

    /**
     * Validate health record then upload
     *
     * @param  mixed $request
     * @return void
     */
    public static function uploadHealthRecord($request)
    {
        /*
            * Check if health record exist
        */
        if ($request->hasFile('healthRecord')) {
            /*
                * Validate input request
            */
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /*
                * Validate veterenary record
            */
            if (!in_array($request->file('healthRecord')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid health record file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'healthRecord' => 'max:30000',
            ], [
                'healthRecord.max' => 'Health record file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            try {

                /*
                    * Get current authenticated user
                */
                $user = Auth::guard('web')->user();

                /*
                    * Create subdirectory with user uuid
                */
                $subdirectory = 'user_' . $user->uuid;

                /*
                    * Store the file in the 'user_files' disk under the user's subdirectory
                */
                $path = $request->file('healthRecord')->store($subdirectory, 'user_files');

                /*
                    * Store file path in session
                */
                $sessionData = [
                    'healthRecordfilePath' => $path
                ];
                Session::put($sessionData);

                /*
                    * Throw success json encoded data
                */
                $data = [
                    'status' => 'success',
                    'message' => 'Health record upload successfully!'
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /**
     * Upload laboratory result
     *
     * @param  mixed $request
     * @return void
     */
    public static function uploadLaboratoryResult($request)
    {
        /*
            * Check if health record exist
        */
        if ($request->hasFile('laboratoryResult')) {
            /*
                * Validate input request
            */
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /*
                * Validate veterenary record
            */
            if (!in_array($request->file('laboratoryResult')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid laboratory result file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'laboratoryResult' => 'max:30000',
            ], [
                'laboratoryResult.max' => 'Laboratory result file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            try {

                /*
                    * Get current authenticated user
                */
                $user = Auth::guard('web')->user();

                /*
                    * Create subdirectory with user uuid
                */
                $subdirectory = 'user_' . $user->uuid;

                /*
                    * Store the file in the 'user_files' disk under the user's subdirectory
                */
                $path = $request->file('laboratoryResult')->store($subdirectory, 'user_files');

                /*
                    * Store file path in session
                */
                $sessionData = [
                    'laboratoryResultfilePath' => $path
                ];
                Session::put($sessionData);

                /*
                    * Throw success json encoded data
                */
                $data = [
                    'status' => 'success',
                    'message' => 'Laboratory result upload successfully!'
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /**
     * Remove image the unlink session
     *
     * @return void
     */
    public static function imgRemoveUnlinkSession()
    {

        if (Session::has('healthRecordfilePath')) {
            Storage::delete(Session::get('healthRecordfilePath'));
            Session::forget('healthRecordfilePath');
        }
        if (Session::has('laboratoryResultfilePath')) {
            Storage::delete(Session::get('laboratoryResultfilePath'));
            Session::forget('laboratoryResultfilePath');
        }
    }

    /**
     * Unlink session data
     *
     * @return void
     */
    public static function unlinkSessionData()
    {
        if (Session::has('healthRecordfilePath')) {
            Session::forget('healthRecordfilePath');
        }
        if (Session::has('laboratoryResultfilePath')) {
            Session::forget('laboratoryResultfilePath');
        }
    }

    // $requestInput = [
    //     'ehrlichiosis',
    //     'liverProblem',
    //     'kidneyProblem',
    //     'fracture',
    //     'hipDysplasia',
    //     'allergy',
    //     'eyeIrritation',
    //     'skinProblem',
    //     'undergoneOperation',
    //     'biteIncendent',
    //     'otherHealthProblem',
    // ];
}

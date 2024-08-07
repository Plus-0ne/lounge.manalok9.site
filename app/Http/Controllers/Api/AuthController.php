<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users\MembersModel;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /**
     * Validate login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginValidation(Request $request) {
        // if (!$request->ajax()) {
        //     $data = [
        //         'status' => 'error',
        //         'message' => 'Invalid request! Please try again later.'
        //     ];

        //     return response()->json($data);
        // }

        // Validate all request
        $validate = Validator::make($request->all(), [
            'email_address' => 'required',
            'password' => 'required'
        ], [
            'email_address.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.'
        ]);

        // Check validation for errors
        if ($validate->fails()) {

            // Throw validation error response message
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        // Check if email is valid
        $emailValid = filter_var($request->input('email_address'), FILTER_VALIDATE_EMAIL);
        if (!$emailValid) {
            $data = [
                'status' => 'warning',
                'message' => 'Please enter a valid email address.'
            ];
            return response()->json($data);
        }

        $user = MembersModel::where('email_address',$request->input('email_address'))->first();

        if (!$user) {
            // Throw warning response message
            $data = [
                'status' => 'warning',
                'message' => 'User not found!'
            ];
            return response()->json($data);
        }

        if (!Hash::check($request->input('password'),$user->password)) {
            // Throw warning response message
            $data = [
                'status' => 'warning',
                'message' => 'Incorrect password!'
            ];
            return response()->json($data);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Throw success response message
        $data = [
            'status' => 'success',
            'message' => 'Login successfully!',
            'token' => $token,
            'user' => $user
        ];
        return response()->json($data);

    }
}

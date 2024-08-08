<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users\MembersModel;
use DB;
use Illuminate\Http\Request;
use Validator;

class UsersController extends Controller
{
    public function get(Request $request) {

        $validate = Validator::make($request->all(),[
            'q' => 'required'
        ],[
            'q.required' => 'Please enter a search string!'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $data = MembersModel::whereFullText(['iagd_number','old_iagd_number','email_address','first_name','last_name','middle_name','contact_number','referred_by'
        ],$request->input('q'))->get();

        return response()->json($data);
    }
}

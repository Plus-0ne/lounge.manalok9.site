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

        $data = DB::table('iagd_members')
            ->select('*')
            ->whereRaw("MATCH(first_name, last_name, middle_name) AGAINST(? IN BOOLEAN MODE)", [$request->input('q')])
            ->get();

        return response()->json($data);
    }
}

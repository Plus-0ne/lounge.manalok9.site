<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

/* Models */
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;

class SearchController extends Controller
{
    public function search_all(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Check validation */
        $validate = Validator::make($request->all(),[
            'ps_search_input' => 'required'
        ],[
            'ps_search_input.required' => 'Enter text to search.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }
        $searchValuesRaw = $request->input('ps_search_input');

        $searchValues = preg_split('/\s+/', $request->input('ps_search_input'), -1, PREG_SPLIT_NO_EMPTY);

        $upage = $request->input('upage');
        $ppage = $request->input('ppage');
        $auth_user = Auth::guard('web')->user();
        $per_page = 10;

        $mm = MembersModel::select('uuid','iagd_number','first_name','last_name','profile_image','created_at')->where(function ($q) use($searchValues) {
            foreach ($searchValues as $row) {
                $q->orWhere([
                    ['first_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ])->orWhere([
                    ['last_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ])->orWhere([
                    ['middle_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ])->orWhere([
                    ['iagd_number','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ]);
            }
        })->with('myFollowers',function ($uf) use($auth_user) {
            $uf->where([
                ['uuid','=',$auth_user->uuid],
                ['status','=',1]
            ]);
        });

        /* Search Posts */
        /* First check user  */

        // split on 1+ whitespace & ignore empty (eg. trailing space)


        $pf = PostFeed::where(function ($q) use ($searchValues) {
        foreach ($searchValues as $value) {
            $q->orWhere([
                ['post_message','like',"%{$value}%"],
                ['visibility','=','public']
            ]);
        }
        })->with('MembersModel');

        /* json response */
        $data = [
            'status' => 'success',
            'mm' => $mm->paginate($per_page, ['*'], 'page', $upage),
            'pf' => $pf->paginate($per_page, ['*'], 'page', $ppage),
            'searchString' => $searchValuesRaw
        ];

        return response()->json($data);
    }
    public function add_user_paginated(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Check validation */
        $validate = Validator::make($request->all(),[
            'searchStr' => 'required'
        ],[
            'searchStr.required' => 'Enter text to search.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }
        $searchValuesRaw = $request->input('searchStr');

        $searchValues = preg_split('/\s+/', $request->input('searchStr'), -1, PREG_SPLIT_NO_EMPTY);

        $upage = $request->input('upage');
        $auth_user = Auth::guard('web')->user();
        $per_page = 10;

        $mm = MembersModel::select('uuid','first_name','last_name','profile_image','created_at')->where(function ($q) use($searchValues) {
            foreach ($searchValues as $row) {
                $q->orWhere([
                    ['first_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ])->orWhere([
                    ['last_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ])->orWhere([
                    ['middle_name','like',"%{$row}%"],
                    ['is_email_verified','=',1],
                ]);
            }
        })->with('myFollowers',function ($uf) use($auth_user) {
            $uf->where([
                ['uuid','=',$auth_user->uuid],
                ['status','=',1]
            ]);
        });

        $data = [
            'status' => 'success',
            'mm' => $mm->paginate($per_page, ['*'], 'page', $upage),
            'searchString' => $searchValuesRaw
        ];

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Use Carbon\Carbon;

use App\Models\Users\MembersModel;
use App\Models\Users\UserFollow;

use Str;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        /*
            Set uuid to authenticated user's uuid
        */
        $uuid = Auth::guard('web')->user()->uuid;

        /*
            Get all followers
        */
        $followers = UserFollow::where([
            ['follow_uuid','=',$uuid],
            ['status','=',1],
        ])->with('followerDetails');

        /*
            Get all following
        */
        $following = UserFollow::where([
            ['uuid','=',$uuid],
            ['status','=',1],
        ])->with('followingDetails');

        $data = array(
            'title' => 'User follow and followers | IAGD Members Lounge',
            'followers' => $followers,
            'following' => $following,
        );
        return view('pages/users/user-follow', ['data' => $data]);
    }

    public function follow_user(Request $request)
    {
        /* Variables */
        $my_uuid = Auth::guard('web')->user()->uuid;
        $uuid = $request->input('id');

        if ($my_uuid == $uuid) {
            return redirect()->back();
        }

        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        /* Check if id is set */
        if (!$request->has('id') || !$request->has('status')) {
            return redirect()->back();
        }

        /* Check if id is empty */
        if (empty($request->input('id')) || empty($request->input('status'))) {
            return redirect()->back();
        }

        /* Status value string to int */
        if ($request->input('status') == 'follow') {
            $status = 1;
        } elseif ($request->input('status') == 'unfollow') {
            $status = 0;
        }
        else
        {
            return redirect()->back();
        }



        /* Check Follow Table */
        $userFollow = UserFollow::where([
            ['uuid','=',$my_uuid],
            ['follow_uuid','=',$uuid],
        ]);
        do {
            $room_uuid = Str::uuid();
        } while (UserFollow::where("room_uuid", $room_uuid)->first() instanceof UserFollow);

        if ($userFollow->count() > 0) {
            /* Update */
            $userFollow = $userFollow->first();

            if ($userFollow->status == 1) {

                /* Unfollow */
                $UpdateFollow = UserFollow::find($userFollow->id);

                $UpdateFollow->status = 0;

                $UpdateFollow->save();

                return redirect()->back();
            }
            else
            {
                /* Follow */

                $UpdateFollow = UserFollow::find($userFollow->id);

                $UpdateFollow->status = 1;

                $UpdateFollow->save();

                return redirect()->back();
            }
        }
        else
        {
            /* Insert */
            UserFollow::insert([
                [
                    'uuid' => $my_uuid,
                    'follow_uuid' => $uuid,
                    'room_uuid' => $room_uuid,
                    'status' => $status,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
                [
                    'uuid' => $uuid,
                    'follow_uuid' => $my_uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
            ]);

            // $Create_room->save();

            return redirect()->back();
        }

    }
}

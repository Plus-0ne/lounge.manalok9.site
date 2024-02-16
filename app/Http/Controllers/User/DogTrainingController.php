<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Users\TrainingAssistance;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use Auth;
use Carbon;
use Str;
use URL;
use Validator;

class DogTrainingController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                        Dog training assistance page                        */
    /* -------------------------------------------------------------------------- */
    public function index() {

        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Avail dog training | IAGD Members Lounge',
            'notif' => $notif
        );

        return view('pages.users.animal-pages.user-dog-training', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                          Create assistance record                          */
    /* -------------------------------------------------------------------------- */
    public function training_create_assistance(Request $request) {
        /* Check ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.',
            ];
            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(),[
            'updated_contact' => 'required',
        ],[
            'updated_contact.required' => 'Updated contact number is required.',
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first(),
            ];
            return response()->json($data);
        }

        /* Ticket once a day */
        $getUserTickets = TrainingAssistance::where([
            ['user_uuid','=',Auth::guard('web')->user()->uuid],
            ['status','=','1']
        ]);

        if ($getUserTickets->count() > 0) {
            $getLatestTicket = $getUserTickets->orderBy('created_at','DESC')->first();

            $DeferenceInDays = Carbon::parse(Carbon::now())->diffInDays($getLatestTicket->created_at);

            if ($DeferenceInDays < 1) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Thank you for submitting a ticket. We have received your ticket and will reach out to you at the earliest opportunity. Your cooperation is appreciated.',
                ];
                return response()->json($data);
            }
        }

        /* Create new assistance record */
        do {
            $uuid = Str::uuid();
        } while (TrainingAssistance::where("uuid", $uuid)->first() instanceof TrainingAssistance);

        $dataEntryies = [
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,
            'updated_contact' => $request->input('updated_contact'),
            'facebook_link' => ($request->input('facebook_link') == null) ? 'N/A': $request->input('facebook_link'),
            'status' => 1, // 1 = active
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $create_record_assistance = TrainingAssistance::create($dataEntryies);

        /* Check if record is saved */
        if ($create_record_assistance->save()) {
            $data = [
                'status' => 'success',
                'message' => 'Thank you for submitting your training assistance ticket. We will contact you using the provided information. We appreciate your patience and cooperation.',
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Something\'s wrong! Please try again later.',
            ];
            return response()->json($data);
        }
    }
}

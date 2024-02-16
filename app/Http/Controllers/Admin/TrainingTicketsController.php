<?php

namespace App\Http\Controllers\Admin;

use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Users\TrainingAssistance;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;
use URL;
use Validator;

class TrainingTicketsController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                            Training Tickets page                           */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        /* Get all training tickets */
        $trainingTickets = TrainingAssistance::orderBy('status','DESC')->get();

        $data = array(
            'title' => 'Training Tickets | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'trainingTickets' => $trainingTickets
        );

        return view('pages/admins/admin-training-tickets', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                               Close a ticket                               */
    /* -------------------------------------------------------------------------- */
    public function ticket_close(Request $request)
    {
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
            'uuid' => 'required'
        ],[
            'uuid.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first(),
            ];
            return response()->json($data);
        }

        /* Find ticket */
        $trainingTickets = TrainingAssistance::where('uuid',$request->input('uuid'));

        if ($trainingTickets->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Ticket not found',
            ];
            return response()->json($data);
        }

        $updateStatusTicket = TrainingAssistance::find($trainingTickets->first()->id);

        $updateStatusTicket->status = 0; // set as closed

        if (!$updateStatusTicket->save()) {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to closed ticket.',
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Training ticket has been closed.',
        ];
        return response()->json($data);

    }
}

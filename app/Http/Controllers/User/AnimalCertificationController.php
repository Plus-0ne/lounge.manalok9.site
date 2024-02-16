<?php

namespace App\Http\Controllers\User;

use App\Helper\PetHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\AnimalCertRequest;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\MembersRabbit;
use Auth;
use Carbon;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use Str;
use URL;
use Validator;

class AnimalCertificationController extends Controller
{

    /**
     * View certification request page
     *
     * @param  mixed $request
     * @return page view
     */
    public function index(Request $request)
    {
        /* Check get request */
        $validate = Validator::make($request->all(), [
            'PetUUID' => 'required'
        ], [
            'PetUUID.required' => 'Pet uuid is required'
        ]);

        if ($validate->fails()) {

            return redirect()->back()->withErrors($validate);
        }

        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Get animal details */
        $animalDetails = MembersDog::where([
            ['PetUUID', '=', $request->input('PetUUID')],
            ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
        ]);

        $AnimalType = 'dog';

        if ($animalDetails->count() < 1) {
            $animalDetails = MembersCat::where([
                ['PetUUID', '=', $request->input('PetUUID')],
                ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
            ]);
            $AnimalType = 'cat';

            if ($animalDetails->count() < 1) {
                $animalDetails = MembersRabbit::where([
                    ['PetUUID', '=', $request->input('PetUUID')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);
                $AnimalType = 'rabbit';

                if ($animalDetails->count() < 1) {
                    $animalDetails = MembersBird::where([
                        ['PetUUID', '=', $request->input('PetUUID')],
                        ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ]);
                    $AnimalType = 'bird';

                    if ($animalDetails->count() < 1) {
                        $animalDetails = MembersOtherAnimal::where([
                            ['PetUUID', '=', $request->input('PetUUID')],
                            ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                        ]);
                        $AnimalType = 'others';
                    }
                }
            }
        }

        if ($animalDetails->count() < 1) {

            $data = [
                'status' => 'warning',
                'message' => 'Animal not found!'
            ];

            return redirect()->back()->with($data);
        }

        /* Javascript variables */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'pet_uuid' => $request->input('PetUUID'),
            'AnimalType' => $AnimalType,
            'previousUrl' => URL::previous()
        ]);

        /*
            * Check if certification request is pending
        */
        $certificationRequest = AnimalCertRequest::where('animal_uuid',$request->input('PetUUID'));

        $data = array(
            'title' => 'Request certification | IAGD Members Lounge',
            'notif' => $notif,
            'animalDetails' => $animalDetails,
            'certificationRequest' => $certificationRequest->count()
        );

        return view('pages.users.animal-pages.user-certification-request', ['data' => $data]);
    }

    /**
     * Create new certification request
     *
     * @param  mixed $request
     * @return JSON
     */
    public function request_cert_create(Request $request)
    {
        /*
            * Check if request is ajax
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];

            return response()->json($data);
        }

        /*
            * Validate all request
        */
        $validate = Validator::make($request->all(), [
            'animalUuid' => 'required',
            'animal_type' => 'required'
        ], [
            'animalUuid.required' => 'Animal uuid is required.',
            'animal_type.required' => 'Animal type is required.'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }
        /*
            * Check if pet exist
        */
        $pet = PetHelper::petExists($request);

        if ($pet < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'This pet doesn\'t exist!'
            ];

            return response()->json($data);
        }
        /*
            * Check if pet registration is approved
        */
        $petStatus = PetHelper::isPetStatusRegistered($request);
        if ($petStatus < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Your pet is not fully registered!'
            ];

            return response()->json($data);
        }
        /*
            * Check if request exist
        */
        $checkRequest = AnimalCertRequest::where('animal_uuid', $request->input('animalUuid'));

        if ($checkRequest->count() > 0) {
            /* Check status */
            if ($checkRequest->first()->status < 2) { // Pending

                $data = [
                    'status' => 'warning',
                    'message' => 'You have an existing request for certification!'
                ];

                return response()->json($data);
            }

            if ($checkRequest->first()->status != 3) { // approved

                $data = [
                    'status' => 'warning',
                    'message' => 'Contact us to request new certifcation!'
                ];

                return response()->json($data);
            }
        }

        do {
            $uuid = Str::uuid();
        } while (AnimalCertRequest::where("uuid", $uuid)->first() instanceof AnimalCertRequest);

        // if certificateOnly = 1 pedigree = 0
        switch ($request->input('certificateOnly')) {
            case 1:
                $incPed = 0;
                break;

            default:
                $incPed = 1;
                break;
        }
        $insertData = [
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,

            'animal_uuid' => $request->input('animalUuid'),
            'include_pedigree_cert' => $incPed,
            'certificate_holder' => $request->input('withCertificateHolder'),
            'certificate_only' => $request->input('certificateOnly'),
            'fb_account' => $request->input('fb_account'),
            'status' => 0, // Pending
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'animal_type' => $request->input('animal_type')
        ];
        /* Create certification request */
        $createcertRequest = AnimalCertRequest::create($insertData);

        if (!$createcertRequest->save()) {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to save request! Please try again later.'
            ];

            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Your request for certification has been submitted.'
        ];

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Helper\PetRegistrationHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\MembersRabbit;
use App\Models\Users\NonMemberRegistration;
use App\Models\Users\RegistryBird;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryOtherAnimal;
use App\Models\Users\RegistryRabbit;
use App\Models\Users\StorageFile;
use Auth;
use Carbon;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JavaScript;
use Notif_Helper;
use Session;
use Str;
use URL;
use Validator;

class PetController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                Pet page view                               */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/'),

        ]);

        $data = array(
            'title' => 'Pets | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/animal-pages/pets', ["data" => $data]);
    }
    /* -------------------------------------------------------------------------- */
    /*                              Ajax get all pets                             */
    /* -------------------------------------------------------------------------- */
    public  function get_all_pets(Request $request)
    {
        /* Check if ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];

            return response()->json($data);
        }


        /* Check if post request */
        $validate = Validator::make($request->all(), [
            'selectPet' => 'required'
        ], [
            'selectPet.required' => 'Please select a pet.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }



        /* Pet type */
        $pet_type = $request->input('selectPet');

        switch ($pet_type) {
            case 'cats':
                if ($request->input('premorn') == 'non_prem') {
                    $pets = MembersCat::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                } else {
                    $pets = RegistryCat::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                }
                break;
            case 'birds':

                if ($request->input('premorn') == 'non_prem') {
                    $pets = MembersBird::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                } else {
                    $pets = RegistryBird::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                }

                break;

            case 'rabbits':

                if ($request->input('premorn') == 'non_prem') {
                    $pets = MembersRabbit::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                } else {
                    $pets = RegistryRabbit::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                }


                break;

            case 'others':

                if ($request->input('premorn') == 'non_prem') {
                    $pets = MembersOtherAnimal::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                } else {
                    $pets = RegistryOtherAnimal::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                }



                break;

            default:

                if ($request->input('premorn') == 'non_prem') {
                    $pets = MembersDog::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                } else {
                    $pets = RegistryDog::where('OwnerUUID', Auth::guard('web')->user()->uuid);
                }


                break;
        }

        /* Search */
        if (!empty($request->input('pet_name'))) {
            $pets->where('PetName', 'like', '%' . $request->input('pet_name') . '%');
        }

        /* Sort */
        $sorting = $request->input('sorting');
        switch ($sorting) {

            case 'date_added':
                $sortingBy = 'DateAdded';
                break;

            case 'status':
                $sortingBy = 'status';
                break;

            default:
                $sortingBy = 'PetName';
                break;
        }

        $pets->orderBy($sortingBy, $request->input('order_by'));
        $pets->with('AdtlInfo')->with('AdtlInfo.petImage');

        $data = [
            'status' => 'success',
            'message' => 'All pets has been fetched.',
            'pets' => $pets->paginate(21)
        ];

        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                         Show pet form page for dog                         */
    /* -------------------------------------------------------------------------- */
    public function form_register_dog(Request $request)
    {
        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Dog registration | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/animal-pages/form-registration-dog', ["data" => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Register new dog                              */
    /* -------------------------------------------------------------------------- */
    public function register_new_dog(Request $request)
    {
        /*
            * Validation : Check if response is not json
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Validation : Validate form input request
        */
        $dogValidation = PetRegistrationHelper::dogValidations($request);
        if ($dogValidation) {
            $data = $dogValidation;
            return response()->json($data);
        }

        /*
            * Create custom value if input is null
        */

        $FullName = Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name;
        $ContactNumber = (!empty(Auth::guard('web')->user()->contact_number) ? Auth::guard('web')->user()->contact_number : 'N/A');
        $EmailAddress = Auth::guard('web')->user()->email_address;
        $microchip = (!empty($request->input('microchip')) ? $request->input('microchip') : 'N/A');
        $age = $request->input('age');
        $cveter_name = (!empty($request->input('cveter_name')) ? $request->input('cveter_name') : 'N/A');
        $cveter_url = (!empty($request->input('cveter_url')) ? $request->input('cveter_url') : 'N/A');

        $kennel_name = (!empty($request->input('kennel_name')) ? $request->input('kennel_name') : 'N/A');
        $kennel_link = (!empty($request->input('kennel_link')) ? $request->input('kennel_link') : 'N/A');

        $breeder_name = (!empty($request->input('breeder_name')) ? $request->input('breeder_name') : 'N/A');
        $breeder_link = (!empty($request->input('breeder_link')) ? $request->input('breeder_link') : 'N/A');

        $sire_name = (!empty($request->input('sire_name')) ? $request->input('sire_name') : 'N/A');
        $sire_breed = (!empty($request->input('sire_breed')) ? $request->input('sire_breed') : 'N/A');
        $sire_iagd_num = (!empty($request->input('sire_iagd_num')) ? $request->input('sire_iagd_num') : 'N/A');

        $dam_name = (!empty($request->input('dam_name')) ? $request->input('dam_name') : 'N/A');
        $dam_breed = (!empty($request->input('dam_breed')) ? $request->input('dam_breed') : 'N/A');
        $dam_iagd_num = (!empty($request->input('dam_iagd_num')) ? $request->input('dam_iagd_num') : 'N/A');


        /*
            * Check if dog exist
        */
        $dogStatus = PetRegistrationHelper::checkDogInDB($request);
        if ($dogStatus) {
            $data = $dogStatus;
            return response()->json($data);
        }

        /*
            * Start database transaction
        */
        DB::beginTransaction();

        /*
            * Upload dog image
        */
        $uploadDogImage = PetRegistrationHelper::uploadDogImage($request);
        if ($uploadDogImage) {

            /*
                * Rollback database transaction
            */
            DB::rollBack();

            $data = $uploadDogImage;
            return response()->json($data);
        }

        /*
            * Upload dog supporting documents
        */
        $dogSuppDoc = PetRegistrationHelper::uploadDogSupportingDoc($request);
        if ($dogSuppDoc) {

            /*
                * Rollback database transaction
            */
            DB::rollBack();

            /*
                * Image remove if error in registration
            */
            PetRegistrationHelper::imageRemoveIfError();

            $data = $dogSuppDoc;
            return response()->json($data);
        }

        /*
            * Upload dog Veterenary record
        */
        $vetRecord = PetRegistrationHelper::veterenaryRecordUpload($request);
        if ($vetRecord) {

            /*
                * Rollback database transaction
            */
            DB::rollBack();

            /*
                * Image remove if error in registration
            */
            PetRegistrationHelper::imageRemoveIfError();

            $data = $vetRecord;
            return response()->json($data);
        }

        /*
            * Upload sire image
        */
        $sireImage = PetRegistrationHelper::siresImageUpload($request);
        if ($sireImage) {

            /*
               * Rollback database transaction
           */
            DB::rollBack();

            /*
                * Image remove if error in registration
            */
            PetRegistrationHelper::imageRemoveIfError();


            $data = $sireImage;
            return response()->json($data);
        }

        /*
            * Upload sire supporting documents
        */
        $sireSuppDocUpload = PetRegistrationHelper::sireSuppDocUpload($request);
        if ($sireSuppDocUpload) {

            /*
                * Rollback database transaction
            */
            DB::rollBack();

            /*
                * Image remove if error in registration
            */
            PetRegistrationHelper::imageRemoveIfError();

            $data = $sireSuppDocUpload;
            return response()->json($data);
        }

        /*
            * Upload dam image
        */
        $damImageUpload = PetRegistrationHelper::damImageUpload($request);
        if ($damImageUpload) {

            /*
               * Rollback database transaction
           */
            DB::rollBack();

            /*
               * Image remove if error in registration
           */
            PetRegistrationHelper::imageRemoveIfError();

            $data = $damImageUpload;
            return response()->json($data);
        }

        /*
            * Upload dam supporting document
        */
        $damSuppDocUpload = PetRegistrationHelper::damSuppDocUpload($request);
        if ($damSuppDocUpload) {

            /*
               * Rollback database transaction
           */
            DB::rollBack();

            /*
               * Image remove if error in registration
           */
            PetRegistrationHelper::imageRemoveIfError();

            $data = $damSuppDocUpload;
            return response()->json($data);
        }


        /*
            * Insert to wm_members_dog table
        */
        do {
            $PetUUID = Str::uuid();
        } while (MembersDog::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersDog);

        $registerDog = MembersDog::create([
            'PetUUID' => $PetUUID,
            'OwnerUUID' => Auth::guard('web')->user()->uuid,
            'OwnerIAGDNo' => (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : null),
            'PetName' => $request->input('name'),
            'BirthDate' => $request->input('birth_date'),
            'Gender' => ($request->input('gender') == 'male' ? 'male' : 'female'),
            'Location' => $request->input('address_location'),
            'Breed' => $request->input('breed'),
            // 'Breeder' => $request->input('pet_breeder'),
            'Markings' => $request->input('dogs_marking'),
            'PetColor' => $request->input('dog_color'),
            'EyeColor' => $request->input('eye_color'),
            'Height' => $request->input('height'),
            'Weight' => $request->input('weight'),
            // 'SireName' => $request->input('pet_sirename'),
            // 'DamName' => $request->input('pet_damname'),
            'Co_Owner' => (!empty($request->input('co_owner')) ? $request->input('co_owner') : 'N/A'),
            'DateAdded' => Carbon::now(),
            'non_member' => 1,
        ]);

        /*
            * Check if dog is registered
        */
        if (!$registerDog->save()) {

            /*
                * Rollback database transaction
            */
            DB::rollBack();

            /*
                * Image remove if error in registration
            */
            PetRegistrationHelper::imageRemoveIfError();

            /*
                * Throw saving error
            */
            $data = [
                'status' => 'error',
                'message' => 'Failed to register your dog.'
            ];
            return response()->json($data);
        }

        /*
            * Create non member registration
        */

        do {
            $UUID = Str::uuid();
        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);
        do {
            $photo = Str::uuid();
        } while (NonMemberRegistration::where('Photo', '=', $photo)->first()  instanceof NonMemberRegistration);


        $create_new_nm_registration = NonMemberRegistration::create([
            'UUID' => $UUID,
            'FullName' => $FullName,
            'ContactNumber' => $ContactNumber,
            'EmailAddress' => $EmailAddress,

            'MicrochipNo' => $microchip,
            'AgeInMonths' => $age,
            'VetClinicName' => $cveter_name,
            'VetOnlineProfile' => $cveter_url,

            'ShelterInfo' => $kennel_name,
            'ShelterOnlineProfile' => $kennel_link,

            'BreederInfo' => $breeder_name,
            'BreederOnlineProfile' => $breeder_link,

            'SireName' => $sire_name,
            'SireBreed' => $sire_breed,
            'SireRegNo' => $sire_iagd_num,

            'DamName' => $dam_name,
            'DamBreed' => $dam_breed,
            'DamRegNo' => $dam_iagd_num,

            'Type' => 'dog',
            'PetUUID' => $PetUUID,
            'Photo' => $photo
        ]);

        /*
            * Check if non registration is inserted
        */
        if (!$create_new_nm_registration->save()) {
            /*
                * Rollback database transaction
            */
            DB::rollBack();

            /*
               * Image remove if error in registration
           */
            PetRegistrationHelper::imageRemoveIfError();

            /*
               * Throw saving error
           */
            $data = [
                'status' => 'error',
                'message' => 'Failed to register your dog.'
            ];
            return response()->json($data);
        }

        /*
            * Store all image path to storage file table
        */
        PetRegistrationHelper::insertSessionImageToDB($photo);

        /*
            * Commit transaction
        */
        DB::commit();

        /*
            * Clear image session
        */
        PetRegistrationHelper::clearImageInSession();

        $data = [
            'status' => 'success',
            'message' => 'Registration success! Please wait while we review your registration. We will contact you soon. Thank you!'
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                      Get pet uuid for pet details page                     */
    /* -------------------------------------------------------------------------- */
    public function pet_details(Request $request)
    {
        /*
            * Validate pet uuid in get request
        */
        $validate = Validator::make($request->all(), [
            'petUuid' => 'required',
            'petName' => 'required',
            'type' => 'required',
        ], [
            'petUuid.required' => 'Something\'s wrong! Please try again later.',
            'petName.required' => 'Something\'s wrong! Please try again later.',
            'type.required' => 'Something\'s wrong! Please try again later.'
        ]);

        /*
            * If validation fails redirect back to pets page
        */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /*
            * Get all notifications
        */
        $notif = Notif_Helper::GetUserNotification();

        /*
            * Javascript variables
        */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/'),
            'petUuid' => $request->input('petUuid'),
            'petName' => $request->input('petName'),
            'species' => $request->input('type'),
        ]);

        /*
            * Get pet details using petUuid
        */
        switch ($request->input('type')) {
            case 'dogs':
                $pDetails = MembersDog::where([['PetUUID', '=', $request->input('petUuid')], ['PetName', '=', $request->input('petName')]])
                    ->first();
                break;
            case 'cats':
                $pDetails = MembersCat::where([['PetUUID', '=', $request->input('petUuid')], ['PetName', '=', $request->input('petName')]])
                    ->first();
                break;
            case 'birds':
                $pDetails = MembersBird::where([['PetUUID', '=', $request->input('petUuid')], ['PetName', '=', $request->input('petName')]])
                    ->first();
                break;
            case 'rabbits':
                $pDetails = MembersRabbit::where([['PetUUID', '=', $request->input('petUuid')], ['PetName', '=', $request->input('petName')]])
                    ->first();
                break;
            case 'others':
                $pDetails = MembersOtherAnimal::where([['PetUUID', '=', $request->input('petUuid')], ['PetName', '=', $request->input('petName')]])
                    ->first();
                break;

            default:
                $data = [
                    'status' => 'warning',
                    'message' => 'Pet type invalid!'
                ];
                return redirect()->back()->with($data);
        }
        $data = array(
            'title' => 'Pets | IAGD Members Lounge',
            'notif' => $notif,
            'pDetails' => $pDetails,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/animal-pages/pets-view-dog', ["data" => $data]);
    }

    /**
     * Delete registered pet
     *
     * @param Request $request
     *
     * @return [array]
     */
    public function petDelete(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Validate all request return validation errors if validation fails
        */
        $validate = Validator::make($request->all(), [
            'petUuid' => 'required',
            'petName' => 'required',
            'species' => 'required',
        ], [
            'petUuid.required' => 'Something\'s wrong! Please try again later.',
            'petName.required' => 'Something\'s wrong! Please try again later.',
            'species.required' => 'Something\'s wrong! Please try again later.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /*
            * Find pet using $request->input()
        */
        switch ($request->input('species')) {
            case 'cats':
                $pets = MembersCat::where([
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['PetUUID', '=', $request->input('petUuid')],
                ]);
                break;
            case 'dogs':
                $pets = MembersDog::where([
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['PetUUID', '=', $request->input('petUuid')],
                ]);
                break;
            case 'birds':
                $pets = MembersBird::where([
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['PetUUID', '=', $request->input('petUuid')],
                ]);
                break;
            case 'rabbits':
                $pets = MembersRabbit::where([
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['PetUUID', '=', $request->input('petUuid')],
                ]);
                break;

            case 'others':
                $pets = MembersOtherAnimal::where([
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['PetUUID', '=', $request->input('petUuid')],
                ]);
                break;

            default:
                $data = [
                    'status' => 'warning',
                    'message' => 'Pet species unknown!'
                ];
                return response()->json($data);
        }

        if ($pets->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Pet not found!'
            ];
            return response()->json($data);
        }

        /*
            * Check if deleted pet is approved . cancel delete if pet is approved
        */
        if ($pets->first()->status == 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Your pet registration has been approved! you can\'t delete this pet.'
            ];
            return response()->json($data);
        }

        /*
            * Get all image path then remove pet uploads
        */
        $data = $pets->with('AdtlInfo')->with('AdtlInfo.petImageUploads')->first();
        PetRegistrationHelper::removePetUploads($data);

        /*
            * Remove pet data
        */
        if (!$data->delete()) {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to delete this pet.'
            ];
            return response()->json($data);
        }

        /*
            * Delete aditional information
        */
        if (!empty($data->AdtlInfo->Photo)) {
            $petUploads = StorageFile::where('uuid', $data->AdtlInfo->Photo);
            $petUploads->delete();
        }

        $data->AdtlInfo()->delete();

        /*
            * If delete successful return success JSON array
        */
        $data = [
            'status' => 'success',
            'message' => 'Pet has been deleted.'
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                            Form cat registration                           */
    /* -------------------------------------------------------------------------- */
    public function formCatRegistration(Request $request)
    {

        /* get all notification */
        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Cat registration | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/animal-pages/form-registration-cat', ["data" => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                                Cat register                                */
    /* -------------------------------------------------------------------------- */
    public function petRegister(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validation : Validate form input request
        */
        $requestValidation = PetRegistrationHelper::validatePetRegistrationRequest($request);
        if ($requestValidation) {
            $data = $requestValidation;
            return response()->json($data);
        }

        /*
            * Check if pet exist
        */
        $checkPetInRegistry = PetRegistrationHelper::checkPetInRegistry($request);
        if ($checkPetInRegistry->count() > 0) {
            $data = [
                'status' => 'warning',
                'message' => 'Your pet is already registered.'
            ];
            return response()->json($data);
        }

        /*
            * Upload pet images
        */
        $petImageUpload = PetRegistrationHelper::uploadPetImage($request);
        if ($petImageUpload == false) {
            /*
                * Remove pet registration uploads
            */
            PetRegistrationHelper::removePetUploadOnError();

            $data = [
                'status' => 'error',
                'message' => 'Failed to upload pet image.'
            ];
            return response()->json($data);
        }

        /*
            * Pet upload supporting documents
        */
        $petSupportingDocument = PetRegistrationHelper::petSupportingDocumentUpload($request);
        if ($petSupportingDocument != null) {
            if ($petSupportingDocument['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $petSupportingDocument['status'],
                    'message' => $petSupportingDocument['message']
                ];
                return response()->json($data);
            }
        }


        /*
            * Upload vet record
        */
        $petVetRecordUpload = PetRegistrationHelper::petVetRecordUpload($request);
        if ($petVetRecordUpload != null) {
            if ($petVetRecordUpload['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $petVetRecordUpload['status'],
                    'message' => $petVetRecordUpload['message']
                ];
                return response()->json($data);
            }
        }


        /*
            * Upload sire image
        */
        $uploadSireImage = PetRegistrationHelper::uploadSireImage($request);
        if ($uploadSireImage != null) {
            if ($uploadSireImage['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $uploadSireImage['status'],
                    'message' => $uploadSireImage['message']
                ];
                return response()->json($data);
            }
        }

        /*
            * Upload sire supporting document
        */
        $uploadSireSupportingDocuments = PetRegistrationHelper::uploadSireSupportingDocuments($request);
        if ($uploadSireSupportingDocuments != null) {
            if ($uploadSireSupportingDocuments['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $uploadSireSupportingDocuments['status'],
                    'message' => $uploadSireSupportingDocuments['message']
                ];
                return response()->json($data);
            }
        }

        /*
            * Upload dam image
        */
        $uploadDamImage = PetRegistrationHelper::uploadDamImage($request);
        if ($uploadDamImage != null) {
            if ($uploadDamImage['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $uploadDamImage['status'],
                    'message' => $uploadDamImage['message']
                ];
                return response()->json($data);
            }
        }

        /*
            * Upload dam supporting document
        */
        $uploadDamSupportingDocument = PetRegistrationHelper::uploadDamSupportingDocument($request);
        if ($uploadDamSupportingDocument != null) {
            if ($uploadDamSupportingDocument['status'] != 'success') {
                /*
                    * Remove pet registration uploads
                */
                PetRegistrationHelper::removePetUploadOnError();

                $data = [
                    'status' => $uploadDamSupportingDocument['status'],
                    'message' => $uploadDamSupportingDocument['message']
                ];
                return response()->json($data);
            }
        }

        /*
            * Update null values in post requests
        */
        $animalType = $request->input('animalType');
        $FullName = Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name;
        $ContactNumber = (!empty(Auth::guard('web')->user()->contact_number) ? Auth::guard('web')->user()->contact_number : 'N/A');
        $EmailAddress = Auth::guard('web')->user()->email_address;
        $microchip = (!empty($request->input('microchip')) ? $request->input('microchip') : 'N/A');
        $age = $request->input('age');
        $cveter_name = (!empty($request->input('cveter_name')) ? $request->input('cveter_name') : 'N/A');
        $cveter_url = (!empty($request->input('cveter_url')) ? $request->input('cveter_url') : 'N/A');

        $kennel_name = (!empty($request->input('kennel_name')) ? $request->input('kennel_name') : 'N/A');
        $kennel_link = (!empty($request->input('kennel_link')) ? $request->input('kennel_link') : 'N/A');

        $breeder_name = (!empty($request->input('breeder_name')) ? $request->input('breeder_name') : 'N/A');
        $breeder_link = (!empty($request->input('breeder_link')) ? $request->input('breeder_link') : 'N/A');

        $sire_name = (!empty($request->input('sire_name')) ? $request->input('sire_name') : 'N/A');
        $sire_breed = (!empty($request->input('sire_breed')) ? $request->input('sire_breed') : 'N/A');
        $sire_iagd_num = (!empty($request->input('sire_iagd_num')) ? $request->input('sire_iagd_num') : 'N/A');

        $dam_name = (!empty($request->input('dam_name')) ? $request->input('dam_name') : 'N/A');
        $dam_breed = (!empty($request->input('dam_breed')) ? $request->input('dam_breed') : 'N/A');
        $dam_iagd_num = (!empty($request->input('dam_iagd_num')) ? $request->input('dam_iagd_num') : 'N/A');

        /*
            * Start database transaction
        */
        DB::beginTransaction();

        /*
            * Insert pet in registration
        */
        $registerNewPet = PetRegistrationHelper::registerNewPet($request);
        if ($registerNewPet === false) {

            /*
                * Remove pet registration uploads
            */
            PetRegistrationHelper::removePetUploadOnError();

            $data = [
                'status' => 'error',
                'message' => 'Failed to save pet registration. Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Create non member registration
        */

        do {
            $UUID = Str::uuid();
        } while (NonMemberRegistration::where('UUID', '=', $UUID)->first()  instanceof NonMemberRegistration);
        do {
            $photo = Str::uuid();
        } while (NonMemberRegistration::where('Photo', '=', $photo)->first()  instanceof NonMemberRegistration);


        $createNewNmRegistration = NonMemberRegistration::create([
            'UUID' => $UUID,
            'FullName' => $FullName,
            'ContactNumber' => $ContactNumber,
            'EmailAddress' => $EmailAddress,

            'MicrochipNo' => $microchip,
            'AgeInMonths' => $age,
            'VetClinicName' => $cveter_name,
            'VetOnlineProfile' => $cveter_url,

            'ShelterInfo' => $kennel_name,
            'ShelterOnlineProfile' => $kennel_link,

            'BreederInfo' => $breeder_name,
            'BreederOnlineProfile' => $breeder_link,

            'SireName' => $sire_name,
            'SireBreed' => $sire_breed,
            'SireRegNo' => $sire_iagd_num,

            'DamName' => $dam_name,
            'DamBreed' => $dam_breed,
            'DamRegNo' => $dam_iagd_num,

            'Type' => $animalType,
            'PetUUID' => $registerNewPet->PetUUID,
            'Photo' => $photo
        ]);

        if (!$createNewNmRegistration->save()) {
            /*
                * Remove pet registration uploads
            */
            PetRegistrationHelper::removePetUploadOnError();

            /*
                * Rollback database insert
            */
            DB::rollBack();

            $data = [
                'status' => 'error',
                'message' => 'Failed to save pet registration. Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Store all image path to storage file table
        */
        PetRegistrationHelper::insertPetUploadInSessions($photo,$animalType);

        /*
           * Commit transaction
       */
        DB::commit();

        /*
           * Clear image session
       */
        PetRegistrationHelper::clearSessionPetImages();

        $data = [
            'status' => 'success',
            'message' => 'Registration success! Please wait while we review your registration. We will contact you soon. Thank you!'
        ];
        return response()->json($data);
    }
    /* -------------------------------------------------------------------------- */
    /*                                 Cat remove                                 */
    /* -------------------------------------------------------------------------- */
    public function petRemove(Request $request)
    {
        /*
            Todo : -------------
        */
    }
    /* -------------------------------------------------------------------------- */
    /*                                 Cat update                                 */
    /* -------------------------------------------------------------------------- */
    public function petUpdate(Request $request)
    {
        /*
            Todo : -------------
        */
    }

    /* -------------------------------------------------------------------------- */
    /*                           Form bird registration                           */
    /* -------------------------------------------------------------------------- */
    public function formBirdRegistration() {
        /*
            * get all notification
        */
        $notif = Notif_Helper::GetUserNotification();

        /*
            * Javascript variables
        */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Bird registration | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );
        return view('pages/users/animal-pages/form-registration-bird', ["data" => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                          Form rabbit registration                          */
    /* -------------------------------------------------------------------------- */
    public function formRabbitRegistration()
    {
        /*
            * get all notification
        */
       $notif = Notif_Helper::GetUserNotification();

       /*
           * Javascript variables
       */
       JavaScript::put([
           'ruuid' => Auth::guard('web')->user()->uuid,
           'assetUrl' => asset('/'),
           'currentBaseUrl' => URL::to('/')
       ]);

       $data = array(
           'title' => 'Rabbit registration | IAGD Members Lounge',
           'notif' => $notif,
           'analytics' => CustomHelper::analytics()
       );
       return view('pages/users/animal-pages/form-registration-rabbit', ["data" => $data]);
    }
}

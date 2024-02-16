<?php

namespace App\Helper;

use App\Models\Users\AnimalCertRequest;
use App\Models\Users\MembersBird;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\MembersRabbit;
use Auth;

class PetHelper
{

    /**
     * Check if pet exist
     *
     * @param  mixed $request
     * @return number
     */
    public static function petExists($request)
    {
        /*
            * Set variables
        */
        $pet = null;

        /*
            * Check animal type to select table
        */
        switch ($request->input('animal_type')) {
            case 'cat':
                $pet = MembersCat::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);
                break;

            case 'dog':
                $pet = MembersDog::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);
                break;
            case 'rabbit':
                $pet = MembersRabbit::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);
                break;

            case 'bird':
                $pet = MembersBird::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);
                break;


            default:
                $pet = MembersOtherAnimal::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                ]);

                break;
        }

        /*
            * Return pet count
        */
        return $pet->count();

    }

    /**
     * Check pet status registered
     *
     * @param  mixed $request
     * @return number
     */
    public static function isPetStatusRegistered($request) {
        /*
            * Set variables
        */
        $pet = null;

        /*
            * Check animal type to select table
        */
        switch ($request->input('animal_type')) {
            case 'cat':
                $pet = MembersCat::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['status', '=', 2],
                ]);
                break;

            case 'dog':
                $pet = MembersDog::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['status', '=', 2],
                ]);
                break;
            case 'rabbit':
                $pet = MembersRabbit::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['status', '=', 2],
                ]);
                break;

            case 'bird':
                $pet = MembersBird::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['status', '=', 2],
                ]);
                break;


            default:
                $pet = MembersOtherAnimal::where([
                    ['PetUUID', '=', $request->input('animalUuid')],
                    ['OwnerUUID', '=', Auth::guard('web')->user()->uuid],
                    ['status', '=', 2],
                ]);

                break;
        }

        /*
            * Return pet count
        */
        return $pet->count();
    }

    /**
     * Get pet certification request status
     *
     * @param  mixed $request
     * @return void
     */
    public static function getPetCertificationRequestStatus($request) {
        /*
            * Set variables
        */
        $petCertStatus = null;

        /*
           * Get pet certification status
        */
        $petCertStatus = AnimalCertRequest::where('animal_uuid',$request->input('animalUuid'))->orderBy('id','DESC');
        /*
            * Return pet status
        */
       return $petCertStatus->first();
    }

}

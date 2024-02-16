<?php

namespace App\Http\Controllers\Admin;

use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\RegistrationDogModel;
use App\Models\Admin\RegistrationCatModel;
use App\Models\Admin\RegistrationRabbitModel;
use App\Models\Admin\RegistrationBirdModel;
use App\Models\Admin\RegistrationOtherModel;

use App\Models\Admin\RegistrationPetDetailsModel;
use Auth;

class PetRegistrationController extends Controller
{

    /* -------------------------------------------------------------------------- */
    /*                           Get admin user details                           */
    /* -------------------------------------------------------------------------- */
    public function adminUserDetails()
    {
        /* Get user details */
        $adminDetails = AdminModel::find(Auth::guard('web_admin')->user()->id)
        ->with('userAccount')
        ->first();
        return $adminDetails;
    }

	public function Dog_Registration(Request $request)
	{
        /* Get user details */
        $adminDetails = $this->adminUserDetails();
		$registration_dog = RegistrationDogModel::with('AdtlInfo', 'OwnerInfo');

        $search = $request->input('search');
        if ($search != null) {
            $registration_dog = $registration_dog->where(function($q) use ($search) {
                $q->where('PetUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerIAGDNo', 'like', '%'. $search .'%')
                    ->orWhere('PetName', 'like', '%'. $search .'%')
                    ->orWhere('BirthDate', 'like', '%'. $search .'%')
                    ->orWhere('Gender', 'like', '%'. $search .'%')
                    ->orWhere('Breed', 'like', '%'. $search .'%')
                    ->orWhere('EyeColor', 'like', '%'. $search .'%')
                    ->orWhere('PetColor', 'like', '%'. $search .'%')
                    ->orWhere('Markings', 'like', '%'. $search .'%')
                    ->orWhere('Height', 'like', '%'. $search .'%')
                    ->orWhere('Weight', 'like', '%'. $search .'%')
                    ->orWhere('Location', 'like', '%'. $search .'%')
                    ->orWhere('Co_Owner', 'like', '%'. $search .'%');
            });
        }

		$data = array(
			'title' => 'Registration - Dog | International Animal Genetics Database',
			'registration_dog' => $registration_dog->paginate(10),
            'adminDetails' => $adminDetails
		);

		return view('pages/admins/admin-registration-dog',['data'=>$data]);
	}
	public function Cat_Registration(Request $request)
	{
        /* Get user details */
        $adminDetails = GetAdminAccount::get();
		$registration_cat = RegistrationCatModel::with('AdtlInfo', 'OwnerInfo');

        $search = $request->input('search');
        if ($search != null) {
            $registration_cat = $registration_cat->where(function($q) use ($search) {
                $q->where('PetUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerIAGDNo', 'like', '%'. $search .'%')
                    ->orWhere('PetName', 'like', '%'. $search .'%')
                    ->orWhere('BirthDate', 'like', '%'. $search .'%')
                    ->orWhere('Gender', 'like', '%'. $search .'%')
                    ->orWhere('EyeColor', 'like', '%'. $search .'%')
                    ->orWhere('PetColor', 'like', '%'. $search .'%')
                    ->orWhere('Markings', 'like', '%'. $search .'%')
                    ->orWhere('Height', 'like', '%'. $search .'%')
                    ->orWhere('Weight', 'like', '%'. $search .'%')
                    ->orWhere('Location', 'like', '%'. $search .'%')
                    ->orWhere('Co_Owner', 'like', '%'. $search .'%');
            });
        }

		$data = array(
			'title' => 'Registration - Cat | International Animal Genetics Database',
			'registration_cat' => $registration_cat->paginate(10),
            'adminDetails' => $adminDetails
		);

		return view('pages/admins/admin-registration-cat',['data'=>$data]);
	}
	public function Rabbit_Registration(Request $request)
	{

        /* Get user details */
        $adminDetails = $this->adminUserDetails();

		$registration_rabbit = RegistrationRabbitModel::with('AdtlInfo', 'OwnerInfo');

        $search = $request->input('search');
        if ($search != null) {
            $registration_rabbit = $registration_rabbit->where(function($q) use ($search) {
                $q->where('PetUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerIAGDNo', 'like', '%'. $search .'%')
                    ->orWhere('PetName', 'like', '%'. $search .'%')
                    ->orWhere('BirthDate', 'like', '%'. $search .'%')
                    ->orWhere('Gender', 'like', '%'. $search .'%')
                    ->orWhere('Breed', 'like', '%'. $search .'%')
                    ->orWhere('EyeColor', 'like', '%'. $search .'%')
                    ->orWhere('PetColor', 'like', '%'. $search .'%')
                    ->orWhere('Markings', 'like', '%'. $search .'%')
                    ->orWhere('Height', 'like', '%'. $search .'%')
                    ->orWhere('Weight', 'like', '%'. $search .'%')
                    ->orWhere('Location', 'like', '%'. $search .'%')
                    ->orWhere('Co_Owner', 'like', '%'. $search .'%');
            });
        }

		$data = array(
			'title' => 'Registration - Rabbit | International Animal Genetics Database',
			'registration_rabbit' => $registration_rabbit->paginate(10),
            'adminDetails' => $adminDetails

		);

		return view('pages/admins/admin-registration-rabbit',['data'=>$data]);
	}
	public function Bird_Registration(Request $request)
	{
        /* Get user details */
        $adminDetails = $this->adminUserDetails();
		$registration_bird = RegistrationBirdModel::with('AdtlInfo', 'OwnerInfo');

        $search = $request->input('search');
        if ($search != null) {
            $registration_bird = $registration_bird->where(function($q) use ($search) {
                $q->where('PetUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerIAGDNo', 'like', '%'. $search .'%')
                    ->orWhere('PetName', 'like', '%'. $search .'%')
                    ->orWhere('BirthDate', 'like', '%'. $search .'%')
                    ->orWhere('Gender', 'like', '%'. $search .'%')
                    ->orWhere('EyeColor', 'like', '%'. $search .'%')
                    ->orWhere('PetColor', 'like', '%'. $search .'%')
                    ->orWhere('Markings', 'like', '%'. $search .'%')
                    ->orWhere('Height', 'like', '%'. $search .'%')
                    ->orWhere('Weight', 'like', '%'. $search .'%')
                    ->orWhere('Location', 'like', '%'. $search .'%')
                    ->orWhere('Co_Owner', 'like', '%'. $search .'%');
            });
        }

		$data = array(
			'title' => 'Registration - Bird | International Animal Genetics Database',
			'registration_bird' => $registration_bird->paginate(10),
            'adminDetails' => $adminDetails
		);

		return view('pages/admins/admin-registration-bird',['data'=>$data]);
	}
	public function Other_Registration(Request $request)
	{
        /* Get user details */
        $adminDetails = $this->adminUserDetails();
		$registration_other = RegistrationOtherModel::with('AdtlInfo', 'OwnerInfo');

        $search = $request->input('search');
        if ($search != null) {
            $registration_other = $registration_other->where(function($q) use ($search) {
                $q->where('PetUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerUUID', 'like', '%'. $search .'%')
					->orWhere('OwnerIAGDNo', 'like', '%'. $search .'%')
                    ->orWhere('PetName', 'like', '%'. $search .'%')
                    ->orWhere('AnimalType', 'like', '%'. $search .'%')
                    ->orWhere('CommonName', 'like', '%'. $search .'%')
                    ->orWhere('FamilyStrain', 'like', '%'. $search .'%')
                    ->orWhere('ColorMarking', 'like', '%'. $search .'%')
                    ->orWhere('SizeWidth', 'like', '%'. $search .'%')
                    ->orWhere('SizeLength', 'like', '%'. $search .'%')
                    ->orWhere('SizeHeight', 'like', '%'. $search .'%')
                    ->orWhere('Weight', 'like', '%'. $search .'%')
                    ->orWhere('Co_Owner', 'like', '%'. $search .'%');
            });
        }

		$data = array(
			'title' => 'Registration - Other | International Animal Genetics Database',
			'registration_other' => $registration_other->paginate(10),
            'adminDetails' => $adminDetails
		);

		return view('pages/admins/admin-registration-other',['data'=>$data]);
	}



	public function get_pet_reg_adtl(Request $request) {

        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong, Please try again!'
            ];
            return response()->json($data);
        }

        $getAdtlDetails = RegistrationPetDetailsModel::with('FilePhoto', 'FilePetSupportingDocuments', 'FileVetRecordDocuments', 'FileSireImage', 'FileSireSupportingDocuments', 'FileDamImage', 'FileDamSupportingDocuments')
            ->where('PetUUID', $request->input('pet_uuid'));


        /* Create json response */
        if ($getAdtlDetails->count() > 0) {
			$gad = $getAdtlDetails->first();

            $data = [
                'status' => 'success',
				'data' => $gad,
            ];
            return response()->json($data);
        } else {
			return response()->json(false);
		}
	}
}

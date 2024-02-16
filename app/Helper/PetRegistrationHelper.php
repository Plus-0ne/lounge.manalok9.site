<?php

namespace App\Helper;

use App\Models\Users\MembersBird;
use App\Models\Users\MembersCat;
use App\Models\Users\MembersDog;
use App\Models\Users\MembersOtherAnimal;
use App\Models\Users\MembersRabbit;
use App\Models\Users\StorageFile;
use Auth;
use Carbon;
use Illuminate\Support\Facades\File;
use Session;
use Str;
use Validator;

class PetRegistrationHelper
{

    /* -------------------------------------------------------------------------- */
    /*                            Dog input validations                           */
    /* -------------------------------------------------------------------------- */
    public static function dogValidations($request)
    {
        /* Validate request */
        $validate = Validator::make($request->all(), [
            'name' => 'required',

            /*'microchip' => 'required',*/
            /*'birth_date' => 'required',*/
            /*'age' => 'required',*/
            'gender' => 'required',
            'breed' => 'required',
            /*'eye_color' => 'required',*/
            /*'dog_color' => 'required',*/
            /*'dogs_marking' => 'required',*/
            /*'height' => 'required',*/
            /*'weight' => 'required',*/
            'address_location' => 'required',
            /*'co_owner' => 'required',*/
            'pet_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:30000', // TODO : Add heic,heif convertion and enable new file type in mimetypes

        ], [
            'name.required' => 'Please enter your dog\'s name.',
            // 'microchip.required' => 'Please enter your dog\'s microchip #.',
            // 'birth_date.required' => 'Please enter your dog\'s birth date.',
            // 'age.required' => 'Please enter your dog\'s age.',
            'gender.required' => 'Please enter your dog\'s gender.',
            'breed.required' => 'Please enter your dog\'s breed.',
            // 'eye_color.required' => 'Please enter your dog\'s eye color.',
            // 'dog_color.required' => 'Please enter your dog\'s color.',
            // 'dogs_marking.required' => 'Please enter your dog\'s markings.',
            // 'height.required' => 'Please enter your dog\'s height.',
            // 'weight.required' => 'Please enter your dog\'s weight.',
            'address_location.required' => 'Please enter your dog\'s address or location.',
            // 'co_owner.required' => 'Please enter your dog\'s co_owner.',
            'pet_image.image' => 'Please upload dog image.',
            'pet_image.mimes' => 'Dog image format not supported. Acceptable format : jpeg,jpg,png,gif,webp',
            'pet_image.max' => 'Dog image file size is too large! Max size is 30mb.',

        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];

            return $data;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                             Check dog if exist                             */
    /* -------------------------------------------------------------------------- */
    public static function checkDogInDB($request)
    {
        $dog_name = $request->input('name');
        $owner = Auth::guard('web')->user()->uuid;

        $dog = MembersDog::where([
            ['PetName', '=', $dog_name],
            ['OwnerUUID', '=', $owner]
        ]);

        if ($dog->count() > 0) {
            $data = [
                'status' => 'warning',
                'message' => 'Your dog is already registered.'
            ];

            return $data;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Upload dog image                              */
    /* -------------------------------------------------------------------------- */
    public static function uploadDogImage($request)
    {
        try {

            /* Get file */
            $file = $request->file('pet_image');

            /* Upload folder */
            $destinationPath = public_path('uploads/members');

            /* Upload path */
            $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

            /* Dog name */
            $dogname = str_replace(' ', '-', $request->input('name'));

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            /* Image name */
            $image_name = 'dog-image-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

            /* Move image to Upload path */
            $file->move($uploadPath, $image_name);

            /* Put image to session */
            Session::put('dog_image', [
                'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $image_name,
                'name' => $image_name
            ]);
        } catch (\Exception $ex) {
            $data = [
                'status' => 'error',
                'message' => 'Error encountered while uploading! Please try again later.',
                'error_message' => $ex
            ];

            return $data;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                  Supporting documnet validation and upload                 */
    /* -------------------------------------------------------------------------- */
    public static function uploadDogSupportingDoc($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate supporting documents */
            if (!in_array($request->file('supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dog\'s supporting documents file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'supp_doc' => 'max:30000',
            ], [
                'supp_doc.max' => 'Supporting document file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('supp_doc');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $suppdoc = 'dog-suppdoc-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $suppdoc);

                /* Put file to session */
                Session::put('suppdoc_file', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $suppdoc,
                    'name' => $suppdoc
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                     Clinic or Verterenary record upload                    */
    /* -------------------------------------------------------------------------- */
    public static function veterenaryRecordUpload($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('cveter_record')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('cveter_record')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dog\'s veterenary record file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'cveter_record' => 'max:30000',
            ], [
                'cveter_record.max' => 'Veterenary record file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('cveter_record');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $cveter_record = 'dog-cveter_record-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $cveter_record);

                /* Put file to session */
                Session::put('cveter_record', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $cveter_record,
                    'name' => $cveter_record
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Sire image upload                             */
    /* -------------------------------------------------------------------------- */
    public static function siresImageUpload($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('sire_image')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                // 'application/pdf',
                // 'application/msword',
                // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('sire_image')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid sire\'s image file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'sire_image' => 'max:30000',
            ], [
                'sire_image.max' => 'Sire\'s image file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('sire_image');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $sire_image = 'dog-sire_image-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $sire_image);

                /* Put file to session */
                Session::put('sire_image', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $sire_image,
                    'name' => $sire_image
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Dam image upload                              */
    /* -------------------------------------------------------------------------- */
    public static function damImageUpload($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('dam_image')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                // 'application/pdf',
                // 'application/msword',
                // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('dam_image')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dam\'s image file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'dam_image' => 'max:30000',
            ], [
                'dam_image.max' => 'Dam\'s image file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('dam_image');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $dam_image = 'dog-dam_image-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $dam_image);

                /* Put file to session */
                Session::put('dam_image', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $dam_image,
                    'name' => $dam_image
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                          Sire supporting document                          */
    /* -------------------------------------------------------------------------- */
    public static function sireSuppDocUpload($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('sire_supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('sire_supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid sire\'s document file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'sire_supp_doc' => 'max:30000',
            ], [
                'sire_supp_doc.max' => 'Sire\'s document file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('sire_supp_doc');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $sire_supp_doc = 'dog-sire_supp_doc-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $sire_supp_doc);

                /* Put file to session */
                Session::put('sire_supp_doc', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $sire_supp_doc,
                    'name' => $sire_supp_doc
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                       Dam supporting document upload                       */
    /* -------------------------------------------------------------------------- */
    public static function damSuppDocUpload($request)
    {
        /* Check if supported document is in request */
        if ($request->hasFile('dam_supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('dam_supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dam\'s document file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'dam_supp_doc' => 'max:30000',
            ], [
                'dam_supp_doc.max' => 'Dam\'s document file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('dam_supp_doc');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $dogname = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $dam_supp_doc = 'dog-dam_supp_doc-' . $dogname . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $dam_supp_doc);

                /* Put file to session */
                Session::put('dam_supp_doc', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $dam_supp_doc,
                    'name' => $dam_supp_doc
                ]);
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                        Delete image if error occured                       */
    /* -------------------------------------------------------------------------- */
    public static function imageRemoveIfError()
    {
        /*
            * Remove file uploaded before
        */
        if (Session::has('dog_image')) {

            File::delete(public_path(Session::get('dog_image.path')));
            Session::forget('dog_image');
        }
        if (Session::has('suppdoc_file')) {

            File::delete(public_path(Session::get('suppdoc_file.path')));
            Session::forget('suppdoc_file');
        }

        if (Session::has('cveter_record')) {
            File::delete(public_path(Session::get('cveter_record.path')));
            Session::forget('cveter_record');
        }

        if (Session::has('sire_image')) {

            File::delete(public_path(Session::get('sire_image.path')));
            Session::forget('sire_image');
        }
        if (Session::has('sire_supp_doc')) {

            File::delete(public_path(Session::get('sire_supp_doc.path')));
            Session::forget('sire_supp_doc');
        }

        if (Session::has('dam_image')) {

            File::delete(public_path(Session::get('dam_image.path')));
            Session::forget('dam_image');
        }
        if (Session::has('dam_supp_doc')) {

            File::delete(public_path(Session::get('dam_supp_doc.path')));
            Session::forget('dam_supp_doc');
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                       Clear session for image uploads                      */
    /* -------------------------------------------------------------------------- */
    public static function clearImageInSession()
    {
        if (Session::has('dog_image')) {
            Session::forget('dog_image');
        }

        if (Session::has('suppdoc_file')) {
            Session::forget('suppdoc_file');
        }

        if (Session::has('cveter_record')) {
            Session::forget('cveter_record');
        }

        if (Session::has('sire_image')) {
            Session::forget('sire_image');
        }
        if (Session::has('sire_supp_doc')) {
            Session::forget('sire_supp_doc');
        }

        if (Session::has('dam_image')) {
            Session::forget('dam_image');
        }
        if (Session::has('dam_supp_doc')) {
            Session::forget('dam_supp_doc');
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                  Store session image to StorageFile table                  */
    /* -------------------------------------------------------------------------- */
    public static function insertSessionImageToDB($photo)
    {

        if (Session::has('dog_image')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('dog_image.path'),
                'file_name' => Session::get('dog_image.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dog_image',
            ]);
        }
        if (Session::has('suppdoc_file')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('suppdoc_file.path'),
                'file_name' => Session::get('suppdoc_file.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dog_supporting_doc',
            ]);
        }

        if (Session::has('cveter_record')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('cveter_record.path'),
                'file_name' => Session::get('cveter_record.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'vet_record',
            ]);
        }

        if (Session::has('sire_image')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('sire_image.path'),
                'file_name' => Session::get('sire_image.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'sire_image',
            ]);
        }
        if (Session::has('sire_supp_doc')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('sire_supp_doc.path'),
                'file_name' => Session::get('sire_supp_doc.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'sire_supporting_doc',
            ]);
        }

        if (Session::has('dam_image')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('dam_image.path'),
                'file_name' => Session::get('dam_image.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dam_image',
            ]);
        }
        if (Session::has('dam_supp_doc')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('dam_supp_doc.path'),
                'file_name' => Session::get('dam_supp_doc.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dam_supporting_doc',
            ]);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                             Remove pet uploads                             */
    /* -------------------------------------------------------------------------- */
    public static function removePetUploads($data)
    {
        if (empty($data->AdtlInfo->petImageUploads)) {
            return false;
        }

        $petData = $data->AdtlInfo->petImageUploads;

        foreach ($petData as $row) {
            if (File::exists(public_path($row->file_path))) {
                File::delete(public_path($row->file_path));
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                      Validate pet registration request                     */
    /* -------------------------------------------------------------------------- */
    public static function validatePetRegistrationRequest($request)
    {
        /* Validate request */
        $validate = Validator::make($request->all(), [
            'name' => 'required',

            // 'microchip' => 'required',
            'birth_date' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'breed' => 'required',
            // 'eye_color' => 'required',
            // 'color' => 'required',
            // 'marking' => 'required',
            // 'height' => 'required',
            // 'weight' => 'required',
            'address_location' => 'required',
            // 'co_owner' => 'required',
            'pet_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:30000', // TODO : Add heic,heif convertion and enable new file type in mimetypes

        ], [
            'name.required' => 'Please enter your ' . $request->input('animalType') . '\'s name.',
            // 'microchip.required' => 'Please enter your ' . $request->input('animalType') . '\'s microchip #.',
            'birth_date.required' => 'Please enter your ' . $request->input('animalType') . '\'s birth date.',
            'age.required' => 'Please enter your ' . $request->input('animalType') . '\'s age.',
            'gender.required' => 'Please enter your ' . $request->input('animalType') . '\'s gender.',
            'breed.required' => 'Please enter your ' . $request->input('animalType') . '\'s breed.',
            // 'eye_color.required' => 'Please enter your ' . $request->input('animalType') . '\'s eye color.',
            // 'color.required' => 'Please enter your ' . $request->input('animalType') . '\'s color.',
            // 'marking.required' => 'Please enter your ' . $request->input('animalType') . '\'s markings.',
            // 'height.required' => 'Please enter your ' . $request->input('animalType') . '\'s height.',
            // 'weight.required' => 'Please enter your ' . $request->input('animalType') . '\'s weight.',
            'address_location.required' => 'Please enter your ' . $request->input('animalType') . '\'s address or location.',
            // 'co_owner.required' => 'Please enter your ' . $request->input('animalType') . '\'s co_owner.',
            'pet_image.image' => 'Please upload ' . $request->input('animalType') . ' image.',
            'pet_image.mimes' => Str::ucfirst($request->input('animalType')) . ' image format not supported. Acceptable format : jpeg,jpg,png,gif,webp',
            'pet_image.max' => Str::ucfirst($request->input('animalType')) . ' image file size is too large! Max size is 30mb.',

        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return $data;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                            Check pet in registry                           */
    /* -------------------------------------------------------------------------- */
    public static function checkPetInRegistry($request)
    {
        $petName = $request->input('name');
        $owner = Auth::guard('web')->user()->uuid;

        switch ($request->input('animalType')) {
            case 'rabbit':
                $petData = MembersRabbit::where([
                    ['PetName', '=', $petName],
                    ['OwnerUUID', '=', $owner]
                ]);
                break;

            case 'bird':
                $petData = MembersBird::where([
                    ['PetName', '=', $petName],
                    ['OwnerUUID', '=', $owner]
                ]);
                break;

            case 'other':
                $petData = MembersOtherAnimal::where([
                    ['PetName', '=', $petName],
                    ['OwnerUUID', '=', $owner]
                ]);
                break;

            default:
                $petData = MembersCat::where([
                    ['PetName', '=', $petName],
                    ['OwnerUUID', '=', $owner]
                ]);
                break;
        }

        return $petData;
    }

    /* -------------------------------------------------------------------------- */
    /*                              Upload pet image                              */
    /* -------------------------------------------------------------------------- */
    public static function uploadPetImage($request)
    {
        try {
            /*
                * Get animal type
            */
            $animalType = $request->input('animalType');
            /*
                * Get file
            */
            $file = $request->file('pet_image');

            /*
                * Upload folder path
            */
            $destinationPath = public_path('uploads/members');

            /*
                * Complete upload path
            */
            $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

            /*
                * Pet name filter
            */
            $petName = str_replace(' ', '-', $request->input('name'));

            /*
                * Check if directory exist
            */
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            /*
                * Create new filename for uploaded file
            */
            $imageName = $animalType . '-image-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

            /*
                * Upload file to directory
            */
            $file->move($uploadPath, $imageName);

            /*
                * Put image path to session
            */
            Session::put('petImage', [
                'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $imageName,
                'name' => $imageName
            ]);

            return true;
        } catch (\Exception $ex) {

            return false;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                       Upload pet supporting document                       */
    /* -------------------------------------------------------------------------- */
    public static function petSupportingDocumentUpload($request)
    {
        /*
            * Pet type
        */
        $animalType = $request->input('animalType');

        /*
            * Check if supported document is in request
        */
        if ($request->hasFile('supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /*
                * Validate supporting documents
            */
            if (!in_array($request->file('supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid ' . $animalType . '\'s supporting documents file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'supp_doc' => 'max:30000',
            ], [
                'supp_doc.max' => 'Supporting document file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /*
                * Upload the file
            */
            try {

                /*
                    * Get the file
                */
                $file = $request->file('supp_doc');

                /*
                    * Upload folder
                */
                $destinationPath = public_path('uploads/members');

                /*
                    * Upload path
                */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /*
                    * Pet name
                */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /*
                    * Pet name
                */
                $suppdoc = $animalType . '-suppdoc-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /*
                    * Move file to Upload path
                */
                $file->move($uploadPath, $suppdoc);

                /*
                    * Put file to session
                */
                Session::put('suppdoc_file', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $suppdoc,
                    'name' => $suppdoc
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Pet supporting document uploaded successfully.',
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                            Upload pet ver record                           */
    /* -------------------------------------------------------------------------- */
    public static function petVetRecordUpload($request)
    {
        /*
            * Pet type
        */
        $animalType = $request->input('animalType');

        /*
            * Check if supported document is in request
        */
        if ($request->hasFile('cveter_record')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /*
                * Validate veterenary record
            */
            if (!in_array($request->file('cveter_record')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid ' . $animalType . '\'s veterenary record file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'cveter_record' => 'max:30000',
            ], [
                'cveter_record.max' => 'Veterenary record file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('cveter_record');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $cveter_record = $animalType . '-cveter_record-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $cveter_record);

                /* Put file to session */
                Session::put('cveter_record', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $cveter_record,
                    'name' => $cveter_record
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Pet vet record uploaded successfully.',
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Upload sire image                             */
    /* -------------------------------------------------------------------------- */
    public static function uploadSireImage($request)
    {
        /*
            * Pet type
        */
        $animalType = $request->input('animalType');

        /*
            * Check if supported document is in request
        */
        if ($request->hasFile('sire_image')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
            ];
            /*
                * Validate veterenary record
            */
            if (!in_array($request->file('sire_image')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid sire\'s image file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'sire_image' => 'max:30000',
            ], [
                'sire_image.max' => 'Sire\'s image file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('sire_image');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $sire_image = $animalType . '-sire_image-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $sire_image);

                /* Put file to session */
                Session::put('sire_image', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $sire_image,
                    'name' => $sire_image
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Sire image uploaded successfully.',
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                      Upload sire supporting documents                      */
    /* -------------------------------------------------------------------------- */
    public static function uploadSireSupportingDocuments($request)
    {
        /*
            * Animal type
        */
        $animalType = $request->input('animalType');

        /*
            * Check if supported document is in request
        */
        if ($request->hasFile('sire_supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /*
                * Validate sire supporting document
            */
            if (!in_array($request->file('sire_supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid sire\'s document file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'sire_supp_doc' => 'max:30000',
            ], [
                'sire_supp_doc.max' => 'Sire\'s document file size is too large! Max size is 30mb.',
            ]);

            /*
                * Throw validation errors
            */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /*
                * Upload the file
            */
            try {

                /*
                    * Get file
                */
                $file = $request->file('sire_supp_doc');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Dog name */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $sire_supp_doc = $animalType.'-sire_supp_doc-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $sire_supp_doc);

                /* Put file to session */
                Session::put('sire_supp_doc', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $sire_supp_doc,
                    'name' => $sire_supp_doc
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Sire supporting document uploaded successfully.',
                ];

                return $data;

            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Upload dam image                              */
    /* -------------------------------------------------------------------------- */
    public static function uploadDamImage($request)
    {
        /*
            * Animal type
        */
        $animalType = $request->input('animalType');

        /* Check if supported document is in request */
        if ($request->hasFile('dam_image')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                // 'application/pdf',
                // 'application/msword',
                // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('dam_image')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dam\'s image file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'dam_image' => 'max:30000',
            ], [
                'dam_image.max' => 'Dam\'s image file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('dam_image');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Pet name */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $dam_image = $animalType.'-dam_image-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $dam_image);

                /* Put file to session */
                Session::put('dam_image', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $dam_image,
                    'name' => $dam_image
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Dam image uploaded successfully.',
                ];

                return $data;
            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                       Upload dam supporting document                       */
    /* -------------------------------------------------------------------------- */
    public static function uploadDamSupportingDocument($request)
    {
        /*
            * Animal type
        */
        $animalType = $request->input('animalType');

        /* Check if supported document is in request */
        if ($request->hasFile('dam_supp_doc')) {
            $supportedDoc = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            /* Validate veterenary record */
            if (!in_array($request->file('dam_supp_doc')->getClientMimeType(), $supportedDoc)) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Invalid dam\'s document file format.'
                ];

                return $data;
            }

            $validate = Validator::make([
                'dam_supp_doc' => 'max:30000',
            ], [
                'dam_supp_doc.max' => 'Dam\'s document file size is too large! Max size is 30mb.',
            ]);

            /* Throw validation errors */
            if ($validate->fails()) {
                $data = [
                    'status' => 'warning',
                    'message' => $validate->errors()->first()
                ];

                return $data;
            }

            /* Upload the file */
            try {

                /* Get file */
                $file = $request->file('dam_supp_doc');

                /* Upload folder */
                $destinationPath = public_path('uploads/members');

                /* Upload path */
                $uploadPath = $destinationPath . '/' . Auth::guard('web')->user()->uuid;

                /* Pet name */
                $petName = str_replace(' ', '-', $request->input('name'));

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                /* File name */
                $dam_supp_doc = $animalType.'-dam_supp_doc-' . $petName . '-' . Auth::guard('web')->user()->uuid . '-' . time() . '-' . $file->getClientOriginalName();

                /* Move file to Upload path */
                $file->move($uploadPath, $dam_supp_doc);

                /* Put file to session */
                Session::put('dam_supp_doc', [
                    'path' => 'uploads/members/' . Auth::guard('web')->user()->uuid . '/' . $dam_supp_doc,
                    'name' => $dam_supp_doc
                ]);

                $data = [
                    'status' => 'success',
                    'message' => 'Dam supporting document uploaded successfully.',
                ];

                return $data;

            } catch (\Exception $ex) {
                $data = [
                    'status' => 'error',
                    'message' => 'Error encountered while uploading! Please try again later.',
                    'error_message' => $ex
                ];

                return $data;
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Register new pet                              */
    /* -------------------------------------------------------------------------- */
    public static function registerNewPet($request)
    {
        switch ($request->input('animalType')) {
            case 'rabbit':
                do {
                    $PetUUID = Str::uuid();
                } while (MembersRabbit::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersRabbit);
                break;

            case 'bird':
                do {
                    $PetUUID = Str::uuid();
                } while (MembersDog::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersDog);
                break;

            case 'other':
                do {
                    $PetUUID = Str::uuid();
                } while (MembersOtherAnimal::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersOtherAnimal);
                break;

            default:
                do {
                    $PetUUID = Str::uuid();
                } while (MembersCat::where('PetUUID', '=', $PetUUID)->first()  instanceof MembersCat);
                break;
        }

        $data = [
            'PetUUID' => $PetUUID,
            'OwnerUUID' => Auth::guard('web')->user()->uuid,
            'OwnerIAGDNo' => (Auth::guard('web')->user()->iagd_number ? Auth::guard('web')->user()->iagd_number : null),
            'PetName' => $request->input('name'),
            'BirthDate' => $request->input('birth_date'),
            'Gender' => ($request->input('gender') == 'male' ? 'male' : 'female'),
            'Location' => $request->input('address_location'),
            'Breed' => $request->input('breed'),
            'Markings' => $request->input('marking'),
            'PetColor' => $request->input('color'),
            'EyeColor' => $request->input('eye_color'),
            'Height' => $request->input('height'),
            'Weight' => $request->input('weight'),
            'Co_Owner' => (!empty($request->input('co_owner')) ? $request->input('co_owner') : 'N/A'),
            'DateAdded' => Carbon::now(),
            'non_member' => 1,
        ];

        switch ($request->input('animalType')) {
            case 'rabbit':
                $newPet = MembersRabbit::create($data);
                break;

            case 'bird':
                $newPet = MembersBird::create($data);
                break;

            case 'other':
                $newPet = MembersOtherAnimal::create($data);
                break;

            default:
                $newPet = MembersCat::create($data);
                break;
        }

        if ($newPet->save()) {
            return $newPet;
        } else {
            return false;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                 Inser new all images from session to table                 */
    /* -------------------------------------------------------------------------- */
    public static function insertPetUploadInSessions($photo,$animalType) {

        if (Session::has('petImage')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('petImage.path'),
                'file_name' => Session::get('petImage.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'pet_image',
            ]);
        }
        if (Session::has('suppdoc_file')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('suppdoc_file.path'),
                'file_name' => Session::get('suppdoc_file.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'pet_supporting_doc',
            ]);
        }

        if (Session::has('cveter_record')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('cveter_record.path'),
                'file_name' => Session::get('cveter_record.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'vet_record',
            ]);
        }

        if (Session::has('sire_image')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('sire_image.path'),
                'file_name' => Session::get('sire_image.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'sire_image',
            ]);
        }
        if (Session::has('sire_supp_doc')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('sire_supp_doc.path'),
                'file_name' => Session::get('sire_supp_doc.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'sire_supporting_doc',
            ]);
        }

        if (Session::has('dam_image')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('dam_image.path'),
                'file_name' => Session::get('dam_image.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dam_image',
            ]);
        }
        if (Session::has('dam_supp_doc')) {
            $timestamp = Carbon::now();

            StorageFile::insert([
                'uuid' => $photo,
                'file_path' => Session::get('dam_supp_doc.path'),
                'file_name' => Session::get('dam_supp_doc.name'),
                'token' => Str::uuid(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'image_type' => 'dam_supporting_doc',
            ]);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                        Remove pet images in session                        */
    /* -------------------------------------------------------------------------- */
    public static function clearSessionPetImages()
    {
        if (Session::has('petImage')) {
            Session::forget('petImage');
        }

        if (Session::has('suppdoc_file')) {
            Session::forget('suppdoc_file');
        }

        if (Session::has('cveter_record')) {
            Session::forget('cveter_record');
        }

        if (Session::has('sire_image')) {
            Session::forget('sire_image');
        }
        if (Session::has('sire_supp_doc')) {
            Session::forget('sire_supp_doc');
        }

        if (Session::has('dam_image')) {
            Session::forget('dam_image');
        }
        if (Session::has('dam_supp_doc')) {
            Session::forget('dam_supp_doc');
        }
    }
    /* -------------------------------------------------------------------------- */
    /*                    Remove pet uploads using session path                   */
    /* -------------------------------------------------------------------------- */
    public static function removePetUploadOnError()
    {
        /*
            * Remove file uploaded before
        */
        if (Session::has('petImage')) {

            File::delete(public_path(Session::get('petImage.path')));
            Session::forget('petImage');
        }
        if (Session::has('suppdoc_file')) {

            File::delete(public_path(Session::get('suppdoc_file.path')));
            Session::forget('suppdoc_file');
        }

        if (Session::has('cveter_record')) {
            File::delete(public_path(Session::get('cveter_record.path')));
            Session::forget('cveter_record');
        }

        if (Session::has('sire_image')) {

            File::delete(public_path(Session::get('sire_image.path')));
            Session::forget('sire_image');
        }
        if (Session::has('sire_supp_doc')) {

            File::delete(public_path(Session::get('sire_supp_doc.path')));
            Session::forget('sire_supp_doc');
        }

        if (Session::has('dam_image')) {

            File::delete(public_path(Session::get('dam_image.path')));
            Session::forget('dam_image');
        }
        if (Session::has('dam_supp_doc')) {

            File::delete(public_path(Session::get('dam_supp_doc.path')));
            Session::forget('dam_supp_doc');
        }
    }
}

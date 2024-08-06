<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Dealers;
use App\Models\Users\DealersAttachments;
use Auth;
use DB;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use Storage;
use Str;
use URL;
use Validator;

class DealersController extends Controller
{
    /**
     * Page view for dealers form
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        // Get all notifications
        $notif = Notif_Helper::GetUserNotification();

        // Declare javascript variables
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        // Create data array for view
        $data = array(
            'title' => 'Be our dealers | IAGD Members Lounge',
            'notif' => $notif,
            'analytics' => CustomHelper::analytics()
        );

        // Return view
        return view('pages.users.user_be_a_dealer', ["data" => $data]);
    }


    /**
     * Create new dealers details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        // Check if ajax request
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }

        // Validate request
        $validate = $this->validateDealersRequest($request);

        // If validation fails return JSON response message
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        // Upload file to temp folder
        $imageFileUpload = $this->uploadImageFile($request);

        // If upload not successfull return JSON response message
        if (!$imageFileUpload['status'] == 'success') {

            return response()->json($imageFileUpload);
        }

        // Start database transaction
        DB::beginTransaction();

        // Create uuid
        do {
            $uuid = Str::uuid();
        } while (Dealers::where("uuid", $uuid)->first() instanceof Dealers);

        // Create data array for dealers
        $data = [
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'email_address' => $request->input('email_address'),
            'contact_number' => $request->input('contact_number'),
            'tel_number' => $request->input('telephone_number'),
            'store_location' => $request->input('store_address'),
        ];
        // Create new dealers
        $create = Dealers::create($data);

        // Check if dealers is saved
        if (!$create->save()) {

            // Remove file in temp folder
            Storage::disk('public')->delete($imageFileUpload['file_path']);

            // Rollback database transaction
            DB::rollBack();

            $data = [
                'status' => 'error',
                'message' => 'Failed to create dealer! Please try again later.'
            ];
            return response()->json($data);
        }

        // Create uuid
        do {
            $d_uuid = Str::uuid();
        } while (DealersAttachments::where("uuid", $d_uuid)->first() instanceof DealersAttachments);

        // Create data array for dealers attachments
        $data = [
            'uuid' => $d_uuid,
            'dealers_uuid' => $uuid,
            'filename' => $imageFileUpload['file_name'],
            'type' => $imageFileUpload['file_type'],
            'path' => $imageFileUpload['file_path'],
        ];

        // Create new dealers
        $create = DealersAttachments::create($data);

        // Check if dealers is saved
        if (!$create->save()) {

            // Remove file in temp folder
            Storage::disk('public')->delete($imageFileUpload['file_path']);

            // Rollback database transaction
            DB::rollBack();

            $data = [
                'status' => 'error',
                'message' => 'Failed to create dealer! Please try again later.'
            ];
            return response()->json($data);
        }

        // If success
        DB::commit();

        $data = [
            'status' => 'success',
            'message' => 'Successfully applied as dealer! Please wait as we verify your application.'
        ];
        return response()->json($data);

    }

    /**
     * Validate dealers request
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    public function validateDealersRequest($request) {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'email_address' => 'nullable',
            'contact_number' => 'required',
            'telephone_number' => 'nullable',
            'store_address' => 'required',
            'image_file' => 'image|mimes:jpg,jpeg,png|max:3580',
        ];

        $message = [
            'first_name.required' => 'Please enter your first name!',
            'last_name.required' => 'Please enter your last name!',
            'contact_number.required' => 'Please enter your contact number!',
            'store_address.required' => 'Please enter your store address',
            'image_file.image' => 'Please select an image file!',
            'image_file.mimes' => 'Please select a valid image file!',
            'image_file.max' => 'File too large! Max image size is 3580MB.',
        ];
        $validate = Validator::make($request->all(),$rules,$message);

        return $validate;
    }

    /**
     * Upload image file to temp folder
     * @param Request $request
     * @return string
     */
    public function uploadImageFile($request) {

        try {

            $file = $request->file('image_file');
            $type = $file->getClientOriginalExtension();
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file_path = $file->storeAs('dealers/image/'.Auth::guard('web')->user()->uuid, $filename, 'public');

            $data = [
                'status' => 'success',
                'file_path' => $file_path,
                'file_name' => $filename,
                'file_type' => $type,
            ];

            return $data;

        } catch (\Throwable $th) {

            $data = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];

            return $data;

        }
    }
}

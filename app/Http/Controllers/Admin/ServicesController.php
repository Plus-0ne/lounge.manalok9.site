<?php

namespace App\Http\Controllers\Admin;

use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Admin\ServicesModel;
use App\Models\Users\ServiceEnrolled;
use App\Models\Users\ServiceEnrollments;
use App\Models\Users\ServiceOrders;
use Auth;
use Carbon;
use File;
use Illuminate\Http\Request;
use JavaScript;
use Str;
use URL;
use Validator;

class ServicesController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                Services page                               */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $getAllServices = ServicesModel::all();

        $data = array(
            'title' => 'Services | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'services' => $getAllServices
        );

        return view('pages/admins/admin-services', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Add new services                              */
    /* -------------------------------------------------------------------------- */
    public function createNewService(Request $request)
    {
        /*
            * Set validation rules
        */
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png',
        ], [
            'name.required' => 'Name is required!',
            'description.required' => 'Description is required!',
            'price.required' => 'Price is required!',
            'price.numeric' => 'Price is not a number!',
            'image.required' => 'Image is required!',
            'image.image' => 'Upload a valid image file!',
            'image.mimes' => 'Upload a valid image format!',
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        /*
            * Upload image
        */
        try {

            /*
                * Get the file
            */
            $file = $request->file('image');

            /*
                * Upload root folder
            */
            $destinationPath = public_path('uploads/services');

            /*
                * Create root folder if folder doesn't exist
            */
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            /*
                * Services file name
            */
            $cleanedFileName = Str::replace(' ', '-', $file->getClientOriginalName());
            $productFileName = time() . '-' .$cleanedFileName;


            /*
                * Move file to Upload folder
            */
            $file->move($destinationPath, $productFileName);

            $imagePath = '/uploads/services/'.$productFileName;

        } catch (\Exception $ex) {
            $data = [
                'status' => 'error',
                'message' => $ex
            ];

            return redirect()->back()->with($data);
        }

        /*
            * Create uuid
        */
        do {
            $uuid = Str::uuid();
        } while (ServicesModel::where('uuid', $uuid)->first() instanceof ServicesModel);

        /*
            * Insert new product
        */
        $insertNewServices = ServicesModel::create([
            'uuid' => $uuid,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'status' => 1, // 1 = available ; 0 = unavailable
            'added_by' => Auth::guard('web_admin')->user()->uuid,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($insertNewServices->save()) {
            $data = [
                'status' => 'success',
                'message' => 'New service has been added!'
            ];

            return redirect()->back()->with($data);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Failed to save sevice!'
            ];

            return redirect()->back()->with($data);
        }
    }

    /**
     * View service enrollments
     *
     * @return void
     */
    public function serviceEnrollments()
    {
        /*
            * Javscript variables
        */
        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        $serviceEnrollments = ServiceEnrollments::all();

        $data = array(
            'title' => 'Services enrollments | International Animal Genetics Database',
            'serviceEnrollments' => $serviceEnrollments
        );

        return view('pages/admins/admin-services-enrollments', ['data' => $data]);
    }

}

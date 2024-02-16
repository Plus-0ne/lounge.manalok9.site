<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AjaxRequestHelper;
use App\Helper\GetAdminAccount;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductsModel;
use App\Models\Users\ProductOrders;
use Auth;
use Carbon;
use File;
use Illuminate\Http\Request;
use JavaScript;
use Str;
use URL;
use Validator;

class ProductController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                Product page                                */
    /* -------------------------------------------------------------------------- */
    public function index()
    {
        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        /*
            * Get all products
        */
        $products = ProductsModel::orderBy('id', 'DESC')->get();
        $data = array(
            'title' => 'Products | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'products' => $products
        );

        return view('pages/admins/admin-products', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                               Add new product                              */
    /* -------------------------------------------------------------------------- */
    public function createNewProduct(Request $request)
    {
        /*
            * Set validation rules
        */
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png',
        ], [
            'name.required' => 'Name is required!',
            'description.required' => 'Description is required!',
            'price.required' => 'Price is required!',
            'price.numeric' => 'Price is not a number!',
            'stock.required' => 'Stock is required!',
            'stock.numeric' => 'Stock is not a number!',
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
            $destinationPath = public_path('uploads/products');

            /*
                * Create root folder if folder doesn't exist
            */
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            /*
                * Product file name
            */
            $cleanedFileName = Str::replace(' ', '-', $file->getClientOriginalName());
            $productFileName = time() . '-' .$cleanedFileName;


            /*
                * Move file to Upload folder
            */
            $file->move($destinationPath, $productFileName);

            $imagePath = '/uploads/products/'.$productFileName;

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
        } while (ProductsModel::where('uuid', $uuid)->first() instanceof ProductsModel);

        /*
            * Insert new product
        */
        $insertNewProduct = ProductsModel::create([
            'uuid' => $uuid,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image' => $imagePath,
            'status' => 1, // 1 = available ; 0 = unavailable
            'added_by' => Auth::guard('web_admin')->user()->uuid,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($insertNewProduct->save()) {
            $data = [
                'status' => 'success',
                'message' => 'New product has been added!'
            ];

            return redirect()->back()->with($data);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Failed to save product!'
            ];

            return redirect()->back()->with($data);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                             Product orders page                            */
    /* -------------------------------------------------------------------------- */
    public function productOrders()
    {
        /* Get user details */
        $adminDetails = GetAdminAccount::get();

        JavaScript::put([
            'assetUrl' => asset(''),
            'currentBaseUrl' => URL::to('/')
        ]);

        /*
            * Get all products order
        */
        $productOrders = ProductOrders::where('status','!=',1)->orderBy('status', 'ASC')->get();
        $data = array(
            'title' => 'Product orders | International Animal Genetics Database',
            'adminDetails' => $adminDetails,
            'productOrders' => $productOrders
        );

        return view('pages/admins/admin-products-orders', ['data' => $data]);
    }

    /**
     * Accept pending orders
     *
     * @param  mixed $request
     * @return JSON
     */
    public function acceptOrders(Request $request) {
        /*
            * Check ajax request
        */
        $ajaxRequest = AjaxRequestHelper::checkAjaxRequest($request);
        if ($ajaxRequest) {
            return response()->json($ajaxRequest);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(),[
            'uuid' => 'required'
        ],[
            'uuid.required' => 'Order uuid not found!'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }
        /*
            * Find order row
        */
        $ordered = ProductOrders::where('uuid',$request->input('uuid'));

        /*
            * Order not found
        */
        if ($ordered->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Order not found!'
            ];
            return response()->json($data);
        }
        /*
            * If order is in cart
        */
        if ($ordered->first()->status < 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Order is in the cart!'
            ];
            return response()->json($data);
        }
        /*
            * If order status not 2
        */
        if ($ordered->first()->status != 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Invalid action! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Update status to accepted
        */
        $accpetOrder = ProductOrders::find($ordered->first()->id);
        $accpetOrder->status = 3;
        $accpetOrder->updated_at = Carbon::now();

        if ($accpetOrder->save()) {
            $data = [
                'status' => 'success',
                'message' => 'Order has been accepted!'
            ];
            return response()->json($data);
        }

    }

    /**
     * Cancel order
     *
     * @param  mixed $request
     * @return JSON
     */
    public function cancelOrders(Request $request) {
        /*
            * Check ajax request
        */
        $ajaxRequest = AjaxRequestHelper::checkAjaxRequest($request);
        if ($ajaxRequest) {
            return response()->json($ajaxRequest);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(),[
            'uuid' => 'required'
        ],[
            'uuid.required' => 'Order uuid not found!'
        ]);

        /*
            * Throw validation errors
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }
        /*
            * Find order row
        */
        $ordered = ProductOrders::where('uuid',$request->input('uuid'));

        /*
            * Order not found
        */
        if ($ordered->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Order not found!'
            ];
            return response()->json($data);
        }
        /*
            * If order is in cart
        */
        if ($ordered->first()->status < 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Order is in the cart!'
            ];
            return response()->json($data);
        }
        /*
            * If order status not 2
        */
        if ($ordered->first()->status != 2) {
            $data = [
                'status' => 'warning',
                'message' => 'Invalid action! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Update status to cancel
        */
        $accpetOrder = ProductOrders::find($ordered->first()->id);
        $accpetOrder->status = 7;
        $accpetOrder->updated_at = Carbon::now();

        if ($accpetOrder->save()) {
            $data = [
                'status' => 'success',
                'message' => 'Order has been cancelled!'
            ];
            return response()->json($data);
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Helper\ServiceEnrollmentHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductsModel;
use App\Models\Admin\ServicesModel;
use App\Models\Users\InventoryProducts;
use App\Models\Users\ProductOrders;
use App\Models\Users\ServiceEnrolled;
use App\Models\Users\ServiceEnrollments;
use App\Models\Users\ServiceOrders;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use JavaScript;
use Notif_Helper;
use Session;
use Str;
use URL;
use Validator;

class ProductsAndServicesController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                Product page                                */
    /* -------------------------------------------------------------------------- */
    public function index()
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
        /*
            * Get all product names
        */
        $productModel = ProductsModel::orderBy('name', 'ASC');
        $productsName = $productModel->pluck('name');
        $products = $productModel->get();

        $data = array(
            'title' => 'Products | IAGD Members Lounge',
            'notif' => $notif,
            'productsName' => $productsName,
            'products' => $products
        );
        return view('pages/users/product-services/user-products', ["data" => $data]);
    }

    /**
     * Show product cart page
     *
     * @return View
     */
    public function viewCartPage() {
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
        /*
            * Get cart
        */
        $cart = ProductOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ])->with('productDetails')->get();

        $data = array(
            'title' => 'Your cart | IAGD Members Lounge',
            'notif' => $notif,
            'productCart' => $cart
        );
        return view('pages/users/product-services/user-products-cart', ["data" => $data]);
    }
    /* -------------------------------------------------------------------------- */
    /*                                 Get my cart                                */
    /* -------------------------------------------------------------------------- */
    public function getMyCart(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request!'
            ];
            return response()->json($data);
        }

        $myCart = ProductOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ])
            ->with('productDetails')
            ->get();

        $data = [
            'status' => 'success',
            'myCart' => $myCart
        ];
        return response()->json($data);
    }
    /* -------------------------------------------------------------------------- */
    /*                              Add to cart item                              */
    /* -------------------------------------------------------------------------- */
    public function addToCartItem(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request!'
            ];
            return response()->json($data);
        }

        /*
            * Validate post request
        */
        $validate = Validator::make($request->all(), [
            'uuid' => 'required',
            'quantity' => 'required|numeric',
        ], [
            'uuid.required' => 'Product id not found!',
            'quantity.required' => 'Quantity is required!',
            'quantity.numeric' => 'Quantity is not a number!',
        ]);

        /*
            * Throw validation error
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /*
            * Find the product
        */
        $item = ProductsModel::where('uuid', $request->input('uuid'));

        /*
            * If item not found
        */
        if ($item->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Product not found!'
            ];
            return response()->json($data);
        }

        /*
            * Check if item is in the cart
        */
        $itemInCart = ProductOrders::where([
            ['product_uuid', '=', $request->input('uuid')],
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);

        if ($itemInCart->count() < 1) {
            /*
                * Insert to cart
            */
            do {
                $uuid = Str::uuid();
            } while (ProductOrders::where("uuid", $uuid)->first() instanceof ProductOrders);
            $newItem = [
                'uuid' => $uuid,
                'user_uuid' => Auth::guard('web')->user()->uuid,
                'product_uuid' => $request->input('uuid'),
                'quantity' => $request->input('quantity'),
                'price' => ($request->input('quantity') * $item->first()->price),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $cartItem = ProductOrders::create($newItem);

            if ($cartItem->save()) {
                $data = [
                    'status' => 'success',
                    'message' => 'New product added to cart!'
                ];
                return response()->json($data);
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to add product to cart!'
                ];
                return response()->json($data);
            }
        }

        /*
            * Update item in cart
        */
        $updateCart = ProductOrders::find($itemInCart->first()->id);

        if ($item->first()->stock < ($itemInCart->first()->quantity + $request->input('quantity'))) {
            $data = [
                'status' => 'warning',
                'message' => 'Stock is not enough!'
            ];
            return response()->json($data);
        }

        $updateCart->quantity = ($itemInCart->first()->quantity + $request->input('quantity'));
        $updateCart->price = ($itemInCart->first()->price + ($request->input('quantity') * $item->first()->price));
        $updateCart->updated_at = Carbon::now();

        if ($updateCart->save()) {
            $data = [
                'status' => 'success',
                'message' => 'Product updated in your cart!'
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Failed to update product in cart!'
            ];
            return response()->json($data);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Remove cart item                              */
    /* -------------------------------------------------------------------------- */
    public function removeItemFromCart(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request!'
            ];
            return response()->json($data);
        }

        /*
            * Validate post request
        */
        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'ID not found!',
        ]);

        /*
            * Throw validation error
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /*
            * Find item in cart
        */

        $item = ProductOrders::find($request->input('id'));

        if ($item->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Item not found!'
            ];
            return response()->json($data);
        }

        if (!$item->delete()) {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to delete product in cart!'
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Product deleted in cart!'
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                             Cart item checkout                             */
    /* -------------------------------------------------------------------------- */
    public function cartItemCheckout(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request!'
            ];
            return response()->json($data);
        }

        /*
            * Validate post request
        */
        $validate = Validator::make($request->all(), [
            'uuidArray' => 'required',
        ], [
            'uuidArray.required' => 'ID not found!',
        ]);

        /*
            * Throw validation error
        */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $jsonUuidArray = $request->input('uuidArray');
        $uuidArray = json_decode($jsonUuidArray);

        foreach ($uuidArray as $uuid) {
            $itemInCartCheckout = ProductOrders::where('uuid', $uuid);

            if ($itemInCartCheckout->count() > 0) {
                $updateCartItemStatus = ProductOrders::find($itemInCartCheckout->first()->id);

                $updateCartItemStatus->status = 2; // user has ordered

                $updateCartItemStatus->save();
            }
        }

        $data = [
            'status' => 'success',
            'message' => 'Order has been Saved, A customer Service will contact you to confirm your Order!'
        ];
        return response()->json($data);
    }


    /* -------------------------------------------------------------------------- */
    /*                            Dog training services                           */
    /* -------------------------------------------------------------------------- */
    public function dogTrainingServices()
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
        /*
            * Get all product names
        */
        $servicesModel = ServicesModel::orderBy('name', 'ASC');
        $serviceNames = $servicesModel->pluck('name');

        $services = $servicesModel->get();

        $data = array(
            'title' => 'Services | IAGD Members Lounge',
            'notif' => $notif,
            'serviceNames' => $serviceNames,
            'services' => $services
        );
        return view('pages/users/product-services/user-services', ["data" => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                             Add to cart service                            */
    /* -------------------------------------------------------------------------- */
    public function addToCartService(Request $request)
    {
        /*
            * Check if ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(), [
            'service_uuid' => 'required'
        ], [
            'service_uuid.required' => 'Something\'s wrong! Please try again later.'
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
            * Check if the service exist or available
        */
        $services = ServicesModel::where('uuid', $request->input('service_uuid'));
        /*
            * Throw warning if service is not found
        */
        if ($services->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Service not found! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Throw warning if the service is not available
        */
        if ($services->first()->status < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Service is not available at the moment!'
            ];
            return response()->json($data);
        }
        /*
            * Check if the service is already in the cart and the status = 1 or in cart
        */
        $serviceInCart = ServiceOrders::where([
            ['service_uuid', '=', $services->first()->uuid],
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);
        /*
            * Throw warning if service is in cart
        */
        if ($serviceInCart->count() > 0) {
            $data = [
                'status' => 'warning',
                'message' => 'This service is already in your cart!'
            ];
            return response()->json($data);
        }
        /*
            * Insert in service cart
        */
        do {
            $uuid = Str::uuid();
        } while (ServiceOrders::where('uuid', '=', $uuid)->first()  instanceof ServiceOrders);

        $insertToServiceCart = ServiceOrders::create([
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,
            'service_uuid' => $request->input('service_uuid'),
            'status' => 1,
            'price' => $services->first()->price,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        /*
            * Check if service is inserted to cart
        */

        if (!$insertToServiceCart->save()) {
            $data = [
                'status' => 'warning',
                'message' => 'Service is not added in your cart! Please try again later.'
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Service is added to your cart!'
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Get service cart                              */
    /* -------------------------------------------------------------------------- */
    public function getServicesCart(Request $request)
    {
        /*
            * Check if request is ajax
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Get service cart
        */
        $cart = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);

        $cartDetails = $cart->with('serviceOrderedOwner')->with('serviceDetails')->get();

        $data = [
            'status' => 'success',
            'message' => 'Service in cart fetched!',
            'totalInCart' => $cart->count(),
            'cart' => $cartDetails
        ];

        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                           Delete service in cart                           */
    /* -------------------------------------------------------------------------- */
    public function serviceCartDelete(Request $request)
    {
        /*
            * Check if request is ajax
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ], [
            'id.required' => 'Something\'s wrong! Please try again later.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        $deleteCartItem = ServiceOrders::find($request->input('id'));

        if ($deleteCartItem->delete()) {
            $data = [
                'status' => 'success',
                'message' => 'Service in cart deleted!'
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Failed to delete service in cart!'
            ];
            return response()->json($data);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Checkout services                             */
    /* -------------------------------------------------------------------------- */
    public function serviceCheckout()
    {
        /*
            * Check all services
        */
        $servicesOrdered = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);

        if ($servicesOrdered->count() < 1) {
            $data = [
                'status' => 'error',
                'message' => 'Nothing to checkout! Please add service to cart.'
            ];
            return redirect()->back()->with($data);
        } else {
            return redirect()->route('user.servicesEnrollmentForm.form');
        }
    }
    /* -------------------------------------------------------------------------- */
    /*                          Services enrollment form                          */
    /* -------------------------------------------------------------------------- */
    public function servicesEnrollmentForm()
    {
        /*
            * get all notification
        */
        $notif = Notif_Helper::GetUserNotification();

        /*
            * Check all services
        */
        $servicesOrdered = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);

        if ($servicesOrdered->count() < 1) {
            return redirect()->route('user.services.list');
        }

        /*
           * Javascript variables
        */
        JavaScript::put([
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'currentBaseUrl' => URL::to('/')
        ]);

        $data = array(
            'title' => 'Enrollment | IAGD Members Lounge',
            'notif' => $notif,
        );
        return view('pages/users/product-services/user-services-enrollment-form', ["data" => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                               Service enroll                               */
    /* -------------------------------------------------------------------------- */
    public function enrollThisPet(Request $request)
    {
        /*
            * Check ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Check if services in cart status is none
        */
        $servicesInCart = ServiceEnrollmentHelper::countServicesInCart();
        if ($servicesInCart < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'Please apply services to proceed to enrollment!'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(), [
            'petName' => 'required',
            'petOwner' => 'required',
            'currentAddress' => 'required',
            'mobileNumber' => 'required',
            'textAreaDogToClass' => 'required',
            'textAreaWhatToAccomplish' => 'required',
            'textAreaWhereAboutUs' => 'required',
        ], [
            'petName.required' => 'Please enter your pet\'s name!',
            'petOwner.required' => 'Please enter pet owner\'s name!',
            'currentAddress.required' => 'Please enter your current address!',
            'mobileNumber.required' => 'Please enter your current mobile number!',
            'textAreaDogToClass.required' => 'Briefly State What Brought Your Dog To Class.',
            'textAreaWhatToAccomplish.required' => 'Briefly State What You Hope To Accomplish In This Class.',
            'textAreaWhereAboutUs.required' => 'How Did You Hear About Us?',
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
            * Validate bite incedent
        */
        if ($request->has('biteIncendent') and $request->input('biteIncendent') == 1) {
            if ($request->input('forHuman') == 0 and $request->input('forOthers') == 0 || $request->input('forHuman') == 1 and $request->input('forOthers') == 1) {
                $data = [
                    'status' => 'warning',
                    'message' => 'Please select bite incedent!'
                ];

                return response()->json($data);
            }
        }

        /*
            * Validate upload if has laboratory result
        */
        $uploadLaboratoryResult = ServiceEnrollmentHelper::uploadLaboratoryResult($request);
        if ($uploadLaboratoryResult) {
            if ($uploadLaboratoryResult['status'] != 'success') {
                $data = [
                    'status' => $uploadLaboratoryResult['status'],
                    'message' => $uploadLaboratoryResult['message']
                ];

                return response()->json($data);
            }
        }

        /*
            * Begin database transaction
        */
        DB::beginTransaction();

        /*
            * Create uuid
        */
        do {
            $uuid = Str::uuid();
        } while (ServiceEnrollments::where('uuid', '=', $uuid)->first()  instanceof ServiceEnrollments);


        $enrollPet = ServiceEnrollments::create([
            'uuid' => $uuid,
            'user_uuid' => Auth::guard('web')->user()->uuid,
            'petName' => $request->input('petName'),
            'petBreed' => $request->input('petBreed'),
            'petColor' => $request->input('petColor'),
            'petAge' => $request->input('petAge'),
            'petGender' => $request->input('petGender'),

            'petOwner' => $request->input('petOwner'),
            'currentAddress' => $request->input('currentAddress'),
            'contactNumber' => $request->input('contactNumber'),
            'mobileNumber' => $request->input('mobileNumber'),
            'emailAddress' => $request->input('emailAddress'),
            'fbAccountLink' => $request->input('fbAccountLink'),
            'personalBelongings' => $request->input('personalBelongings'),

            'textAreaDogToClass' => $request->input('textAreaDogToClass'),
            'textAreaWhatToAccomplish' => $request->input('textAreaWhatToAccomplish'),
            'textAreaWhereAboutUs' => $request->input('textAreaWhereAboutUs'),

            'healthRecord' => (Session::has('healthRecordfilePath')) ? Session::get('healthRecordfilePath') : null, // Upladed urls
            'laboratoryResult' => (Session::has('laboratoryResultfilePath')) ? Session::get('laboratoryResultfilePath') : null, // Upladed urls

            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        /*
            * Save enrollment form
        */
        if (!$enrollPet->save()) {
            /*
                * Rollback db transaction
            */
            DB::rollBack();
            /*
                * Delete uploads
            */
            ServiceEnrollmentHelper::imgRemoveUnlinkSession();
            /*
                * Throw warning failed to save
            */
            $data = [
                'status' => 'warning',
                'message' => 'Enrollment failed! Please try again later.'
            ];

            return response()->json($data);
        }

        /*
            * Insert all service available in cart to service enrolled model
        */
        $serviceToInsert = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ]);

        /*
            * Loop through service in cart
        */
        foreach ($serviceToInsert->get() as $row) {
            /*
                * Create uuid
            */
            do {
                $uuid = Str::uuid();
            } while (ServiceEnrolled::where('uuid', '=', $uuid)->first()  instanceof ServiceEnrolled);

            $enrollThisService = ServiceEnrolled::create([
                'uuid' => $uuid,
                'user_uuid' => Auth::guard('web')->user()->uuid,
                'service_uuid' => $row->uuid,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if (!$enrollThisService->save()) {
                /*
                    * Rollback db transaction
                */
                DB::rollBack();
                /*
                    * Delete uploads
                */
                ServiceEnrollmentHelper::imgRemoveUnlinkSession();
                /*
                    * Throw warning failed to save
                */
                $data = [
                    'status' => 'warning',
                    'message' => 'Enrollment failed! Please try again later.'
                ];

                return response()->json($data);
            }
        }

        /*
            * Update cart status to 2
        */
        $updateThis = $serviceToInsert->update([
            'status' => 2
        ]);

        /*
            * if error in updating
        */
        if (!$updateThis) {
            /*
                * Rollback db transaction
            */
            DB::rollBack();
            /*
               * Delete uploads
            */
            ServiceEnrollmentHelper::imgRemoveUnlinkSession();
            /*
                * Throw warning failed to save
            */
            $data = [
                'status' => 'warning',
                'message' => 'Enrollment failed! Please try again later.'
            ];

            return response()->json($data);
        }

        /*
            * Commit database transaction
        */
        DB::commit();
        /*
            * Clear session data without deleting uploads
        */
        ServiceEnrollmentHelper::unlinkSessionData();
        /*
            * Throw success response
        */
        $data = [
            'status' => 'success',
            'message' => 'Enrollment success! We will verify your enrollment as soon as possible. We will contact you in your mobile # or email address provided in your form.'
        ];

        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                           Enrollment cart service                          */
    /* -------------------------------------------------------------------------- */
    public function enrollmentCartService(Request $request)
    {
        /*
            * Check ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }

        /*
            * Get cart services
        */
        $servicesOrdered = ServiceOrders::where([
            ['user_uuid', '=', Auth::guard('web')->user()->uuid],
            ['status', '=', 1]
        ])->with('serviceOrderedOwner')->with('serviceDetails')->get();


        $data = [
            'status' => 'success',
            'message' => 'Services ordered fetched!',
            'servicesOrdered' => $servicesOrdered
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                 Remove service item in cart enrollment page                */
    /* -------------------------------------------------------------------------- */
    public function enrollmentCartServiceRemove(Request $request)
    {
        /*
            * Check ajax request
        */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return response()->json($data);
        }
        /*
            * Validate request
        */
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ], [
            'id.required' => 'Something\'s wrong! Please try again later.'
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
            * Find the item in serviceorders model
        */
        $deleteItemInCart = ServiceOrders::find($request->input('id'));

        /*
            * Count items
        */
        if ($deleteItemInCart->count() < 1) {
            /*
                * Throw warning service in cart not found
            */
            $data = [
                'status' => 'warning',
                'message' => 'Service not found in cart!'
            ];
            return response()->json($data);
        }
        /*
            * Count items
        */
        if ($deleteItemInCart->count() < 2) {
            /*
                * Throw warning need at least 1 service in cart
            */
            $data = [
                'status' => 'warning',
                'message' => 'You need at least 1 service in cart!'
            ];
            return response()->json($data);
        }

        /*
            * Proceed to delete item
        */
        if (!$deleteItemInCart->delete()) {
            /*
                * Throw warning service failed to delete
            */
            $data = [
                'status' => 'warning',
                'message' => 'Failed to cancel service in your cart!'
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'success',
            'message' => 'Successfully cancelled service in your cart!'
        ];
        return response()->json($data);
    }
}

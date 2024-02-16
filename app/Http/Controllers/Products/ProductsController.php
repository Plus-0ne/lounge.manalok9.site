<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use JavaScript;
use Notif_Helper;

class ProductsController extends Controller
{
    public function show()
    {

        $notif = Notif_Helper::GetUserNotification();

        /* Javascript variables */
        JavaScript::put([ // get trade_log details
            'ruuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'user_timezone' => Auth::guard('web')->user()->timezone
        ]);


        $data = array(
            'title' => 'Products Offer',
            'notif' => $notif,
        );

        $products = DB::table('products_inventory')->get();
        return view('pages/products/products', $data=['data'=>$data, 'products'=>$products]);
    }

}

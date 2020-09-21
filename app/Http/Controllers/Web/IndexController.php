<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Product;
class IndexController extends Controller
{
    public function index()
    {
 		/** New Apparel Product **/
        $apparel_record = Product::where('status', 1)->where('top_category_id', 1)->orderBy('id', 'DESC')->take(10)->get();

        $f_cosmetics_record = Product::where('status', 1)->Where('top_category_id', 2)->orWhere('top_category_id', 3)->orderBy('id','DESC')->take(5)->get();

        $s_cosmetics_record = Product::where('status', 1)->Where('top_category_id', 3)->orWhere('top_category_id', 2)->orderBy('id','ASC')->take(5)->get();

        /** New Crafts Product **/
        $craft_record = Product::where('status', 1)->where('top_category_id', 4)->orderBy('id','ASC')->take(5)->get();

        /** Latest 10 Product **/
        $latests_record = Product::where('status', 1)->orderBy('created_at', 'ASC')->take(10)->get();

        return view('web.index', compact('apparel_record',  'f_cosmetics_record', 's_cosmetics_record', 'craft_record', 'latests_record'));
    }
}

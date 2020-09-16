<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IndexController extends Controller
{
    public function index()
    {
 		/** New Apparel Product **/
        $apparel_record = DB::table('product')
            ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
            ->where('product.status', 1)
            ->where('product.top_category_id', 1)
            ->select('product.*', 'top_category.top_cate_name')
            ->orderBy('product.id', 'DESC')
            ->take(10)
            ->get();

        /** New Cosmetic Product **/
        $f_cosmetics_record = DB::table('product')
            ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
            ->where('product.status', 1)
            ->where('product.top_category_id', 2)
            ->select('product.*', 'top_category.top_cate_name')
            ->distinct('product.product_name')
            ->orderBy('product.id', 'DESC')
            ->take(5)
            ->get();

        foreach ($f_cosmetics_record as $key => $value) {

            if (isset($value->id) && !empty($value->id)) {

                $p_stock = DB::table('product_stock')
                    ->where('product_id', $value->id)
                    ->where('status', 1)
                    ->orderBy('price', 'ASC')
                    ->first();

                $value->price = $p_stock->price;
                $value->discount = $p_stock->discount;
            }
        }

        $s_cosmetics_record = DB::table('product')
            ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
            ->where('product.status', 1)
            ->where('product.top_category_id', 2)
            ->select('product.*', 'top_category.top_cate_name')
            ->orderBy('product.id', 'ASC')
            ->take(5)
            ->get();

        foreach ($s_cosmetics_record as $key => $value) {

            if (isset($value->id) && !empty($value->id)) {

                $p_stock = DB::table('product_stock')
                    ->where('product_id', $value->id)
                    ->where('status', 1)
                    ->orderBy('price', 'ASC')
                    ->first();

               
                $value->price = $p_stock->price;
                $value->discount = $p_stock->discount;
            }
        }

        /** New Crafts Product **/
        $craft_record = DB::table('product')
            ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
            ->where('product.status', 1)
            ->where('product.top_category_id', 4)
            ->select('product.*', 'top_category.top_cate_name')
            ->take(10)
            ->get();

        /** Latest 10 Product **/
        $latests_record = DB::table('product')
            ->where('product.status', 1)
            ->select('product.*')
            ->take(10)
            ->get();

        foreach ($latests_record as $key => $value) {

            if (empty($value->price)) {

                $p_stock = DB::table('product_stock')
                    ->where('product_id', $value->id)
                    ->where('status', 1)
                    ->orderBy('price', 'ASC')
                    ->first();
               
                $value->price = $p_stock->price;
                $value->discount = $p_stock->discount;
            }
        }

        return view('web.index', ['apparel_record' => $apparel_record, 'f_cosmetics_record' => $f_cosmetics_record, 's_cosmetics_record' => $s_cosmetics_record, 'craft_record' => $craft_record, 'latests_record' => $latests_record]);
    }
}

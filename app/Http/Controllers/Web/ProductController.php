<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Response;

class ProductController extends Controller
{
    public function productList($slug, $top_category_id, $sub_category_id, $last_category_id, $sorted_by)
    {
        if ($top_category_id != 0) {

            $label = DB::table('top_category')
                ->where('id', $top_category_id)
                ->first();

            $label = $label->top_cate_name;

            $products = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->where('top_category.id', $top_category_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.*', 'top_category.top_cate_name');

            if (($sorted_by == 0) || ($sorted_by == 1)) {

                $products = $products
                    ->orderBy('product.id', 'DESC');
            }

            if ($sorted_by == 2) {

                $products = $products
                    ->orderBy('product.price', 'ASC');
            }

            if ($sorted_by == 3) {

                $products = $products
                    ->orderBy('product.price', 'DESC');
            }

            $products = $products
                ->paginate(18);
        }

        if ($sub_category_id != 0) {

            $label = DB::table('sub_category')
                ->where('id', $sub_category_id)
                ->first();

            $label = $label->sub_cate_name;

            $products = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->where('sub_category.id', $sub_category_id)
                ->where('top_category.id', $top_category_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name');

            if (($sorted_by == 0) || ($sorted_by == 1)) {

                $products = $products
                    ->orderBy('product.id', 'DESC');
            }

            if ($sorted_by == 2) {

                $products = $products
                    ->orderBy('product.price', 'ASC');
            }

            if ($sorted_by == 3) {

                $products = $products
                    ->orderBy('product.price', 'DESC');
            }

            $products = $products
                ->paginate(18);
        }
        
        if ($last_category_id != 0) {

            $label = DB::table('third_level_sub_category')
                ->where('id', $last_category_id)
                ->first();

            $label = $label->third_level_sub_category_name;

            $products = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->where('third_level_sub_category.id', $last_category_id)
                ->where('sub_category.id', $sub_category_id)
                ->where('top_category.id', $top_category_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name', 'third_level_sub_category.third_level_sub_category_name');

            if (($sorted_by == 0) || ($sorted_by == 1)) {

                $products = $products
                    ->orderBy('product.id', 'DESC');
            }

            if ($sorted_by == 2) {

                $products = $products
                    ->orderBy('product.price', 'ASC');
            }

            if ($sorted_by == 3) {

                $products = $products
                    ->orderBy('product.price', 'DESC');
            }

            $products = $products
                ->paginate(18);
        }

        foreach ($products as $key => $value) {

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

        $top_category = DB::table('top_category')
            ->where('status', 1)
            ->get();

        $categories = [];
        foreach ($top_category as $key => $item) {
                
            $sub_categories = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get();

            if(!empty($sub_categories) && count($sub_categories) > 0){

                foreach($sub_categories as $keys => $items){

                    $last_categories = DB::table('third_level_sub_category')
                        ->where('sub_category_id', $items->id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

                    $items->last_category = $last_categories;
                }
            }

            $categories[] = [
                'top_category_id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'sub_categories' => $sub_categories
            ];
        }

        // dd($products);

        return view('web.product.product-list', compact('products', 'categories', 'label'));
    }

    public function productDetail($slug, $product_id) 
    {
        /** Product Details **/
        $product_detail = DB::table('product')
            ->where('product.id', $product_id)
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->first();

        if (empty($product_detail->price)) {
            
            $p_stock = DB::table('product_stock')
                ->where('product_id', $product_detail->id)
                ->where('status', 1)
                ->orderBy('price', 'ASC')
                ->first();

            $product_detail->price = $p_stock->price;
            $product_detail->discount = $p_stock->discount;
        }

        /** Product Size Stock **/
        $product_size_stock = DB::table('product_stock')
            ->where('product_stock.product_id', $product_id)
            ->where('product_stock.stock', '>', 0)
            ->where('product_stock.status', 1)
            ->get();

        /** Product Color **/
        $product_color = DB::table('product_color_mapping')
            ->where('product_color_mapping.product_id', $product_id)
            ->where('product_color_mapping.status', 1)
            ->get();

        /** Product Slider Images **/
        $product_slider_images = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();

        if(!empty($product_detail->top_category_id)){
            $related_product = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->where('product.id', '!=', $product_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->where('product.top_category_id', $product_detail->top_category_id)
                ->select('product.*', 'top_category.top_cate_name')
                ->get();
        }

        if(!empty($product_detail->sub_category_id)){
            $related_product = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->where('product.id', '!=', $product_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->where('product.sub_category_id', $product_detail->sub_category_id)
                ->select('product.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name')
                ->get();
        }

        if(!empty($product_detail->third_level_sub_category_id)){
            $related_product = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->where('product.id', '!=', $product_id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->where('product.third_level_sub_category_id', $product_detail->third_level_sub_category_id)
                ->select('product.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name', 'third_level_sub_category.third_level_sub_category_name')
                ->get();
        }

        return view('web.product.single-product', ['product_detail' => $product_detail, 'product_size_stock' => $product_size_stock, 'product_color' => $product_color, 'product_slider_images' => $product_slider_images, 'related_product' => $related_product]);
    }

    public function productSearch ($keyword)
    {
        $keyword = ucfirst($keyword);
        $keyword = explode(" ", $keyword);

        $product_list = "";
        $products = DB::table('product')
            ->Where(function ($query) use($keyword) {

                for ($i = 0; $i < count($keyword); $i++){
                    $query->orWhere('product.product_name', 'like',  '%'.$keyword[$i].'%');
                }      
            });

        $products = $products
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->select('product.*')
            ->distinct('product.product_name')
            ->get();

        foreach ($products as $key => $value) {

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

        if (!empty($products)) {

            foreach ($products as $key => $item) {

                $url = asset('assets/product_images/'.$item->banner);

                if (!empty($item->discount)){
                    $discount_amount = ($item->price * $item->discount) / 100;
                    $amount = ($item->price - $discount_amount);
                } else
                    $amount = $item->price;
                                          
                $product_list = $product_list."<div class=\"row\"><span class=\"triup glyphicon glyphicon-triangle-top\"></span></div> <div class=\"row livesrc\"><div class=\"col-md-3\"><img src=\"".$url."\" width=\"100\"></div><div class=\"col-md-9\"><p style=\"font-weight: bold;\"><a href=\"".route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id])."\">".$item->product_name."</a></p><p>₹".$amount."</p></div></div>";
            }
        } 
        
        if(!empty($product_list))
            print $product_list;  
        else {
            $product_list = "";
            
            print $product_list;
        }
    }

    public function productPriceCheck(Request $request)
    {   
        $price_and_discount = 0;

        if (!empty($request->input('stock_id'))) {
            
            $p_stock = DB::table('product_stock')
                ->where('id', $request->input('stock_id'))
                ->first();

            $after_discount = 0;

            if ($p_stock->discount > 0) {

                $discount = ($p_stock->price * $p_stock->discount)/100;
                $after_discount = $p_stock->price - $discount;
            }

            $price_and_discount = $p_stock->price.",".$after_discount;
        }

        print $price_and_discount;
    }
}

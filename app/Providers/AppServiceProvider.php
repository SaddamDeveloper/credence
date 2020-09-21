<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use Session;
use Auth;
use Cart;
use App\Models\Categories\TopCategory;
use App\Models\Categories\SubCategory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Customer View Composer
        View::composer('web.include.header', function ($view) {

            /******  Categories *****/
            $top_category = TopCategory::where('status', 1)->get();
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
            /****** Wish List ********/
            $wish_list_data = [];
            if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id))
            {
                $wish_list_data = DB::table('wishlist')
                ->join('product', 'wishlist.product_id', '=', 'product.id')
                ->where('user_id', Auth::guard('users')->user()->id)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.*')
                ->get();
            }


            /** Cart Items **/
            $cart_data = [];
            if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id))
            {
                $user_id = Auth::guard('users')->user()->id;

                // $cart = Cart::content();
                // if (count($cart) > 0) {
                //     for ($i = 0; $i < count($cart); $i++) {
                                
                //         $product_cnt = DB::table('product')
                //             ->where('product.id', $cart[$i]->product_id)
                //             ->where('product.status', 2)
                //             ->count();

                //         if($product_cnt > 0) {
                //             DB::table('cart')
                //                 ->where('user_id', $user_id)
                //                 ->where('cart.product_id', $cart[$i]->product_id)
                //                 ->delete();
                //         }
                //     }
                // }

                // $cart = Cart::restore(Auth::guard('users')->user()->id);
                // if (count($cart) > 0) {
                //     for ($i = 0; $i < count($cart); $i++) {

                //         if(($cart[$i]->size_id != 0) && ($cart[$i]->color_id == 0)) {
                                    
                //             $product = DB::table('product')
                //                 ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
                //                 ->where('product.id', $cart[$i]->product_id)
                //                 ->where('product_stock.id', $cart[$i]->size_id)
                //                 ->select('product.*', 'product_stock.size')
                //                 ->distinct()
                //                 ->first();
                //         }

                //         if(($cart[$i]->size_id == 0) && ($cart[$i]->color_id != 0)) {
                                    
                //             $product = DB::table('product')
                //                 ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
                //                 ->where('product.id', $cart[$i]->product_id)
                //                 ->where('product_color_mapping.id', $cart[$i]->color_id)
                //                 ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code')
                //                 ->distinct()
                //                 ->first();
                //         }

                //         if(($cart[$i]->size_id != 0) && ($cart[$i]->color_id != 0)) {
                                    
                //             $product = DB::table('product')
                //                 ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
                //                 ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
                //                 ->where('product.id', $cart[$i]->product_id)
                //                 ->where('product_stock.id', $cart[$i]->size_id)
                //                 ->where('product_color_mapping.id', $cart[$i]->color_id)
                //                 ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code', 'product_stock.size')
                //                 ->distinct()
                //                 ->first();
                //         }

                //         if(($cart[$i]->size_id == 0) && ($cart[$i]->color_id == 0)) {
                                
                //             $product = DB::table('product')
                //                 ->where('product.id', $cart[$i]->product_id)
                //                 ->select('product.*')
                //                 ->distinct()
                //                 ->first();
                //         }
                //         if (isset($product->size))
                //             $size = $product->size;
                //         else
                //             $size = "";

                //         if (isset($product->color_code))
                //             $color_code = $product->color_code;
                //         else
                //             $color_code = "";

                //         $cart_data[] = [
                //             'product_id' => $product->id,
                //             'slug' => $product->slug,
                //             'banner' => $product->banner,
                //             'product_name' => $product->product_name,
                //             'price' => $product->price,
                //             'discount' => $product->discount,
                //             'quantity' => $cart[$i]->quantity,
                //             'size' => $size,
                //             'color_code' => $color_code
                //         ];
                            
                //     }
                // }
            } 
            else 
            {
                if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');
                    // if (count($cart) > 0) {
                    //     foreach ($cart as $product_id => $item) {
                                    
                    //         if (!empty($product_id)) {
                    //             $product_cnt = DB::table('product')
                    //                 ->where('product.id', $product_id)
                    //                 ->where('product.status', 2)
                    //                 ->count();
                    //             if($product_cnt > 0){
                    //                 Session::forget('cart.'.$product_id);
                    //             }
                    //         }
                    //     }
                    // }


                    // $cart = Session::get('cart');
                    // if (count($cart) > 0) {
                    //     foreach ($cart as $product_id => $item) {
                    //         if (!empty($product_id)) {

                    //             $product = explode(',', $item);
                    //             $quantity = $product[0];
                    //             $size_id1 = $product[1];
                    //             $color_id1 = $product[2];

                    //             // size exists and color not exist
                    //             if(($size_id1 != 0) && ($color_id1 == 0)) {
                    //                 $product = DB::table('product')
                    //                     ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
                    //                     ->where('product.id', $product_id)
                    //                     ->where('product_stock.id', $size_id1)
                    //                     ->select('product.*', 'product_stock.size')
                    //                     ->first();
                    //             }
                    //             // size not exists and color exist
                    //             if(($size_id1 == 0) && ($color_id1 != 0)) {
                                    
                    //                 $product = DB::table('product')
                    //                     ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
                    //                     ->where('product.id', $product_id)
                    //                     ->where('product_color_mapping.id', $color_id1)
                    //                     ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code')
                    //                     ->distinct()
                    //                     ->first();
                    //             }
                    //             // size exists and color exists
                    //             if(($size_id1 != 0) && ($color_id1 != 0)) {
                    //                 $product = DB::table('product')
                    //                     ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
                    //                     ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
                    //                     ->where('product.id', $product_id)
                    //                     ->where('product_stock.id', $size_id1)
                    //                     ->where('product_color_mapping.id', $color_id1)
                    //                     ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code', 'product_stock.size')
                    //                     ->distinct()
                    //                     ->first();
                    //             }

                    //             if(($size_id1 == 0) && ($color_id1 == 0)) {
                                
                    //                 $product = DB::table('product')
                    //                     ->where('product.id', $product_id)
                    //                     ->select('product.*')
                    //                     ->distinct()
                    //                     ->first();
                    //             }

                    //             if (isset($product->size)){
                    //                 $size = $product->size;
                    //             }else {
                    //                 $size = "";
                    //             }

                    //             if (isset($product->color_code)){
                    //                 $color_code = $product->color_code;

                    //             }else{
                    //                 $color_code = "";
                    //             }
                    //             // $cart_data[] = [
                    //             //     'product_id' => $product->id,
                    //             //     'slug' => $product->slug,
                    //             //     'banner' => $product->banner,
                    //             //     'product_name' => $product->product_name,
                    //             //     'price' => $product->price,
                    //             //     'discount' => $product->discount,
                    //             //     'quantity' => $quantity,
                    //             //     'size' => $size,
                    //             //     'color_code' => $color_code
                    //             // ];
                    //         }
                        // }
                    }

                    // dd($cart_data);
                // }
            }

            // dd($categories);
            
            $data = [
                'categories' => $categories,
                'wish_list_data' => $wish_list_data,
                // 'cart_data' => $cart_data
            ];
            $view->with('header_data', $data);
        });

        // Admin View Composer
        View::composer('admin.template.partials.header', function ($view) {

            $new_order_cnt = DB::table('order')
                ->where('order_status', 1)
                ->count();

            $data = [
                'new_order_cnt' => $new_order_cnt,
            ];
           
            $view->with('header_data', $data);
        });
    }
}

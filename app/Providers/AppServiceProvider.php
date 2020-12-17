<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use App\Models\Categories\TopCategory;
use App\Models\Categories\SubCategory;
use App\Models\Product;
use App\Models\ProductColorMapping;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            $categories = TopCategory::where('status', 1)->get();
    
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

                $cart = Cart::where('user_id', $user_id)->get();

                if (!empty($cart) && count($cart) > 0) {
                    foreach ($cart as $item) {
                        $product = Product::where('id', $item->product_id)->where('status', 1)->first();
                        $size = ProductStock::find($item->size_id);
                        $color = ProductColorMapping::where('product_id', $product->id)->first();
                        $cart_data[] = [
                            'product_id' => $product->id,
                            'name' => $product->product_name,
                            'slug'=>$product->slug,
                            'image' => $product->banner,
                            'quantity' => $item->quantity,
                            'size_id' => $item->size_id,
                            'size' => $size->size,
                            'color' => $color->color,
                            'color_code' => $color->color_code,
                            'price' => $size->price,
                            'mrp' => $product->discount,
                            'stock' => $size->stock
                        ];
                    }
                }
                
            } 
            else 
            {
                $cart = Session::get('cart');
                $cart_data = [];
                if (!empty($cart) && count($cart) > 0) {
                    foreach ($cart as $product_id => $value) {
                        $product = Product::where('id', $product_id)->where('status', 1)->first();
                        $size = ProductStock::find($value['size_id']);
                        $color = ProductColorMapping::where('product_id', $product->id)->first();
                        $cart_data[] = [
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'slug'=>$product->slug,
                            'image' => $product->banner,
                            'quantity' => $value['quantity'],
                            'size_id' => $value['size_id'],
                            'size' => $size->size,
                            'color' => $color->color,
                            'color_code' => $color->color_code,
                            'price' => $size->price,
                            'mrp' => $product->discount,
                            'stock' => $size->stock
                        ];
                    }
                }
            }
 
            $data = [
                'categories' => $categories,
                'wish_list_data' => $wish_list_data,
                'cart_data' => $cart_data
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

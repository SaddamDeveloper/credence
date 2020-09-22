<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;
use Carbon\Carbon;
use App\Models\Product;
use Cart;
use App\Models\ProductStock;
use App\Models\ProductColorMapping;
class CartController extends Controller
{
    public function addCart(Request $request)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id))
        {
            // $check_cart_product = DB::table('cart')->where('identifier', Auth()->user()->id)->count();
            // if($check_cart_product > 0){
                $product_id = $request->input('product_id');
                $product_stock_id = $request->input('product_size_id');
                $product_color_id = $request->input('product_color_id');
                $qty = $request->input('qty');
                $pro = Product::findOrFail($product_id);
                $size = ProductStock::find($product_stock_id);
                $color = ProductColorMapping::find($product_color_id);
                $cartQty = Cart::count($product_id);
                
                /** Checking Product Size **/
                if (!empty($size)) {
                    if ($size->stock < $qty) {
                        return redirect()->back()->with('msg', 'Required quantity not available');
                    }else if($size->stock < ($qty + $cartQty)){
                        return redirect()->back()->with('msg', 'Cart has sufficient quantity');
                    }
                }
                // // Cদlor Checkbox
                // if(!empty($color)){
                //     if ($request->has('product_color_id')){
                //         $color = $request->input('product_color_id');
                //     } 
                //     else{
                //         $color = 0;
                //     }
                // }
                $add = Cart::add(['id' => $product_id,  'name' => $pro->product_name,  'qty' => $qty, 'price' => $size->price, 'options' => ['size' => $size, 'color' => $color,  'sku_id' => $pro->sku_id, 'product_image' => $pro->banner, 'slug' => $pro->slug,  'discount' => $size->discount]]);
                Cart::store(Auth::guard('users')->user()->id);

                // $data = Cart::restore(Auth::guard('users')->user()->id);
            // }else{
            //     dd(1);
            //     // Update
            // }
            // if ($check_cart_product < 1 ) {
                //     $product_id = $request->input('product_id');
                //     $product_stock_id = $request->input('product_size_id');
                //     $product_color_id = $request->input('product_color_id');
                //     $qty = $request->input('qty');
                //     $pro = Product::findOrFail($product_id);
                //     // $size = ProductStock::find($product_stock_id);
                //     // $color = ProductColorMapping::find($product_color_id);
                //     // $add = Cart::add(['id' => $product_id,  'name' => $pro->product_name,  'qty' => $qty, 'price' => $pro->price, 'options' => ['size' => $size, 'color' => $color,  'sku_id' => $pro->sku_id, 'product_image' => $pro->banner, 'slug' => $pro->slug,  'discount' => $pro->discount]]);
                //     // $data = Cart::content();
                //     /** Checking Product Size **/
                //     if ($request->has('product_size_id')) {
                //         $stock = ProductStock::findOrFail($product_stock_id);
                //         if ($stock->stock >= $request->input('qty')){
                //                 $size =  ProductStock::find($product_stock_id);
                //         }else{
                //             return redirect()->back()->with('msg', 'Required quantity not available');
                //         }
                //     } else {
                //         $stock = ProductStock::findOrFail($product_stock_id);
                //         if ($stock->stock >= $request->input('qty')) 
                //             $size = 0;
                //         else
                //             return redirect()->back()->with('msg', 'Required quantity not available');    
                //     }
                //     /** Checking Product Color **/
                //     if ($request->has('product_color_id')) {
                //         $color = ProductColorMapping::find($product_color_id);
                //     }else{
                //         $color = 0;
                //     }
                //     Cart::store(Auth::guard('users')->user()->id);
                    
                // } else {
                //     $product_id = $request->input('product_id');
                //     $product_stock_id = $request->input('product_size_id');
                //     $product_color_id = $request->input('product_color_id');
                //     $qty = $request->input('qty');
                //     $pro = Product::findOrFail($product_id);
                    
                //     // $cart_product = DB::table('cart')
                //     //     ->where('user_id', Auth::guard('users')->user()->id)
                //     //     ->where('product_id', $request->input('product_id'))
                //     //     ->first();
                //     $cart_data = DB::table('cart')->where('identifier', Auth()->user()->id)->first();
                //     $cart = unserialize($cart_data->content);

                //       /** Checking Product Size **/
                //       if ($request->has('product_size_id')) {
                //         $stock = ProductStock::findOrFail($product_stock_id);
                //         if ($stock->stock >= $request->input('qty')){
                //                 $size =  ProductStock::find($product_stock_id);
                //         }else{
                //             return redirect()->back()->with('msg', 'Required quantity not available');
                //         }
                //     } else {
                //         $stock = ProductStock::findOrFail($product_stock_id);
                //         if ($stock->stock >= $request->input('qty')) 
                //             $size = 0;
                //         else
                //             return redirect()->back()->with('msg', 'Required quantity not available');    
                //     }
                //     /** Checking Product Color **/
                //     if ($request->has('product_color_id')) {
                //         $color = ProductColorMapping::find($product_color_id);
                //     }else{
                //         $color = 0;
                //     }


                //     // Cart Update
                //     // foreach ($cart as $key => $value) {
                //     //     DB::table('cart')
                //     //     ->where('identifier', Auth::guard('users')->user()->id)
                //     //     ->update([
                //     //         'size' => $value->options->size->size,
                //     //         'color' => $value->options->color->color
                //     //     ]);
                //     // }
                //     // DB::table('cart')
                //     //     ->where('user_id', Auth::guard('users')->user()->id)
                //     //     ->where('product_id', $request->input('product_id'))
                //     //     ->increment('quantity', (int)$request->input('qty'));

                //     // DB::table('cart')
                //         // ->where('user_id', Auth::guard('users')->user()->id)
                //         // ->where('product_id', $request->input('product_id'))
                //         // ->update([
                //         //     'size_id' => $size,
                //         //     'color_id' => $color
                //         // ]);
            // }
        }
        else
        {
                // Guest
            $product_id = $request->input('product_id');
            $product_stock_id = $request->input('product_size_id');
            $product_color_id = $request->input('product_color_id');
            $qty = $request->input('qty');
            $pro = Product::findOrFail($product_id);
            $size = ProductStock::find($product_stock_id);
            $color = ProductColorMapping::find($product_color_id);
            $cartQty = Cart::count($product_id);
                /** Checking Product Size **/
                if (!empty($size)) {
                    if ($size->stock < $qty) {
                        return redirect()->back()->with('msg', 'Required quantity not available');
                    }else if($size->stock < ($qty + $cartQty)){
                        return redirect()->back()->with('msg', 'Cart has sufficient quantity');
                    }
                }
                // // COlor Checkbox
                // if(!empty($color)){
                //     if ($request->has('product_color_id')){
                //         $color = $request->input('product_color_id');
                //     } 
                //     else{
                //         $color = 0;
                //     }
                        
                // }
                $add = Cart::add(['id' => $product_id,  'name' => $pro->product_name,  'qty' => $qty, 'price' => $size->price, 'options' => ['size' => $size, 'color' => $color,  'sku_id' => $pro->sku_id, 'product_image' => $pro->banner, 'slug' => $pro->slug,  'discount' => $size->discount]]);
        }
        return redirect()->route('web.view_cart');
    }

    public function viewCart()
    {
        return view('web.cart.view_cart');
    }

    // public function viewCart()
        // {
        //     // If Authenticated
        //     $cart_data = [];
        //     if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id))
        //     {
        //             $user_id = Auth::guard('users')->user()->id;

        //             $cart = DB::table('cart')
        //                 ->where('user_id', $user_id)
        //                 ->get();

        //             if (count($cart) > 0) {
        //                 for ($i = 0; $i < count($cart); $i++) {
                                    
        //                     $product_cnt = DB::table('product')
        //                         ->where('product.id', $cart[$i]->product_id)
        //                         ->where('product.status', 2)
        //                         ->count();

        //                     if($product_cnt > 0) {
        //                         DB::table('cart')
        //                             ->where('user_id', $user_id)
        //                             ->where('cart.product_id', $cart[$i]->product_id)
        //                             ->delete();
        //                     }

        //                     if (!empty($cart[$i]->size_id)) {

        //                         $product_size_cnt = DB::table('product_stock')
        //                             ->where('product_stock.id', $cart[$i]->size_id)
        //                             ->where('product_stock.status', 2)
        //                             ->count();

        //                         if($product_size_cnt > 0) {

        //                             DB::table('cart')
        //                                 ->where('user_id', $user_id)
        //                                 ->where('cart.product_id', $cart[$i]->product_id)
        //                                 ->delete();
        //                         }
        //                     }

        //                     if (!empty($cart[$i]->color_id)) {

        //                         $product_size_cnt = DB::table('product_color_mapping')
        //                             ->where('product_color_mapping.id', $cart[$i]->color_id)
        //                             ->where('product_color_mapping.status', 2)
        //                             ->count();

        //                         if($product_size_cnt > 0) {
                                    
        //                             DB::table('cart')
        //                                 ->where('user_id', $user_id)
        //                                 ->where('cart.product_id', $cart[$i]->product_id)
        //                                 ->delete();
        //                         }
        //                     }
        //                 }
        //             }

        //             $cart = DB::table('cart')
        //                 ->where('user_id', $user_id)
        //                 ->get();

        //             if (count($cart) > 0) {
        //                 for ($i = 0; $i < count($cart); $i++) {

        //                     if(($cart[$i]->size_id != 0) && ($cart[$i]->color_id == 0)) {
                                        
        //                         $product = DB::table('product')
        //                             ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
        //                             ->where('product.id', $cart[$i]->product_id)
        //                             ->where('product_stock.id', $cart[$i]->size_id)
        //                             ->select('product.*', 'product_stock.size')
        //                             ->distinct()
        //                             ->first();
        //                     }

        //                     if(($cart[$i]->size_id == 0) && ($cart[$i]->color_id != 0)) {
                                        
        //                         $product = DB::table('product')
        //                             ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
        //                             ->where('product.id', $cart[$i]->product_id)
        //                             ->where('product_color_mapping.id', $cart[$i]->color_id)
        //                             ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code')
        //                             ->distinct()
        //                             ->first();
        //                     }

        //                     if(($cart[$i]->size_id != 0) && ($cart[$i]->color_id != 0)) {
                                        
        //                         $product = DB::table('product')
        //                             ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
        //                             ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
        //                             ->where('product.id', $cart[$i]->product_id)
        //                             ->where('product_stock.id', $cart[$i]->size_id)
        //                             ->where('product_color_mapping.id', $cart[$i]->color_id)
        //                             ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code', 'product_stock.size')
        //                             ->distinct()
        //                             ->first();
        //                     }

        //                     if(($cart[$i]->size_id == 0) && ($cart[$i]->color_id == 0)) {
                                    
        //                         $product = DB::table('product')
        //                             ->where('product.id', $cart[$i]->product_id)
        //                             ->select('product.*')
        //                             ->distinct()
        //                             ->first();
        //                     }

        //                     if (isset($product->size))
        //                         $size = $product->size;
        //                     else
        //                         $size = "";

        //                     if (isset($product->color_code))
        //                         $color_code = $product->color_code;
        //                     else
        //                         $color_code = "";

        //                     $cart_data[] = [
        //                         'product_id' => $product->id,
        //                         'slug' => $product->slug,
        //                         'banner' => $product->banner,
        //                         'product_name' => $product->product_name,
        //                         'price' => $product->price,
        //                         'discount' => $product->discount,
        //                         'quantity' => $cart[$i]->quantity,
        //                         'size' => $size,
        //                         'color_code' => $color_code
        //                     ];
                                
        //                 }
        //             }
        //     } 
        //     else 
        //     {
        //         // If as Guest
        //         if (Session::has('cart') && !empty(Session::get('cart'))) {
        //             $cart = Session::get('cart');
        //             if (count($cart) > 0) {
        //                 foreach ($cart as $product_id => $item) {
        //                         $product_cnt = DB::table('product')
        //                             ->where('product.id', $product_id)
        //                             ->where('product.status', 2)
        //                             ->count();
                                
        //                         if($product_cnt > 0){
        //                             Session::forget('cart.'.$product_id);
        //                         }

        //                         $product = explode(',', $item);
        //                         $quantity = $product[0];
        //                         $size_id = $product[1];
        //                         $color_id = $product[2];
        //                         if ($size_id != 0) {

        //                             $product_size_cnt = DB::table('product_stock')
        //                                 ->where('product_stock.id', $size_id)
        //                                 ->where('product_stock.status', 2)
        //                                 ->count();

        //                             if($product_size_cnt > 0) {

        //                                 Session::forget('cart.'.$product_id);
        //                             }
        //                         }

        //                         if ($color_id != 0) {

        //                             $product_size_cnt = DB::table('product_color_mapping')
        //                                 ->where('product_color_mapping.id', $color_id)
        //                                 ->where('product_color_mapping.status', 2)
        //                                 ->count();

        //                             if($product_size_cnt > 0) {
                                        
        //                                 Session::forget('cart.'.$product_id);
        //                             }
        //                         }
        //                 }
        //             }


        //             $cart = Session::get('cart');
        //             if (count($cart) > 0) {
        //                 foreach ($cart as $product_id => $item) {

        //                     if (!empty($product_id)) {

        //                         $product = explode(',', $item);
        //                         $quantity = $product[0];
        //                         $size_id1 = $product[1];
        //                         $color_id1 = $product[2];

        //                         if(($size_id1 != 0) && ($color_id1 == 0)) {
                                    
        //                             $product = DB::table('product')
        //                                 ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
        //                                 ->where('product.id', $product_id)
        //                                 ->where('product_stock.id', $size_id1)
        //                                 ->select('product.*', 'product_stock.size')
        //                                 ->distinct()
        //                                 ->first();
        //                         }
        //                         if(($size_id1 == 0) && ($color_id1 != 0)) {
                                    
        //                             $product = DB::table('product')
        //                                 ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
        //                                 ->where('product.id', $product_id)
        //                                 ->where('product_color_mapping.id', $color_id1)
        //                                 ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code')
        //                                 ->distinct()
        //                                 ->first();
        //                         }

        //                         if(($size_id1 != 0) && ($color_id1 != 0)) {
                                    
        //                             $product = DB::table('product')
        //                                 ->leftJoin('product_stock', 'product.id', '=', 'product_stock.product_id')
        //                                 ->leftJoin('product_color_mapping', 'product.id', '=', 'product_color_mapping.product_id')
        //                                 ->where('product.id', $product_id)
        //                                 ->where('product_stock.id', $size_id1)
        //                                 ->where('product_color_mapping.id', $color_id1)
        //                                 ->select('product.*', 'product_color_mapping.color', 'product_color_mapping.color_code', 'product_stock.size')
        //                                 ->distinct()
        //                                 ->first();
        //                         }

        //                         if(($size_id1 == 0) && ($color_id1 == 0)) {
                                    
        //                             $product = DB::table('product')
        //                                 ->where('product.id', $product_id)
        //                                 ->select('product.*')
        //                                 ->distinct()
        //                                 ->first();
        //                         }

        //                         // if (isset($product->size))
        //                         //     $size = $product->size;
        //                         // else
        //                         //     $size = "";

        //                         // if (isset($product->color_code))
        //                         //     $color_code = $product->color_code;
        //                         // else
        //                         //     $color_code = "";

        //                         // $cart_data[] = [
        //                         //     'product_id' => $product->id,
        //                         //     'slug' => $product->slug,
        //                         //     'banner' => $product->banner,
        //                         //     'product_name' => $product->product_name,
        //                         //     'price' => $product->price,
        //                         //     'discount' => $product->discount,
        //                         //     'quantity' => $quantity,
        //                         //     'size' => $size,
        //                         //     'color_code' => $color_code
        //                         // ];
        //                     }
        //                 }
        //             }

        //         }
        //     }

        //     return view('web.cart.view_cart', compact('cart_data'));
    // }

    public function removeCartItem($product_id)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) 
        {
            Cart::remove($product_id);
            return back();
        }
        else
        {
            Cart::remove($product_id);
            return back();
        }
    }
    public function updateCart(Request $request)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) 
        {
            if (Cart::count() > 0 && !empty(Cart::content())) {
                $cart = Cart::get($request->input('product_id'));
                if (Cart::count($request->input('product_id')) > 0) {
                    /** Checking Product Size **/
                    if (!empty($cart->options->size->size)) {
                        $stock = ProductStock::where('id', $cart->options->size->id)->first();
                        if ($stock->stock >= $request->input('qty')) {
                            Cart::update($request->input('product_id'), $request->input('qty'));
                            return redirect()->route('web.view_cart');
                        }else{
                            return redirect()->back()->with('msg'.$cart->id, 'Required quantity not available');
                        }
                    } else {

                        $stock = Product::where('id', $cart->id)->first();

                        if ($stock->stock >= $request->input('qty')) {
                            Cart::update($request->input('product_id'), $request->input('qty'));
                            return redirect()->route('web.view_cart');
                        }else{
                            return redirect()->back()->with('msg'.$request->input('product_id'), 'Required quantity not available');    
                        }
                    }
                }

                Session::put('cart', $cart);
                Session::save();
            }
        }
        else
        {
            if (Cart::count() > 0 && !empty(Cart::content())) {
                $cart = Cart::get($request->input('product_id'));
                if (Cart::count($request->input('product_id')) > 0) {
                    /** Checking Product Size **/
                    if (!empty($cart->options->size->size)) {
                        $stock = ProductStock::where('id', $cart->options->size->id)->first();
                        if ($stock->stock >= $request->input('qty')) {
                            Cart::update($request->input('product_id'), $request->input('qty'));
                            return redirect()->route('web.view_cart');
                        }else{
                            return redirect()->back()->with('msg'.$cart->id, 'Required quantity not available');
                        }
                    } else {

                        $stock = Product::where('id', $cart->id)->first();

                        if ($stock->stock >= $request->input('qty')) {
                            Cart::update($request->input('product_id'), $request->input('qty'));
                            return redirect()->route('web.view_cart');
                        }else{
                            return redirect()->back()->with('msg'.$request->input('product_id'), 'Required quantity not available');    
                        }
                    }
                }

                Session::put('cart', $cart);
                Session::save();
            }
        }

        return redirect()->route('web.view_cart');
    }
}

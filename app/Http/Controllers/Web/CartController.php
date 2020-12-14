<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductColorMapping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Charges;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        if (Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) {
            $product_id = $request->input('product_id');
            $stock_id = $request->input('product_size_id');
            $qty = $request->input('qty');
            $color = $request->input('color');
            $product = Product::findOrFail($product_id);
            $stock = ProductStock::find($stock_id);
            /** Checking Product Size **/
            if (!empty($stock)) {
                if ($stock->stock < $qty) {
                    return redirect()->back()->with('msg', 'Required quantity not available');
                }
            }

            $size_id = $request->input('size_id');
            $count = 0;
            if (!empty($size_id)) {
                $count = Cart::whereUser_id(Auth::guard('users')->user()->id)->whereProduct_id($product_id)->whereSize_id($stock_id)->count();
            } else {
                $count = Cart::whereUser_id(Auth::guard('users')->user()->id)->whereProduct_id($product_id)->count();
            }
            if ($count == 0) {
                $cart = new Cart();
                $cart->user_id = Auth::guard('users')->user()->id;
                $cart->product_id = $product_id;
                $cart->size_id = $stock_id;
                $cart->quantity = $qty;
                
                $cart->save();
            } else {
                $cart = Cart::whereUser_id(Auth::guard('users')->user()->id)->whereProduct_id($product_id)->first();
                $cart->quantity = ($cart->quantity + $qty);
                $cart->save();
            }
        } else {
            // Guest
            $product_id = $request->input('product_id');
            $stock_id = $request->input('product_size_id');
            $qty = $request->input('qty');

            $product = Product::findOrFail($product_id);
            $stock = ProductStock::find($stock_id);

            // Get from session
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');
                $cart[$product_id] = [
                    'quantity' => $qty,
                    'size_id' => $stock_id,
                ];
            } else {
                $cart = [
                    $product_id => [
                        'quantity' => $qty,
                        'size_id' => $stock_id,
                    ],
                ];
            }
            Session::put('cart', $cart);
            Session::save();
        }
        return redirect()->route('web.view_cart');
    }
   

    public function viewCart()
    {
        $shipping_charge = Charges::first();
        $shipping_charge = $shipping_charge->amount;
        $total = 0;
        if (Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) {
            $cart_data = [];
            $user_id = Auth::guard('users')->user()->id;
            
            $cart = Cart::where('user_id', $user_id)->get();
            if (count($cart) > 0) {
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
                        'stock' => $size->stock,
                        'shipping_charge' => $shipping_charge
                    ];
                }
            } 
            else {
                $cart_data = false;
            }
        } else {
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');
                $cart_data = [];
                if (count($cart) > 0) {
                    foreach ($cart as $product_id => $value) {
                        $product = Product::where('id', $product_id)->where('status', 1)->first();
                        $size = ProductStock::find($value['size_id']);
                        $color = ProductColorMapping::where('product_id', $product->id)->first();
                        $cart_data[] = [
                            'product_id' => $product->id,
                            'slug'=>$product->slug,
                            'name' => $product->name,
                            'image' => $product->banner,
                            'quantity' => $value['quantity'],
                            'size_id' => $value['size_id'],
                            'size' => $size->size,
                            'color' => $color->color,
                            'color_code' => $color->color_code,
                            'price' => $size->price,
                            'mrp' => $product->discount,
                            'stock' => $size->stock,
                            'shipping_charge' => $shipping_charge
                        ];
                    }
                } else {
                    $cart_data = false;
                }
            } else {
                $cart_data = false;
            }
        }
        // dd($cart_data);
        return view('web.cart.view_cart', compact('cart_data', 'total', 'shipping_charge'));
    }

    public function removeCartItem($id)
    {
        if (Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) {
            $user_id = Auth::guard('users')->user()->id;
            $delete_cart = Cart::where('user_id', $user_id)->where('product_id', $id)->delete();
            return redirect()->route('web.view_cart')->with('message', 'Product Removed From Cart');
        } elseif (Session::has('cart') && !empty(Session::get('cart'))) {
            Session::forget('cart.' . $id);
            return redirect()->route('web.view_cart')->with('message', 'Product Removed From Cart');
        }
    }

    public function updateCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'qty' => ['required', 'numeric'],
        ]);

        $product_id = $request->input('product_id');
        $quantity = $request->input('qty');
        $stock = $request->input('stock');
        if (Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) {
            $product = Product::findOrFail($product_id);
            if ($stock >= $request->input('qty')) {
                $updateCart = Cart::where('user_id', Auth::guard('users')->user()->id)->where('product_id', $product_id)
                ->update([
                    'quantity' => $quantity
                ]);
            } else {
                return redirect()->back()->with('msg', 'Required quantity not available');
            }
           
            return redirect()->route('web.cart')->with('message', 'Cart Updated Successfully');
        } elseif (Session::has('cart') && !empty(Session::get('cart'))) {

            $product_id = $request->input('product_id');
            $quantity = $request->input('qty');
            $cart = Session::get('cart');
            $stock = ProductStock::find($cart[$product_id]['size_id']);
            if ($stock->stock >= $request->input('qty')) {
                $item = $cart[$product_id]['quantity'] = $quantity;
                Session::put('cart', $cart);
                Session::save();
            } else {
                return redirect()->back()->with('msg', 'Required quantity not available');
            }

            return redirect()->route('web.view_cart')->with('message', 'Cart Updated Successfully');
        }

        return redirect()->route('web.view_cart');
    }
}

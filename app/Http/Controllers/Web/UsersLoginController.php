<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:users')->except('logout');
    }

    public function showUserLoginForm()
    {
        return view('web.user.login', ['url' => 'users']);
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if ((Auth::guard('users')->attempt(['contact_no' => $request->username, 'password' => $request->password])) || (Auth::guard('users')->attempt(['email' => $request->username, 'password' => $request->password]))) {
             // get cart from DB if it exists
            $storedCartItems = DB::table('cart')->where([
                ['identifier', Auth::guard('users')->user()->id],
                ['instance', 'shopping']
            ])->value('content');
            // get wishlist from DB if it exists
            $storedWishlistItems = DB::table('cart')->where([
                ['identifier', Auth::guard('users')->user()->id],
                ['instance', 'wishlist']
            ])->value('content');
            $storedCartItems = \unserialize($storedCartItems);

            $storedWishlistItems = \unserialize($storedWishlistItems);
            if($storedCartItems){
                foreach ($storedCartItems as $item){
                    Cart::instance('shopping')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Models\Product');
                    // if it passes, I'll add them to the cart in the session
                    if (($item->model->qty > 0) & ($item->model->qty < $item->qty)){
                        Cart::instance('shopping')->update($item->rowId, $item->model->qty);
                    // if it does not pass, I will not add them to the cart in the session
                    } elseif ($item->model->qty == 0){
                        Cart::instance('shopping')->remove($item->rowId);
                    }
                }
            }
    
            //add items from wishlist from DB to the wishlist items in the session
            if($storedWishlistItems){
                foreach ($storedWishlistItems as $item){
                    Cart::instance('wishlist')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Models\Product');
                }
            }    
            // /** If Cart is Present **/
           
        // if (Cart::count() > 0 && !empty(Cart::content())) {
            //     foreach ($cart as $product_id => $item) {

            //             $product = explode(',', $item);
            //             $quantity = $product[0];
            //             $size_id1 = $product[1];
            //             $color_id1 = $product[2];

            //             $check_cart_product = DB::table('cart')
            //                 ->where('user_id', Auth::guard('users')->user()->id)
            //                 ->where('product_id', $product_id)
            //                 ->count();

            //             if ($check_cart_product < 1 ) {
            //                 DB::table('cart')
            //                     ->insert([
            //                         'user_id' => Auth::guard('users')->user()->id,
            //                         'product_id' =>  $product_id,
            //                         'size_id' =>  $size_id1,
            //                         'color_id' =>  $color_id1,
            //                         'quantity' => (int)$quantity,
            //                         'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            //                     ]);
            //             }
            //         }
            // }

            return redirect()->intended('/');
        }

        return back()->withInput($request->only('username'))->with('login_error', 'Username or password incorrect');
    }

    public function logout()
    {
        //delete old cartitems
        DB::table('cart')->where([
            ['identifier', Auth::user()->id],
            ['instance', 'shopping']
        ])->delete();

        // DB::table('cart')->where([
        //     ['identifier', Auth::user()->id],
        //     ['instance', 'wishlist']
        // ])->delete();

        //save new cart items
        Cart::instance('shopping')->store(Auth::user()->id);
        // Cart::instance('wishlist')->store(Auth::user()->id);
        Auth::guard('users')->logout();
        return redirect()->route('web.login');
    }
}

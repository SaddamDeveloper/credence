<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Session;
use DB;
use Carbon\Carbon;
use Cart;
class UsersLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:users')->except('logout');
    }

    public function showUserLoginForm(){
        return view('web.user.login', ['url' => 'users']);
    }

    public function userLogin(Request $request){
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if ((Auth::guard('users')->attempt(['contact_no' => $request->username, 'password' => $request->password])) || (Auth::guard('users')->attempt(['email' => $request->username, 'password' => $request->password]))) {
            // /** If Cart is Present **/
            Cart::store(Auth::guard('users')->user()->id);
            Cart::restore(Auth::guard('users')->user()->id);
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

        return back()->withInput($request->only('username'))->with('login_error','Username or password incorrect');
    }

    public function logout()
    {
        if(Cart::count() > 0 && !empty(Cart::content())){
            Cart::store(Auth::guard('users')->user()->id);
        }
        Auth::guard('users')->logout();
        return redirect()->route('web.login');
    }
}

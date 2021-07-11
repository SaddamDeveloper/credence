<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        	//************Check Session Shopping Cart**********************
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');
                if (count($cart) > 0) {
                    foreach ($cart as $product_id => $value) {
                    $color = null;
                    $size_id = null;
                    if ( isset($value['color_id']) && !empty($value['color_id'])) {
                        $color = $value['color_id'];
                    }
                    if ( isset($value['size_id']) && !empty($value['size_id'])) {
                        $size_id = $value['size_id'];
                    }
                    $check_cart_product = DB::table('cart')
                        ->where('product_id',$product_id)
                        ->where('user_id',Auth::guard('users')->user()->id)
                        ->count();
                    if ($check_cart_product < 1 ) {
                        DB::table('cart')
                            ->insert([
                                'user_id' => Auth::guard('users')->user()->id,
                                'product_id' =>  $product_id,
                                'size_id' => $size_id,
                                'color_id' => $color,
                                'quantity' => $value['quantity'],
                                'shipping_charge' => $value['shipping_charge'],
                                'tax_id' => $value['tax_id'],
                                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                    }
                    }
                }
                Session::forget('cart');
                Session::save();
             }
            return redirect()->intended('/');
        }

        return back()->withInput($request->only('username'))->with('login_error', 'Username or password incorrect');
    }

    public function logout()
    {
      
       
        Auth::guard('users')->logout();
        return redirect()->route('web.login');
    }
}

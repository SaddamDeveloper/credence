<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Admin\Admin;
use Hash;
use Auth;
use App\Models\Product;
class AdminDashboardController extends Controller
{
    public function index(){

    	$total_user = DB::table('users')
    		->count();

    	$total_brand = DB::table('brand')
    		->count();

    	$total_order = DB::table('order')
    		->count();

    	$latest_ten_user = DB::table('users')
    		->orderBy('id', 'DESC')
    		->limit(6)
    		->get();
		$total_product = Product::count();
    	$latest_ten_order = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.order_status', 1)
                            ->limit(6)
                            ->orderBy('order.id', 'DESC')
                            ->get();

    	return view('admin.dashboard', ['total_user' => $total_user, 'total_brand' => $total_brand, 'total_order' => $total_order, 'latest_ten_user' => $latest_ten_user, 'latest_ten_order' => $latest_ten_order, 'total_product' => $total_product]);
	}
	public function profile()
	{
		$admin = Admin::first();
		return view('admin.profile', compact('admin'));
	}
	public function changePasswordPage()
	{
		return view('admin.change_password');
	}
	public function changePassword(Request $request)
	{
		$validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('error','Your current password does not matches with the password you provided. Please try again.');
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }


        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("message","Password changed successfully !");
	}

}

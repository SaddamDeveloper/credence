<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function coupon(Request $request){
        // Eligibility check
        $grand_total = $request->input('grand_total');
        $coupon = $request->input('coupon');
        
        // old User
        $orders = Order::where('user_id', Auth::guard('users')->user()->id)->where('order_status', 3)->count();
        
        if($orders > 0) {
            // Old User
            return $this->couponApply(2, $coupon, $grand_total);
        }else {
            // newuser
            return $this->couponApply(1, $coupon, $grand_total);
        }
    }

    private function couponApply($userType, $coupon, $grand_total){
        $coupon = Coupon::where('code', $coupon)->where('usertype', $userType)->first();
        if($coupon){
            $afterCoupon = ($grand_total * $coupon->discount)/ 100;
            $grand_total = ($grand_total - $afterCoupon);
            $coupon_data = [
                number_format($afterCoupon, 2), number_format($grand_total, 2)
            ];
            return $coupon_data;
        }else{
            return null;
        }
    }
}

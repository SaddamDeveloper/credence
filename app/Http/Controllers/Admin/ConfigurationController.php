<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Charges;
use App\Models\Coupon;
class ConfigurationController extends Controller
{
    public function chargesList()
    {
        $charges = Charges::orderBy('id','desc')->get();
        return view('admin.charges.charges_list',compact('charges')); 
    }

    public function chargesEdit($charges_id)
    {
        try {
            $id = decrypt($charges_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $charges = Charges::where('id',$id)->first();
        
        return view('admin.charges.edit_charges',compact('charges'));
    }

    public function chargesUpdate(Request $request,$id)
    {   
        $this->validate($request, [
            'amount'   => 'required',
            
        ]);
        Charges::where('id',$id)
            ->update([
                'amount'=>$request->input('amount'),
               
        ]);
        return redirect()->back()->with('message','Charges Updated Successfully');
        
    }

    public function couponList(){
        $coupons = Coupon::orderBy('id','desc')->get();
        return view('admin.coupon.coupon_list',compact('coupons'));
    }

    public function addCoupon(){
        return view('admin.coupon.coupon_add_form');
    }

    public function couponInsertForm(Request $request){

            $this->validate($request, [
                'code'   => 'required',
                'discount'   => 'required',
                'desc'=>'required'
            ]);

            $coupons = new Coupon();
            $coupons->code = $request->input('code');
            $coupons->description =$request->input('desc');
            $coupons->discount = $request->input('discount');
            $coupons->save();
          
            if ($coupons) {
                return redirect()->back()->with('message','Coupon Added Successfull');
            } else {
                return redirect()->back()->with('error','Something Wrong Please Try again');
            }
    }

    public function couponEdit($coupon_id)
    {
        try {
            $id = decrypt($coupon_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $coupons = Coupon::where('id',$id)->first();
        return view('admin.coupon.coupon_add_form',compact('coupons'));
    }

    public function couponUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'code'   => 'required',
            'discount'   => 'required',
            'desc'=>'required'
            
        ]);
        Coupon::where('id',$id)
            ->update([
                'code'=>$request->input('code'),
                'discount' => $request->input('discount'),
                'description' => $request->input('desc')
            ]);
            return redirect()->back()->with('message','Coupon Updated Successfully');
    }

    public function couponStatus($id,$status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $category = Coupon::where('id',$id)
        ->update([
            'status'=>$status,
        ]);
        return redirect()->back();
    }

}

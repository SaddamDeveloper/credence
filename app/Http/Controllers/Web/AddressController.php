<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;

class AddressController extends Controller
{
    public function addressList(){

        $address = DB::table('address')
            ->where('user_id', Auth::guard('users')->user()->id)
            ->get();

        return view('web.address.address', ['address' => $address]);
    }
    public function addAddress(Request $request)
    {
            // $request->validate([
            //     'name'    => 'required',
            //     'email' => 'required|email',
            //     'address' => 'required',
            //     'city' => 'required',
            //     'state' => 'required',
            //     'pin_code' => 'required|numeric',
            //     'mobile_no' => 'required|numeric',
            // ]);
            $add = DB::table('address')
                ->insert([
                    'user_id' => Auth()->user()->id,
                    'name'    => ucwords(strtolower($request->input('name'))),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'pin_code' => $request->input('pin_code'),
                    'email' => $request->input('email'),
                    'mobile_no' => $request->input('mobile_no'),
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
            if($add){
                return 1;
            }
    }

    public function editAddress($address_id){

        $address = DB::table('address')
            ->where('id', $address_id)
            ->first();

        return view('web.address.edit-address', ['address' => $address]);
    }

    public function updateAddress(Request $request, $address_id)
    {
    	$request->validate([
            'name'    => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'state' => 'required',
            'pin_code' => 'required|numeric',
            'mobile_no' => 'required|numeric',
        ]);

        DB::table('address')
            ->where('id', $address_id)
        	->update([
        		'name'    => ucwords(strtolower($request->input('name'))),
	            'address' => $request->input('address'),
	            'city' => $request->input('city'),
	            'state' => $request->input('state'),
	            'pin_code' => $request->input('pin_code'),
	            'email' => $request->input('email'),
                'mobile_no' => $request->input('mobile_no'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
        	]);

        return redirect()->back()->with('msg', 'Address has been saved');
    }
}

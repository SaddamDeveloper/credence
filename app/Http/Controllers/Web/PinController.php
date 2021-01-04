<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pin;
use Illuminate\Support\Facades\Session;

class PinController extends Controller
{
    public function pincode(Request $request){
        $pincode = $request->input('pincode');
        $pin = Pin::where('pincode', $pincode)->first();
        if($pin){
            Session::put('pincode', $pin->pincode);
            Session::save();
            return 1;
        }else {
            Session::put('pincode', $pincode);
            Session::save();
            return 0;
        }
    }
}

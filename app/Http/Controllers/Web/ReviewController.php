<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function addReview(Request $request)
    {
    	$request->validate([
    		'product_id' => 'required',
            'star'    => 'required',
            'comment' => 'required',
        ]);

        try {
            $product_id = decrypt($request->input('product_id'));
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $review_cnt = DB::table('review')
        	->where('user_id', Auth()->user()->id)
        	->where('product_id', $product_id)
        	->count();

        if ($review_cnt < 1) {
        	
        	DB::table('review')
	        	->insert([
	        		'user_id' => Auth()->user()->id,
	        		'product_id' => $product_id,
		            'star' => count($request->input('star')),
		            'comment' => $request->input('comment'),
		            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
	        	]);
        }
        
        return redirect()->back();
    }
}

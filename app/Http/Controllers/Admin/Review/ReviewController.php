<?php

namespace App\Http\Controllers\Admin\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function newReviewList()
    {
        return view('admin.review.new_reviews_list');
    }

    public function verifiedReviewList()
    {
        return view('admin.review.verified_reviews_list');
    }

    public function reviewsListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'user_name',
                            3 => 'product_name',
                            4 => 'star',
                            5 => 'comment',
                            6 => 'date',
                            7 => 'action',
                        );

        try {
            $status = decrypt($request->input('status'));
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $totalData = DB::table('review')
        	->where('status', $status)
        	->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value'))) {            
            
            $reviews_data = DB::table('review')
            				->leftJoin('users', 'review.user_id', '=', 'users.id')
            				->leftJoin('product', 'review.product_id', '=', 'product.id')
        					->where('review.status', $status)
        					->select('review.*', 'product.product_name', 'users.name')
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $reviews_data = DB::table('review')
            				->leftJoin('users', 'review.user_id', '=', 'users.id')
            				->leftJoin('product', 'review.product_id', '=', 'product.id')
        					->where('review.status', $status)
        					->select('review.*', 'product.product_name', 'users.name')
                            ->where('users.name','LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = DB::table('review')
            				->leftJoin('users', 'review.user_id', '=', 'users.id')
            				->leftJoin('product', 'review.product_id', '=', 'product.id')
        					->where('review.status', $status)
        					->select('review.*', 'product.product_name', 'users.name')
                            ->where('users.name','LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($reviews_data)) {

            $cnt = 1;
            foreach ($reviews_data as $key => $item) {

                $nestedData['id']           = $cnt;
                $nestedData['user_name']    = "<a href=\"".route('admin.users_profile', ['user_id' => encrypt($item->user_id)])."\" title=\"View User Detail\" target=\"_blank\">$item->name</a>";
                $nestedData['product_name'] = "<a href=\"".route('admin.view_product', ['product_id' => encrypt($item->product_id)])."\" title=\"View Product Detail\" target=\"_blank\">$item->name</a>";
                $nestedData['star']         = $item->star;
                $nestedData['comment']      = $item->comment;
                $nestedData['date']         = \Carbon\Carbon::parse($item->created_at)->toDayDateTimeString();
                $nestedData['action']     = "&emsp;<a href=\"".route('admin.verified_review', ['user_id' => encrypt($item->user_id), 'product_id' => encrypt($item->product_id)])."\" class=\"btn btn-warning\">Click Me For Verified</a>&emsp;<a href=\"".route('admin.delete_review', ['user_id' => encrypt($item->user_id), 'product_id' => encrypt($item->product_id)])."\" class=\"btn btn-danger\">Delete</a>";

                $data[] = $nestedData;

                $cnt++;
            }
        }

        $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                    );
            
        print json_encode($json_data); 
    }

    public function verifiedReview($user_id, $product_id)
    {
    	try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('review')
        	->where('user_id', $user_id)
        	->where('product_id', $product_id)
        	->update([
        		'status' => 1
        	]);

        return redirect()->back();
    }

    public function deleteReview($user_id, $product_id)
    {
    	try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('review')
        	->where('user_id', $user_id)
        	->where('product_id', $product_id)
        	->delete();

        return redirect()->back();
    }
}

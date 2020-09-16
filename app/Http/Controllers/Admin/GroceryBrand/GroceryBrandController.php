<?php

namespace App\Http\Controllers\Admin\GroceryBrand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GroceryBrandController extends Controller
{
   public function showGroceryBrandForm() 
    {
        return view('admin.grocery.brand.grocery_brand_form');
    }

    public function addGroceryBrand(Request $request){
      $this->validate($request, [
            'brand_name'    => 'required',
        ]);

        $count = DB::table('grocery_brand')
            ->where('brand_name', ucwords(strtolower($request->input('brand_name'))))
            ->count();

        if ($count > 0)
            $msg = "Brand already added";
        else {
            DB::table('grocery_brand')
            ->insert([ 
                'brand_name' => ucwords(strtolower($request->input('brand_name')))
            ]);

            $msg = "Brand has been added successfully";
        }
         return redirect()->back()->with('msg', $msg);

    }

       
     public function showGroceryEditBrandForm($grocery_brand_id)  {
        try {
            $grocery_brand_id = decrypt($grocery_brand_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $grocery_brand_record = DB::table('grocery_brand')
            ->where('id', $grocery_brand_id)
            ->get();

        return view('admin.grocery.brand.grocery_edit_brand_form', ['data' => $grocery_brand_record]);
    }
    
     public function updateGroceryBrand(Request $request, $grocery_brand_id) {
        $this->validate($request, [
            'brand_name'    => 'required',
        ]);

        try {
            $grocery_brand_id = decrypt($grocery_brand_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $count = DB::table('grocery_brand')
            ->where('brand_name', ucwords(strtolower($request->input('brand_name'))))
            ->count();

        if ($count > 0)
            $msg = "Brand has been updated";
        else {
            DB::table('grocery_brand')
                ->where('id', $grocery_brand_id)
                ->update([ 
                    'brand_name' => ucwords(strtolower($request->input('brand_name')))
                ]);

            $msg = "Brand has been updated successfully";
        }
        return redirect()->back()->with('msg',$msg);
    }

    public function allGroceryBrand(){

    	$all_grocery_brand =DB::table('grocery_brand')->get();
    	return view('admin.grocery.brand.all_grocery_brand',['data'=>$all_grocery_brand]);
    }
}

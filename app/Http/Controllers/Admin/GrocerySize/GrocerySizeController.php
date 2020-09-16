<?php

namespace App\Http\Controllers\Admin\GrocerySize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GrocerySizeController extends Controller
{
   public function showGrocerySizeForm() 
    {
        return view('admin.grocery.size.grocery_new_size');
    }

     public function addGrocerySize(Request $request) 
    {
        $request->validate([
            'size' => 'required',
        ]);
       $count = DB::table('grocery_weight_unit')
          ->where('size',ucwords(strtolower($request->input('size'))))
          ->count();
       if($count>0){
           echo "already added";
       }
       else

        DB::table('grocery_weight_unit')
	        ->insert([ 
	          	'size' => $request->input('size'), 
	        ]);
        

        return redirect()->back()->with('msg', 'Size has been added successfully');
     }

     public function allGrocerySize(){

           $all_gocery_size = DB::table('grocery_weight_unit')->get();
           return view('admin.grocery.size.all_grocery_size',['data' => $all_gocery_size]);
      }

      public function showEditGrocerySizeForm($grocerysizeId) 
    {
        try {
            $grocerysizeId = decrypt($grocerysizeId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $size_record = DB::table('grocery_weight_unit')
            ->where('id', $grocerysizeId)
            ->get();

        return view('admin.grocery.size.edit_grocery_size_form',['data' => $size_record]);
    }

     public function updateGrocerySize(Request $request, $grocerysizeId) 
     {
        $request->validate([
            'size' => 'required',
        ]);

        try {
            $grocerysizeId = decrypt($grocerysizeId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('grocery_weight_unit')
            ->where('id', $grocerysizeId)
            ->update([ 
                'size' => $request->input('size')
            ]);

        return redirect()->route('admin.edit_grocery_size',['grocerysizeId' => encrypt($grocerysizeId)])->with('msg', 'Size has been updated successfully');
    }
     public function showGroceryMappingSizeForm() 
    {
        $all_top_category = DB::table('grocery_topcategory')->get();

        $all_size = DB::table('grocery_weight_unit')->get();

      
        $all_mapping_size = DB::table('grocery_size_mapping')
            ->leftJoin('grocery_weight_unit', 'grocery_size_mapping.size_id', '=', 'grocery_weight_unit.id')
            ->leftJoin('grocery_topcategory', 'grocery_size_mapping.top_category_id', '=', 'grocery_topcategory.id')
            ->leftJoin('grocery_sub_category', 'grocery_size_mapping.sub_category_id', '=', 'grocery_sub_category.id')
           ->select('grocery_size_mapping.*', 'grocery_weight_unit.size','grocery_sub_category.sub_cate_name','grocery_topcategory.top_cate_name')
           ->distinct()
           ->get();

        return view('admin.grocery.size.grocery_new_size_mapping', ['all_top_category' => $all_top_category, 'all_size' => $all_size,'all_mapping_size' => $all_mapping_size]);
    }

        public function addGroceryMappingSize(Request $request){
        $request->validate([
            'top_cate_id' => 'required',
            'sub_cate_id' => 'required',
            'size' => 'required',
            
        ]);

        $cnt = DB::table('grocery_size_mapping')
            ->where('top_category_id', $request->input('top_cate_id'))
           ->where('sub_category_id', $request->input('sub_cate_id'))
           ->where('size_id', $request->input('size'))
          

          ->count();

      if ($cnt > 0)
          return redirect()->back()->with('msg', 'Size already added');
        else {
          DB::table('grocery_size_mapping')
              ->insert([ 
                    'top_category_id' => $request->input('top_cate_id'), 
                'sub_category_id' => $request->input('sub_cate_id'), 
                'size_id' => $request->input('size'), 
                
              ]);

          return redirect()->back()->with('msg', 'Size Mapping has been added successfully');
        }
    }

       public function showEditGroceryMappingSizeForm($size_mapping_id){
        try {
            $size_mapping_id = decrypt($size_mapping_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $mapping_size_record = DB::table('grocery_size_mapping')
            ->where('id', $size_mapping_id)
            ->get();
        $sub_category_record = DB::table('grocery_sub_category')
            ->where('id', $mapping_size_record[0]->sub_category_id)
            ->get();
        $top_category_record = DB::table('grocery_topcategory')
            ->where('id', $mapping_size_record[0]->top_category_id)
            ->get();
        $all_size = DB::table('grocery_weight_unit')->get();

        return view('admin.grocery.size.grocery_edit_mapping_size', ['top_category_record' => $top_category_record, 'sub_category_record' => $sub_category_record, 'all_size' => $all_size, 'mapping_size_record' => $mapping_size_record]);
       }

        public function updateGroceryMappingSize(Request $request, $size_mapping_id)
    {
        try {
            $size_mapping_id = decrypt($size_mapping_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $size_mapping_record = DB::table('grocery_size_mapping')
            ->where('id', $size_mapping_id)
            ->get();

        $cnt = DB::table('grocery_size_mapping')
            ->where('top_category_id', $size_mapping_record[0]->top_category_id)
            ->where('sub_category_id', $size_mapping_record[0]->sub_category_id)
            ->where('size_id', $request->input('size'))
            ->count();

        if ($cnt > 0)
            return redirect()->back()->with('msg', 'Mapping has been already done');
        else {
            DB::table('grocery_size_mapping')
            ->where('id', $size_mapping_id)
            ->update([
                'size_id' => $request->input('size')
            ]);

            return redirect()->back()->with('msg', 'Mapping has been updated');
        }
    }

     




}

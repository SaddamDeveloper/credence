<?php

namespace App\Http\Controllers\admin\GrocerySubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Str;

class GrocerySubCategoryController extends Controller
{
	public function showGrocerySubCategoryForm() {
    $all_grocery_top_category = DB::table('grocery_topcategory')->get();
       
        
        return view('admin.grocery.sub_category.grocery_new_sub_category', ['data' => $all_grocery_top_category]);
    }

    public function addGrocerySubCategory (Request $request){
         $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug' => 'required',
        ]);
          $count  = DB::table('grocery_sub_category')
            ->where('sub_cate_name', ucwords(strtolower($request->input('sub_cate_name'))))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->count();
        if($count >0)
        	$msg="Grocery Subcategory already added";
        
        else{
        DB::table('grocery_sub_category')->insert([
              'top_category_id' => $request->input('top_cate_name'),
              'sub_cate_name' =>  ucwords(strtolower($request->input('sub_cate_name'))),
              'slug' => strtolower(Str::slug($request->input('slug'), '-')),
         
        ]);
    }

    return redirect()->back()->with('msg', "sub category added successfully");
        
    }

    public function listGrocerySubcategory(){
    
        $all_sub_category = DB::table('grocery_sub_category')
            ->leftJoin('grocery_topcategory', 'grocery_sub_category.top_category_id', '=', 'grocery_topcategory.id')
            ->select('grocery_sub_category.*', 'grocery_topcategory.top_cate_name')
            ->get();

        return view('admin.grocery.sub_category.all_grocery_sub_category', ['data' => $all_sub_category]);
    }

    public function showGroceryEditSubCategoryForm($grocerysubCategoryId){

     
        try {
            $grocerysubCategoryId = decrypt($grocerysubCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $sub_category_record = DB::table('grocery_sub_category')
            ->where('id', $grocerysubCategoryId)
            ->get();

        $all_top_category = DB::table('grocery_topcategory')->get();

        return view('admin.grocery.sub_category.edit_grocery_sub_category_form', ['data' => $sub_category_record, 'all_top_category' => $all_top_category]);
    

      }

      public function updateGrocerySubCategory(Request $request, $grocerySubCategoryId) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug'        => 'required',
        ]);

        try {
            $grocerySubCategoryId = decrypt($grocerySubCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $count  = DB::table('sub_category')
            ->where('sub_cate_name', ucwords(strtolower($request->input('sub_cate_name'))))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->count();

        if ($count > 0) 
            $msg = 'Sub-Category has been updated successfully';
        else {
            DB::table('grocery_sub_category')
                ->where('id', $grocerySubCategoryId)
                ->update([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_cate_name' => ucwords(strtolower($request->input('sub_cate_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),  
                ]);

            $msg = 'Sub-Category has been updated successfully';
        }

        return redirect()->back()->with('msg', $msg);
    }

    




    }


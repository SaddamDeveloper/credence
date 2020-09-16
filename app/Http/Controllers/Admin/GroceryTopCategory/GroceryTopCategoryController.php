<?php

namespace App\Http\Controllers\admin\GroceryTopCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Str;
class GroceryTopCategoryController extends Controller
{
	public function showTopCategoryForm() {
    	
        return view('admin.grocery.top_category.grocery_new_top_category');
    }
    public function addTopCategory(Request $request){
    
    $this->validate($request, [
            'top_cate_name' => 'required',
            
            'slug' => 'required',
        ]);
     $count  = DB::table('grocery_topcategory')
            ->where('top_cate_name', ucwords(strtolower($request->input('top_cate_name'))))
            ->count();
    if ($count > 0) {
            $msg = 'Top-Category already added';
        }
	else{
    DB::table('grocery_topcategory')
            ->insert([ 
                    
                    'top_cate_name' => ucwords(strtolower($request->input('top_cate_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),  
                ]);
             $msg = 'Top-Category has been added successfully';
      
     }
     return redirect()->back()->with('msg', $msg);

    }

     public function allTopCategory (){
           $all_top_category = DB::table('grocery_topcategory')
            ->get();

        return view('admin.grocery.top_category.all_top_category', ['data' => $all_top_category]);

     } 
     public function showGroceryTopCategoryForm($grocerytopCategoryId){
        try {
            $grocerytopCategoryId = decrypt($grocerytopCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $grocery_top_category_record = DB::table('grocery_topcategory')
            ->where('id', $grocerytopCategoryId)
            ->get();

        return view('admin.grocery.top_category.show_edit_grocery_top_category_form', ['data' => $grocery_top_category_record]);
    }

    public function updateGroceryTopCategory(Request $request, $grocerytopCategoryId) {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'slug' => 'required',
        ]);

        try {
            $grocerytopCategoryId = decrypt($grocerytopCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $old_file_name = DB::table('grocery_topcategory')
            ->where('id', $grocerytopCategoryId)
            ->get();

        DB::table('grocery_topcategory')
            ->where('id', $grocerytopCategoryId)
            ->update([ 
                'top_cate_name' => $request->input('top_cate_name'),
                'slug' => strtolower(Str::slug($request->input('slug'), '-')),
            ]);

        return redirect()->back()->with('msg', 'Top-Category has been updated successfully');
    }
    
 }

<?php

namespace App\Http\Controllers\Admin\SubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Str;
use Carbon\Carbon;
use App\Models\Categories\TopCategory;
class SubCategoryController extends Controller
{
    public function showSubCategoryForm () 
    {
        $top_categories = DB::table('top_category')
            ->where('status', 1)
            ->get();
        
        return view('admin.sub_category.new_sub_category', ['top_categories' => $top_categories]);
    }

    public function addSubCategory(Request $request) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug' => 'required',
        ]);
        
        /** Checking Sub-Category already exist **/
        $count  = DB::table('sub_category')
            ->where('sub_cate_name', ucwords(strtolower($request->input('sub_cate_name'))))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->count();
        

        if ($count > 0) 
            $msg = 'Sub-Category already added';
        else {
            $top_category = TopCategory::find($request->input('top_cate_name'));
            if($top_category->hasSubcategory == 2){
                $insertSubCategory = DB::table('sub_category')
                ->insert([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_cate_name' => ucwords(strtolower($request->input('sub_cate_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);
                $msg = 'Sub-Category has been added successfully';
            }else{
                $insertSubCategory = DB::table('sub_category')
                ->insert([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_cate_name' => ucwords(strtolower($request->input('sub_cate_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);
                
                if($insertSubCategory){
                    // Check Associate Top Category
                    $top_category->hasSubcategory = "2";
                    $top_category->save();
                    $msg = 'Sub-Category has been added successfully';
                }
            }


        }

        return redirect()->back()->with('msg', $msg);
    }

    public function allSubCategory () 
    {
        /** All Sub-Category **/
        $sub_categories = DB::table('sub_category')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->select('sub_category.*', 'top_category.top_cate_name')
            ->get();

        return view('admin.sub_category.all_sub_category', ['sub_categories' => $sub_categories]);
    }

    public function updateSubCategoryStatus($sub_category_id, $status)
    {
        
        // $top_category = TopCategory::where('')
        /** Updating sub_category status **/
        DB::table('sub_category')
            ->where('id', $sub_category_id)
            ->update([
                'status' => $status
            ]);

        /** Updating product status **/
        DB::table('product')
            ->where('sub_category_id', $sub_category_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function showEditSubCategoryForm($sub_category_id) 
    {
        $sub_category_record = DB::table('sub_category')
            ->where('id', $sub_category_id)
            ->first();

        $all_top_category = DB::table('top_category')->get();

        return view('admin.sub_category.edit_sub_category', ['sub_category_record' => $sub_category_record, 'all_top_category' => $all_top_category]);
    }

    public function updateSubCategory(Request $request, $sub_category_id) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug'        => 'required',
        ]);

        $count  = DB::table('sub_category')
            ->where('sub_cate_name', ucwords(strtolower($request->input('sub_cate_name'))))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->count();

        if ($count > 0) 
            $msg = 'Sub-Category has been updated successfully';
        else {
            DB::table('sub_category')
                ->where('id', $sub_category_id)
                ->update([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_cate_name' => ucwords(strtolower($request->input('sub_cate_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);

            $msg = 'Sub-Category has been updated successfully';
        }

        return redirect()->back()->with('msg', $msg);
    }
}

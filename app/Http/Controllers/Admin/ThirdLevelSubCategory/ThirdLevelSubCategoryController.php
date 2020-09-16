<?php

namespace App\Http\Controllers\Admin\ThirdLevelSubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Str;
use Carbon\Carbon;

class ThirdLevelSubCategoryController extends Controller
{
    public function showThirdLevelSubCategoryForm () 
    {
    	$top_categories = DB::table('top_category')
            ->where('status', 1)
    		->select('top_category.*')
    		->get();

        return view('admin.third_level_sub_category.new_sub_category', ['top_categories' => $top_categories]);
    }

    public function addThirdLevelSubCategory(Request $request) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'third_level_sub_cate_name' => 'required',
            'slug' => 'required',
        ]);

        $count  = DB::table('third_level_sub_category')
            ->where('sub_category_id', $request->input('sub_cate_name'))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->where('third_level_sub_category_name', ucwords(strtolower($request->input('third_level_sub_cate_name'))))
            ->count();

        if ($count > 0) 
            $msg = 'Sub-Category already added';
        else {
            DB::table('third_level_sub_category')
                ->insert([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_category_id' => $request->input('sub_cate_name'), 
                    'third_level_sub_category_name' => $request->input('third_level_sub_cate_name'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),  
                ]);

            $msg = 'Sub-Category has been added successfully';
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function allThirdLevelSubCategory () 
    {
        $third_sub_categories = DB::table('third_level_sub_category')
            ->leftJoin('sub_category', 'third_level_sub_category.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'third_level_sub_category.top_category_id', '=', 'top_category.id')
            ->select('third_level_sub_category.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name')
            ->distinct()
            ->get();

        return view('admin.third_level_sub_category.all_sub_category', ['third_sub_categories' => $third_sub_categories]);
    }

    public function updateThirdSubCategoryStatus($third_sub_category_id, $status)
    {
        /** Updating sub_category status **/
        DB::table('third_level_sub_category')
            ->where('id', $third_sub_category_id)
            ->update([
                'status' => $status
            ]);

        /** Updating product status **/
        DB::table('product')
            ->where('third_level_sub_category_id', $third_sub_category_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function showEditThirdLevelSubCategoryForm($third_sub_category_id) 
    {
        $third_level_sub_category_record = DB::table('third_level_sub_category')
            ->where('id', $third_sub_category_id)
            ->first();

        $sub_category_record = DB::table('sub_category')
        	->where('top_category_id', $third_level_sub_category_record->top_category_id)
        	->get();

        $all_top_category = DB::table('sub_category')
    		->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
    		->select('top_category.*')
    		->distinct()
    		->get();

        return view('admin.third_level_sub_category.edit_sub_category', ['sub_categories' => $sub_category_record, 'top_categories' => $all_top_category, 'third_level_sub_category' => $third_level_sub_category_record]);
    }

    public function updateThirdLevelSubCategory(Request $request, $third_sub_category_id) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'third_level_sub_cate_name' => 'required',
            'slug' => 'required',
        ]);

        $count  = DB::table('third_level_sub_category')
            ->where('sub_category_id', $request->input('sub_cate_name'))
            ->where('top_category_id', $request->input('top_cate_name'))
            ->where('third_level_sub_category_name', ucwords(strtolower($request->input('third_level_sub_cate_name'))))
            ->count();

        if ($count > 0) 
            $msg = '3rd Sub-Category has been updated successfully';
        else {
            DB::table('third_level_sub_category')
            	->where('id', $third_sub_category_id)
                ->update([ 
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_category_id' => $request->input('sub_cate_name'), 
                    'third_level_sub_category_name' => $request->input('third_level_sub_cate_name'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

            $msg = '3rd Sub-Category has been updated successfully';
        }

        return redirect()->back()->with('msg', $msg);
    }
}

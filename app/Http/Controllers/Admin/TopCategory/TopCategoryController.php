<?php

namespace App\Http\Controllers\Admin\TopCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Str;
use Carbon\Carbon;

class TopCategoryController extends Controller
{
    public function showNewTopCategoryForm()
    {
        return view('admin.top_category.new_top_category');
    }

    public function addTopCategory(Request $request)
    {
        $request->validate([
            'top_cate_name' => 'required',
            'slug' => 'required',
        ]);

        /** Checking if top-category already exist **/
        $top_category_cnt = DB::table('top_category')
            ->where('top_cate_name', ucwords(strtolower($request->input('top_cate_name'))))
            ->count();

        if($top_category_cnt > 0)
            return redirect()->back()->with('msg', 'Top-Category already added successfully');
        else{

            /** Inserting top-category **/
            DB::table('top_category')
                ->insert([ 
                    'top_cate_name' =>  ucwords(strtolower($request->input('top_cate_name'))),
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

            return redirect()->back()->with('msg', 'Top-Category has been added successfully');
        }
    }
    
    public function allTopCategory () 
    {
        /** All top-category **/
        $top_categories = DB::table('top_category')->get();
        
        return view('admin.top_category.all_top_category', ['top_categories' => $top_categories]);
    }

    public function updateTopCategoryStatus($top_category_id, $status)
    {
        /** Updating top_category status **/
        DB::table('top_category')
            ->where('id', $top_category_id)
            ->update([
                'status' => $status
            ]);

        /** Updating sub_category status **/
        DB::table('sub_category')
            ->where('top_category_id', $top_category_id)
            ->update([
                'status' => $status
            ]);

        /** Updating product status **/
        DB::table('product')
            ->where('top_category_id', $top_category_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function showEditTopCategoryForm($top_category_id) 
    {
        /** Retrive top-category **/
        $top_category_record = DB::table('top_category')
        	->where('id', $top_category_id)
        	->first();

        return view('admin.top_category.edit_top_category', ['top_category_record' => $top_category_record]);
    }

    public function updateTopCategory(Request $request, $top_category_id) 
    {
        $request->validate([
            'top_cate_name' => 'required',
            'slug' => 'required',
        ]);

        /** Checking if top-category already exist **/
        $top_category_cnt = DB::table('top_category')
            ->where('top_cate_name', ucwords(strtolower($request->input('top_cate_name'))))
            ->count();

        if($top_category_cnt > 0)
            return redirect()->back()->with('msg', 'Top-Category has been updated successfully');
        else{

            /** Updating top-category **/
            DB::table('top_category')
                ->where('id', $top_category_id)
                ->update([ 
                    'top_cate_name' =>  ucwords(strtolower($request->input('top_cate_name'))),
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

            return redirect()->back()->with('msg', 'Top-Category has been updated successfully');
        }
    }
}

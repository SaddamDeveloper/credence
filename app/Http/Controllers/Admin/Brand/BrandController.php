<?php

namespace App\Http\Controllers\Admin\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Carbon\Carbon;

class BrandController extends Controller
{
    public function showBrandForm() 
    {
        $top_category = DB::table('top_category')
            ->where('status', 1)
            ->get();

        return view('admin.brand.new_brand', ['top_category' => $top_category]);
    }

    public function addBrand(Request $request) 
    {
        $this->validate($request, [
            'brand_name'    => 'required',
            'top_cate_name'    => 'required|numeric',
            'sub_cate_name'    => 'required|numeric',
        ]);

        $count = DB::table('brand')
            ->where('top_category_id', $request->input('top_cate_name'))
            ->where('sub_category_id', $request->input('sub_cate_name'))
            ->where('brand_name', ucwords(strtolower($request->input('brand_name'))))
            ->count();

        if ($count > 0)
            return redirect()->back()->with('error', 'Brand already added');

        DB::table('brand')
            ->insert([ 
                'brand_name' => ucwords(strtolower($request->input('brand_name'))),
                'top_category_id' => $request->input('top_cate_name'),
                'sub_category_id' => $request->input('sub_cate_name'),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);

        return redirect()->back()->with('msg', 'Brand has been added successfully');
    }

    public function allBrand() 
    {
        $all_brand = DB::table('brand')
            ->leftJoin('top_category', 'brand.top_category_id', '=', 'top_category.id')
            ->leftJoin('sub_category', 'brand.sub_category_id', '=', 'sub_category.id')
            ->select('brand.*', 'top_category.top_cate_name', 'sub_category.sub_cate_name')
            ->get();

        return view('admin.brand.all_brand', ['data' => $all_brand]);
    }

    public function showEditBrandForm($brand_id) 
    {
        $brand_record = DB::table('brand')
            ->where('id', $brand_id)
            ->first();

        $top_category = DB::table('top_category')
            ->get();

        $sub_category = DB::table('sub_category')
            ->where('top_category_id', $brand_record->top_category_id)
            ->get();

        return view('admin.brand.edit_brand', ['brand_record' => $brand_record, 'top_category' => $top_category, 'sub_category' => $sub_category]);
    }

    public function updateBrand(Request $request, $brand_id) 
    {
        $this->validate($request, [
            'brand_name'    => 'required',
            'top_cate_name'    => 'required|numeric',
            'sub_cate_name'    => 'required|numeric',
        ]);

        $count = DB::table('brand')
            ->where('top_category_id', $request->input('top_cate_name'))
            ->where('sub_category_id', $request->input('sub_cate_name'))
            ->where('brand_name', ucwords(strtolower($request->input('brand_name'))))
            ->count();

        if ($count > 0)
            return redirect()->back()->with('msg', 'Brand has been updated successfully');

        DB::table('brand')
            ->where('id', $brand_id)
            ->update([ 
                'brand_name' => ucwords(strtolower($request->input('brand_name'))),
                'top_category_id' => $request->input('top_cate_name'),
                'sub_category_id' => $request->input('sub_cate_name'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);

        return redirect()->back()->with('msg', 'Brand has been updated successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Str;
use Response;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductAdditionalImage;
class ProductController extends Controller
{
    public function retriveSubCategory(Request $request)
    {
    	$all_sub_category = DB::table('sub_category')
    		->where('top_category_id', $request->input('category_id'))
    		->get();

    	$data = "<option value=\"\" disabled selected>Choose Sub-Category</option>";
    	foreach ($all_sub_category as $key => $value)
    		$data = $data."<option value=\"".$value->id."\">".$value->sub_cate_name."</option>";

    	print $data;
    }

    public function retriveThirdLevelSubCategory(Request $request)
    {
        $all_sub_category = DB::table('third_level_sub_category')
            ->where('sub_category_id', $request->input('sub_category_id'))
            ->where('top_category_id', $request->input('top_category_id'))
            ->get();

        $data = "<option value=\"\" disabled selected>Choose Sub-Category</option>";
        foreach ($all_sub_category as $key => $value)
            $data = $data."<option value=\"".$value->id."\">".$value->third_level_sub_category_name."</option>";

        print $data;
    }

    public function retriveBrand(Request $request)
    {
        $brand_list = DB::table('brand')
            ->where('top_category_id', $request->input('top_category_id'))
            ->where('sub_category_id', $request->input('sub_category_id'))
            ->where('status', 1)
            ->get();

        $brand = "<option value=\"\" disabled selected>Choose Brand</option>";
        foreach ($brand_list as $key => $value)
            $brand = $brand."<option value=\"".$value->id."\">".$value->brand_name."</option>";

        print $brand;
    }

    // public function bannerImage ($product_id) 
    // {
    //     $product_record = DB::table('product')
    //         ->where('id', $product_id)
    //         ->get();

    //     $path = public_path('assets/product/banner/'.$product_record[0]->banner);

    //     if (!File::exists($path)) 
    //         $response = 404;

    //     $file     = File::get($path);
    //     $type     = File::extension($path);
    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // }

    //  public function groceryBannerImage ($product_id) 
    // {

    //     try {
    //         $product_id = decrypt($product_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     $product_record = DB::table('grocery_product')
    //         ->where('id', $product_id)
    //         ->get();

    //     $path = public_path('assets/grocery/product/banner/'.$product_record[0]->banner);

    //     if (!File::exists($path)) 
    //         $response = 404;

    //     $file     = File::get($path);
    //     $type     = File::extension($path);
    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // }
    // public function groceryAdditionalImage ($additional_image_id) 
    // {

    //     try {
    //         $additional_image_id = decrypt($additional_image_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     $additional_image_record = DB::table('grocery_product_aditional_images')
    //         ->where('id', $additional_image_id)
    //         ->get();

    //     $path = public_path('assets/grocery/product/images/'.$additional_image_record[0]->additional_image);

    //     if (!File::exists($path)) 
    //         $response = 404;

    //     $file     = File::get($path);
    //     $type     = File::extension($path);
    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // }

    public function additionalImage ($additional_image_id) 
    {

        try {
            $additional_image_id = decrypt($additional_image_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $additional_image_record = DB::table('product_additional_images')
            ->where('id', $additional_image_id)
            ->get();

        $path = public_path('assets/product/images/'.$additional_image_record[0]->additional_image);

        if (!File::exists($path)) 
            $response = 404;

        $file     = File::get($path);
        $type     = File::extension($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function showProductForm () 
    {
        $top_category = DB::table('top_category')
            ->where('status', 1)
            ->get();
            
        return view('admin.product.new_product', ['top_category' => $top_category]);
    }

    public function addProduct(Request $request) 
    {
        $this->validate($request,[
        	'top_cate_name' => 'required',
            'product_name'  => 'required',
            'slug'  => 'required',
            'desc'  => 'required',
            'product_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=700,max_height=700',
        ]);
        // Lowest Price 
        $lowest_price = min($request->input('price'));
        // MRP price
        $mrp_price = min($request->input('discount'));

        $product = new Product;
        $product->product_name = $request->input('product_name');
        $product->slug = $request->input('slug');
        $product->top_category_id = $request->input('top_cate_name');
        $product->sub_category_id = $request->input('sub_cate_name');
        $product->third_level_sub_category_id = $request->input('third_level_sub_cate_name');
        $product->brand_id = $request->input('brand');
        $product->desc = $request->desc;
        $product->price = $lowest_price;
        $product->discount = $mrp_price;
        
        if($product->save()){
        /** Product Stock and Size **/
            if($request->has('size')){
                for($i = 0; $i < count($request->input('size')); $i++) 
                {
                    DB::table('product_stock')
                        ->insert([ 
                            'product_id' => $product->id,
                            'size' => $request->input('size')[$i], 
                            'stock' => $request->input('stock')[$i], 
                            'price' => $request->input('price')[$i], 
                            'discount' => $request->input('discount')[$i], 
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                        ]);
                }
            }
            
        /** Product Color **/
            if($request->has('color')){
                for($i = 0; $i < count($request->input('color')); $i++) 
                {
                    DB::table('product_color_mapping')
                        ->insert([ 
                            'product_id' => $product->id,
                            'color' => $request->input('color')[$i], 
                            'color_code' => $request->input('color_code')[$i], 
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                        ]);
                }
            }
                         
                /** Creating folder **/
                if(!File::exists(public_path()."/assets"))
                File::makeDirectory(public_path()."/assets");

            if(!File::exists(public_path()."/assets/product_images"))
                File::makeDirectory(public_path()."/assets/product_images");
                $banner = null;

            if($request->hasFile('product_images')){
                for($i = 0; $i < count($request->file('product_images')); $i++) 
                {
                    $original_file = $request->file('product_images')[$i];
                    $file   = time().$i.'.'.$original_file->getClientOriginalExtension();
                    if ($i == 0){
                        $banner = $file;
                    }
                     // Original Image
                     $destinationPath = public_path('/assets/product_images');
                     $img = Image::make($original_file->getRealPath());
                     $img->save($destinationPath.'/'.$file);
                     // Thumb Image
                     $destinationPath = public_path('/assets/product_images/thumb');
                     $img = Image::make($original_file->getRealPath());
                     $img->resize(600, 600, function ($constraint) {
                         $constraint->aspectRatio();
                     })->save($destinationPath.'/'.$file);
                     $product_image = new ProductAdditionalImage;
                     $product_image->product_id = $product->id;
                     $product_image->additional_image = $file;
                     $product_image->save();

                }
                $product->banner = $banner;
                $productId = $this->productId($product->id);
                $product->sku_id = $productId;
                $product->save();
            }
            
            return redirect()->back()->with('msg', 'Product has added successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong! Try after sometime');
        } 
    }

    public function productList()
    {
        return view('admin.product.product_list.product_list');
    }

    public function productListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'banner',
                            2 => 'product_name',
                            3 => 'slug',
                            4 => 'top_category',
                            5 => 'sub_category',
                            6 => 'third_sub_category',
                            7 => 'brand',
                            8 => 'product_images',
                            9 => 'action',
                        );

        $totalData = DB::table('product')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $product_data = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->offset($start)
                ->limit($limit)
                ->orderBy('product.id', 'DESC')
                ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                ->orWhere('third_level_sub_category.third_level_sub_category_name', 'LIKE',"%{$search}%")
                ->orWhere('brand.brand_name', 'LIKE',"%{$search}%")
                ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('product.id', 'DESC')
                ->get();

            $totalFiltered = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                ->orWhere('third_level_sub_category.third_level_sub_category_name', 'LIKE',"%{$search}%")
                ->orWhere('brand.brand_name', 'LIKE',"%{$search}%")
                ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($single_data->status == 1){
                    $val = "<a href=\"".route('admin.update_product_status', ['product_id' => $single_data->id, 'status' => 2])."\" class=\"btn btn-danger\">In-Active</a>";

                    $product_status = "<button type=\"button\" class=\"btn btn-success btn-xs\">Active</button>";
                }
                else{
                    $val = "<a href=\"".route('admin.update_product_status', ['product_id' => $single_data->id, 'status' => 1])."\" class=\"btn btn-success\">Active</a>";

                    $product_status = "<button type=\"button\" class=\"btn btn-danger btn-xs\">In-Active</button>";
                }


                if ($single_data->order_status == 1) {
                    $order_status = "<a href=\"".route('admin.delete_product', ['product_id' => $single_data->id])."\" class=\"btn btn-default\">Delete</a>";
                } else {
                    $order_status = "";
                }

                $nestedData['id']            = $cnt;
                $nestedData['image']  = "&emsp;<img src=\"".asset('assets/product_images/'.$single_data->banner)."\" width=\"60px\">";
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['slug']          = $single_data->slug;
                $nestedData['top_category']  = $single_data->top_cate_name;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['third_sub_category']  = $single_data->third_level_sub_category_name;
                $nestedData['brand']         = $single_data->brand_name;
                $nestedData['status']      = $product_status;

                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.additional_product_image_list', ['product_id' => $single_data->id])."\" class=\"btn btn-primary\" target=\"_blank\">Product Images List</a>";

                $nestedData['action']  = "&emsp;$val&emsp;<a href=\"".route('admin.view_product', ['product_id' => $single_data->id])."\" class=\"btn btn-primary\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_product', ['product_id' => $single_data->id])."\" class=\"btn btn-warning\" target=\"_blank\">Edit</a>&emsp;$order_status";

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

    public function updateProductStatus($product_id, $status) 
    {
        DB::table('product')
            ->where('id', $product_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function showProductImageList($product_id)
    {
        $additional_image_record = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        return view('admin.product.additional_image.additional_image' , ['additional_image_record' => $additional_image_record, 'product_record' => $product_record]);
    }

    public function updateProductAdditionalImage(Request $request, $additional_image_id)
    {
        $request->validate([
            'additional_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $additional_image_record = DB::table('product_additional_images')
            ->where('id', $additional_image_id)
            ->first();

        if ($request->hasFile('additional_image')) {
            $additional_image = $request->file('additional_image');
            $file   = time().'.'.$additional_image->getClientOriginalExtension();
         
            $destinationPath = public_path('/assets/product_images');
            $img = Image::make($additional_image->getRealPath());
            $img->save($destinationPath.'/'.$file);

            File::delete(public_path('assets/product_images/'.$additional_image_record->additional_image));
            DB::table('product_additional_images')
                ->where('id', $additional_image_id)
                ->update([ 
                    'additional_image' => $file, 
                ]);
        }

        return redirect()->back();
    }

    public function viewProduct($product_id)
    {
        $product_record = DB::table('product')
            ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
            ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
            ->where('product.id', $product_id)
            ->select('product.*', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
            ->first();

        $colors = DB::table('product_color_mapping')
            ->where('product_color_mapping.product_id', $product_id)
            ->get();

        $product_stock = DB::table('product_stock')
            ->where('product_stock.product_id', $product_id)
            ->get();

        return view('admin.product.action.view_product', ['product_record' => $product_record, 'colors' => $colors, 'product_stock' => $product_stock]);
    }

    public function showEditProduct ($product_id) 
    {
        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        $top_category = DB::table('top_category')
            ->where('id', $product_record->top_category_id)
            ->first();

        $brand_list = DB::table('brand')
            ->where('sub_category_id', $product_record->sub_category_id)
            ->where('top_category_id', $product_record->top_category_id)
            ->get();

        $sub_category_list = DB::table('sub_category')
            ->where('top_category_id', $product_record->top_category_id)
            ->get();

        $third_level_sub_category_list = DB::table('third_level_sub_category')
            ->where('sub_category_id', $product_record->sub_category_id)
            ->where('top_category_id', $product_record->top_category_id)
            ->get();

        $stocks = DB::table('product_stock')
            ->where('product_id', $product_id)
            ->get();

        $colors = DB::table('product_color_mapping')
            ->where('product_id', $product_id)
            ->get();
        return view('admin.product.action.edit_product', ['product_record' => $product_record, 'top_category' => $top_category, 'brand_list' => $brand_list, 'sub_category_list' => $sub_category_list, 'third_level_sub_category_list' => $third_level_sub_category_list, 'stocks' => $stocks, 'colors' => $colors]);
    }

    public function updateProductStockStatus($stock_id, $status)
    {
        DB::table('product_stock')
            ->where('id', $stock_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function updateProductColorStatus($color_id, $status)
    {
        DB::table('product_color_mapping')
            ->where('id', $color_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function updateProduct(Request $request, $product_id)
    {
        $request->validate([
            'product_name'  => 'required',
            'slug'  => 'required',
            'desc'          => 'required',
            'product_type'       => 'required'
        ]);

        // dd($request);

        /** If Product name already exist **/
        $count_product_name = DB::table('product')
            ->where('product_name', ucwords(strtolower($request->input('product_name'))))
            ->where('product.id', '!=', $product_id)
            ->count();

        if ($count_product_name > 0) {
            return redirect()->back()->with('error', 'Product Name already exist');
        }

        $product_detail = DB::table('product')
            ->where('id', $product_id)
            ->first();

        if ($request->input('product_type') == 1) {

            if($request->hasFile('size_chart')){

                File::delete(public_path()."/assets/product_size_chart/".$product_detail->size_chart);

                /** Creating folder **/
                if(!File::exists(public_path()."/assets"))
                    File::makeDirectory(public_path()."/assets");

                if(!File::exists(public_path()."/assets/product_size_chart"))
                    File::makeDirectory(public_path()."/assets/product_size_chart");

                /** Banner inserting **/
                $original_file = $request->file('size_chart');
                $size_chart_file   = time().'.'.$original_file->getClientOriginalExtension();
                        
                $destinationPath = public_path('/assets/product_size_chart');
                $img = Image::make($original_file->getRealPath());
                $img->save($destinationPath.'/'.$size_chart_file);

                DB::table('product')
                ->where('id', $product_id)
                ->update([
                    'size_chart' => $size_chart_file
                ]);
            }

            /** Product Info. Inserting **/
            DB::table('product')
                ->where('id', $product_id)
                ->update([ 
                    'product_name' => ucwords(strtolower($request->input('product_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'sku_id' => $request->input('sku_id'),
                    'product_type' => $request->input('product_type'), 
                    'sub_category_id' => $request->input('sub_cate_name'),
                    'third_level_sub_category_id' => $request->input('third_level_sub_cate_name'), 
                    'brand_id' => $request->input('brand'), 
                    'desc' => $request->desc, 
                    'price' => $request->input('price'), 
                    'discount' => $request->input('discount'), 
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);
            
            /** Product Stock and Size **/
            if($request->has('size')) 
            {
                for($i = 0; $i < count($request->input('size')); $i++) 
                {
                    if(!empty($request->input('stock_id')[$i]))
                    {
                        DB::table('product_stock')
                            ->where('id', $request->input('stock_id')[$i])
                            ->update([
                                'size' => $request->input('size')[$i], 
                                'stock' => $request->input('stock')[$i], 
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                    }
                    else {

                        if(!empty($request->input('size')[$i]) && !empty($request->input('stock')[$i])){
                            DB::table('product_stock')
                                ->insert([ 
                                    'product_id' => $product_id,
                                    'size' => $request->input('size')[$i], 
                                    'stock' => $request->input('stock')[$i], 
                                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                                ]);
                        }
                    }
                }
            }

            /** Product Color **/
            if($request->has('color')){
                for($i = 0; $i < count($request->input('color')); $i++) 
                {
                    if(!empty($request->input('color_id')[$i]))
                    {
                        DB::table('product_color_mapping')
                            ->where('id', $request->input('color_id')[$i])
                            ->update([
                                'color' => $request->input('color')[$i], 
                                'color_code' => $request->input('color_code')[$i], 
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                    }
                    else {
                        if(!empty($request->input('color')[$i]) && !empty($request->input('color_code')[$i])){
                            DB::table('product_color_mapping')
                                ->insert([ 
                                    'product_id' => $product_id,
                                    'color' => $request->input('color')[$i], 
                                    'color_code' => $request->input('color_code')[$i], 
                                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                                ]);
                        }
                    }
                }
            }
        } 
        elseif ($request->input('product_type') == 2) {

            /** Product Info. Inserting **/
            DB::table('product')
                ->where('id', $product_id)
                ->update([ 
                    'product_name' => ucwords(strtolower($request->input('product_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'sku_id' => $request->input('sku_id'),
                    'product_type' => $request->input('product_type'), 
                    'sub_category_id' => $request->input('sub_cate_name'),
                    'third_level_sub_category_id' => $request->input('third_level_sub_cate_name'), 
                    'brand_id' => $request->input('brand'), 
                    'desc' => $request->desc,  
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);

            /** Product Stock and Size **/
            if($request->has('size')){
                for($i = 0; $i < count($request->input('size')); $i++) 
                {
                    if(!empty($request->input('stock_id')[$i]))
                    {
                        DB::table('product_stock')
                            ->where('id', $request->input('stock_id')[$i])
                            ->update([
                                'size' => $request->input('size')[$i], 
                                'stock' => $request->input('stock')[$i], 
                                'discount' => $request->input('discount')[$i],
                                'price' => $request->input('price')[$i],
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                    }
                    else {

                        if(!empty($request->input('size')[$i]) && !empty($request->input('stock')[$i])){
                            DB::table('product_stock')
                                ->insert([ 
                                    'product_id' => $product_id,
                                    'size' => $request->input('size')[$i], 
                                    'stock' => $request->input('stock')[$i], 
                                    'discount' => $request->input('discount')[$i],
                                    'price' => $request->input('price')[$i],
                                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                                ]);
                        }
                    }
                }
            }
        } 
        else {

            /** Product Info. Inserting **/
            DB::table('product')
                ->where('id', $product_id)
                ->update([ 
                    'product_name' => ucwords(strtolower($request->input('product_name'))), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'sku_id' => $request->input('sku_id'),
                    'product_type' => $request->input('product_type'), 
                    'sub_category_id' => $request->input('sub_cate_name'),
                    'third_level_sub_category_id' => $request->input('third_level_sub_cate_name'), 
                    'brand_id' => $request->input('brand'), 
                    'stock' => $request->input('stock'),
                    'desc' => $request->desc, 
                    'price' => $request->input('price'), 
                    'discount' => $request->input('discount'), 
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
                ]);
        }

        return redirect()->back()->with('msg', 'Product has been updated successfully');
    }

    public function activeProductList()
    {
        return view('admin.product.product_list.active_product_list');
    }

    public function inactiveProductList()
    {
        return view('admin.product.product_list.in_active_product_list');
    }

    public function activeInactiveProductListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'banner',
                            2 => 'product_name',
                            3 => 'slug',
                            4 => 'top_category',
                            5 => 'sub_category',
                            6 => 'third_sub_category',
                            7 => 'brand',
                            8 => 'product_images',
                            9 => 'action',
                        );

        $totalData = DB::table('product')
            ->where('product.status', $request->input('status'))
            ->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $product_data = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->where('product.status', $request->input('status'))
                ->offset($start)
                ->limit($limit)
                ->orderBy('product.id', 'DESC')
                ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->where('product.status', $request->input('status'))
                ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                ->orWhere('third_level_sub_category.third_level_sub_category_name', 'LIKE',"%{$search}%")
                ->orWhere('brand.brand_name', 'LIKE',"%{$search}%")
                ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('product.id', 'DESC')
                ->get();

            $totalFiltered = DB::table('product')
                ->leftJoin('top_category', 'product.top_category_id', '=', 'top_category.id')
                ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                ->leftJoin('third_level_sub_category', 'product.third_level_sub_category_id', '=', 'third_level_sub_category.id')
                ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
                ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name', 'brand.brand_name', 'third_level_sub_category.third_level_sub_category_name')
                ->where('product.status', $request->input('status'))
                ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                ->orWhere('third_level_sub_category.third_level_sub_category_name', 'LIKE',"%{$search}%")
                ->orWhere('brand.brand_name', 'LIKE',"%{$search}%")
                ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($single_data->status == 1){
                    $val = "<a href=\"".route('admin.update_product_status', ['product_id' => $single_data->id, 'status' => 2])."\" class=\"btn btn-danger\">In-Active</a>";
                }
                else{
                    $val = "<a href=\"".route('admin.update_product_status', ['product_id' => $single_data->id, 'status' => 1])."\" class=\"btn btn-success\">Active</a>";
                }

                if ($single_data->order_status == 1) {
                    $order_status = "<a href=\"".route('admin.delete_product', ['product_id' => $single_data->id])."\" class=\"btn btn-default\">Delete</a>";
                } else {
                    $order_status = "";
                }

                $nestedData['id']            = $cnt;
                $nestedData['image']  = "&emsp;<img src=\"".asset('assets/product_images/'.$single_data->banner)."\" width=\"60px\">";
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['slug']          = $single_data->slug;
                $nestedData['top_category']  = $single_data->top_cate_name;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['third_sub_category']  = $single_data->third_level_sub_category_name;
                $nestedData['brand']         = $single_data->brand_name;


                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.additional_product_image_list', ['product_id' => $single_data->id])."\" class=\"btn btn-primary\" target=\"_blank\">Product Images List</a>";

                $nestedData['action']  = "&emsp;$val&emsp;<a href=\"".route('admin.view_product', ['product_id' => $single_data->id])."\" class=\"btn btn-primary\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_product', ['product_id' => $single_data->id])."\" class=\"btn btn-warning\" target=\"_blank\">Edit</a>&emsp;$order_status";

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

    public function deleteProduct($product_id)
    {
        $additional_image_record = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();

        foreach ($additional_image_record as $key => $item) {
            File::delete(public_path('assets/product_images/'.$item->additional_image));
        }

        DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->delete();

        DB::table('product_stock')
            ->where('product_id', $product_id)
            ->delete();

        DB::table('product_color_mapping')
            ->where('product_id', $product_id)
            ->delete();

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        File::delete(public_path('assets/product_images/'.$product_record->banner));

        DB::table('product')
            ->where('id', $product_id)
            ->delete();

        return redirect()->back();
    }

    /************************************************************************Manual Functions */ 
    function productId($id){
        $title_id = "PRO";
        $l_id = 6 - strlen((string)$id);
        $generatedID = $title_id ;
        for ($i=0; $i < $l_id; $i++) { 
            $generatedID .= "0";
        }
        $generatedID .= $id;
        return $generatedID;
    }
}

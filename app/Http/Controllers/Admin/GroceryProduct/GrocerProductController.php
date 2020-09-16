<?php

namespace App\Http\Controllers\Admin\GroceryProduct;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Str;
use File;

class GrocerProductController extends Controller
{
   public function showGroceryProductForm () 
    {    
        $top_category = DB::table('grocery_topcategory')
                      ->get();
        $all_brand = DB::table('grocery_brand')
            ->where('status', 1)
            ->get();
            
        return view('admin.grocery.product.grocery_new_product', ['top_category' => $top_category,'brand' => $all_brand]);
    }

    public function addGroceryProduct(Request $request) 
    {

        $request->validate([
        	'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'product_name'  => 'required',
            'brand'  => 'required',
            'slug'  => 'required',
            'desc'          => 'required',
            'banner'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'size_id' => 'required'
            
           
        ]);


        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $file   = time().'.'.$banner->getClientOriginalExtension();
         
            $destinationPath = public_path('/assets/grocery/product/banner');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);

            DB::table('grocery_product')
	            ->insert([ 
                    'product_name' => $request->input('product_name'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')),
                    'top_category_id' => $request->input('top_cate_name'), 
                    'sub_category_id' => $request->input('sub_cate_name'),
                    
                    'brand_id' => $request->input('brand'), 
                     
                    'desc' => $request->desc, 
                    
	            	'banner' => $file, 
                ]);

            $product_id = DB::getPdo()->lastInsertId();
                
            if($request->hasFile('slider_images'))
            {
                for($i = 0; $i < count($request->file('slider_images')); $i++) 
                {
                    $original_file = $request->file('slider_images')[$i];
                    $file   = time().$i.'.'.$original_file->getClientOriginalExtension();
                
                    $destinationPath = public_path('/assets/grocery/product/images');
                    $img = Image::make($original_file->getRealPath());
                    $img->save($destinationPath.'/'.$file);

                    DB::table('grocery_product_aditional_images')
                        ->insert([ 
                            'grocery_product_id' => $product_id,
                            'additional_image' => $file, 
                        ]);
                }
            }

            for($i = 0; $i < count($request->input('size_id')); $i++) 
            {
                DB::table('grocery_product_size_mapping')
                    ->insert([ 
                        'product_id' => $product_id,
                        'size_id' => $request->input('size_id')[$i], 
                    ]);
            }

          

            return redirect()->route('admin.grocery_product_stock_entry', ['product_id' => encrypt($product_id)]);

        } else 
        	return redirect()->back()->with('msg', 'Please ! select a banner');
    }

    public function groceryProductStockAmountEntry($product_id){
            try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
         $product_size = DB::table('grocery_product_size_mapping')
            ->leftJoin('grocery_weight_unit', 'grocery_product_size_mapping.size_id', '=', 'grocery_weight_unit.id')
            ->where('grocery_product_size_mapping.product_id', $product_id)
            ->select('grocery_weight_unit.*')
            ->get();



        return view('admin.grocery.product.grocery_product_stock_entry',['product_id' => $product_id,'product_size' => $product_size]);

    }

       public function addGroceryStockEntry(Request $request, $product_id)
    {
        $request->validate([
            'stock' => 'required',
            'amount' => 'required',
            'discount'=>'required'
        ]);


        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
           for ($i=0; $i < count($request->input('size_id')); $i++){ 
            DB::table('grocery_product_amount')
               ->insert([
                      'grocery_product_id'=> $product_id,
                      'amount' => $request->input('amount')[$i],
                      'size_id' => $request->input('size_id')[$i],
                      'price' => $request->input('price')[$i],
                      'discount' => $request->input('discount')[$i],
                      

                     ]);
                }
           for ($i=0; $i < count($request->input('size_id')); $i++){
            DB::table('grocery_product_stock')
                ->insert([
                    'product_id' => $product_id,
                    'size_id' => $request->input('size_id')[$i],
                    'stock' => $request->input('stock')[$i],
                ]);
            
        
         }
        return redirect()->route('admin.new_grocery_product')->with('msg', 'Product has been added sucessfully');
    }

    public function groceryProductList()
    {
        return view('admin.grocery.product.grocery_product_list');
    }

     public function groceryProductListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'product_name',
                            2 => 'slug',
                            3 => 'price',
                            4 => 'sub_category',
                            5 => 'top_category',
                            6 => 'brand'
                          
                        );

        $totalData = DB::table('grocery_product')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
    
        

        if(empty($request->input('search.value'))) {            
            
            $product_data = DB::table('grocery_product')
                           ->leftJoin('grocery_product_amount','grocery_product.id','=','grocery_product_amount.grocery_product_id')
                            ->leftJoin('grocery_sub_category', 'grocery_product.sub_category_id', '=', 'grocery_sub_category.id')
                            ->leftJoin('grocery_topcategory', 'grocery_sub_category.top_category_id', '=', 'grocery_topcategory.id')
                            ->leftJoin('grocery_brand', 'grocery_product.brand_id', '=', 'grocery_brand.id')
                            ->where('grocery_topcategory.id', 1)
                            ->select('grocery_product.*', 'grocery_sub_category.sub_cate_name', 'grocery_topcategory.top_cate_name', 'grocery_brand.brand_name','grocery_product_amount.amount','grocery_product_amount.price','grocery_product_amount.discount')
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('grocery_product')
                            ->leftJoin('grocery_product_amount','grocery_product.id','=','grocery_product_amount.grocery_product_id')
                            ->leftJoin('grocery_sub_category', 'grocery_product.sub_category_id', '=', 'grocery_sub_category.id')
                            ->leftJoin('grocery_topcategory', 'grocery_sub_category.top_category_id', '=', 'grocery_topcategory.id')
                            ->leftJoin('grocery_brand', 'grocery_product.brand_id', '=', 'grocery_brand.id')
                            ->where('grocery_topcategory.id', 1)
                            ->select('grocery_product.*', 'grocery_sub_category.sub_cate_name', 'grocery_topcategory.top_cate_name', 'grocery_brand.brand_name','grocery_product_amount.amount','grocery_product_amount.price','grocery_product_amount.discount')
                            
  
                            ->where('grocery_topcategory.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('grocery_sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            ->orWhere('grocery_brand.brand_name', 'LIKE',"%{$search}%")
                            ->orWhere('grocery_product.product_name', 'LIKE',"%{$search}%")
                            ->get();

            $totalFiltered = DB::table('grocery_product')
                          ->leftJoin('grocery_product_amount','grocery_product.id','=','grocery_product_amount.grocery_product_id')
                           
                            ->leftJoin('grocery_sub_category', 'grocery_product.sub_category_id', '=', 'grocery_sub_category.id')
                            ->leftJoin('grocery_topcategory', 'grocery_sub_category.top_category_id', '=', 'grocery_topcategory.id')
                            ->leftJoin('grocery_brand', 'grocery_product.brand_id', '=', 'grocery_brand.id')
                            ->where('grocery_topcategory.id', 1)
                            ->select('grocery_product.*', 'grocery_sub_category.sub_cate_name', 'grocery_topcategory.top_cate_name', 'grocery_brand.brand_name','grocery_product_amount.amount','grocery_product_amount.price','grocery_product_amount.discount')
                           
        
                            ->where('grocery_topcategory.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('grocery_sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            
                            ->orWhere('grocery_brand.brand_name', 'LIKE',"%{$search}%")
                            ->orWhere('grocery_product.product_name', 'LIKE',"%{$search}%")
                            
                            ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($single_data->status == 1)
                    $val = "<a href=\"".route('admin.change_apparel_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(0)])."\" class=\"btn btn-primary\">In-Active</a>";
                else
                    $val = "<a href=\"".route('admin.change_apparel_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(1)])."\" class=\"btn btn-primary\">Active</a>";

                $nestedData['id']            = $cnt;
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['slug']          = $single_data->slug;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['top_category']  = $single_data->top_cate_name;
                $nestedData['brand']         = $single_data->brand_name;
                $nestedData['price']         = $single_data->price;
                $nestedData['discount']      = $single_data->discount;
               
                $nestedData['product_banner']  = "&emsp;<a href=\"".route('admin.edit_grocery_product_banner', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-success\" target=\"_blank\">Change Banner</a>";

                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.additional_grocery_product_image_list', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary\" target=\"_blank\">Product Images List</a>";

                $nestedData['action']  = "&emsp;<a href=\"".route('admin.view_apparel_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-success\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_apparel_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-warning\" target=\"_blank\">Edit</a>&emsp;<a href=\"".route('admin.edit_apparel_product_size', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary\" target=\"_blank\">Size</a>&emsp;<a href=\"".route('admin.edit_apparel_product_color', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-info\" target=\"_blank\">Color</a>&emsp;<a href=\"".route('admin.edit_apparel_product_stock', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger\" target=\"_blank\">Stock</a>&emsp;$val";

          




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
 
   public function showEditGroceryProductBanner($product_id){
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $url = route('admin.grocery_banner_image', ['product_id' => encrypt($product_id)]);

        return view('admin.grocery.product.banner.edit_grocery_banner' , ['url' => $url, 'product_id' => $product_id]);
    }




    public function updateGroceryProductBanner(Request $request, $product_id)
    {
        
        $request->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $product_record = DB::table('grocery_product')
            ->where('id', $product_id)
            ->get();


        if ($request->hasFile('icon')) {
            $banner = $request->file('icon');
            $file   = time().'.'.$banner->getClientOriginalExtension();
         
            $destinationPath = public_path('assets/grocery/product/banner');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);

            File::delete(public_path('assets/grocery/product/banner/'.$product_record[0]->banner));
            DB::table('grocery_product')
                ->where('id', $product_id)
                ->update([ 
                    'banner' => $file, 
                ]);
        }

        return redirect()->back()->with('msg', 'Banner has been changed');

    }

     public function showGroceryProductImageList($product_id){

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }


        $additional_image_record = DB::table('grocery_product_aditional_images')
            ->where('grocery_product_id', $product_id)
            ->get();

        $product_record = DB::table('grocery_product')
            ->where('id', $product_id)
            ->get();

        return view('admin.grocery.product.additional_image.grocery_additional_image' , ['additional_image_record' => $additional_image_record, 'product_record' => $product_record]);
    }

     public function updateGroceryProductAdditionalImage(Request $request, $additional_image_id){
        $request->validate([
            'additional_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        try {
            $additional_image_id = decrypt($additional_image_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $additional_image_record = DB::table('grocery_product_aditional_images')
            ->where('id', $additional_image_id)
            ->get();

        if ($request->hasFile('additional_image')) {
            $additional_image = $request->file('additional_image');
            $file   = time().'.'.$additional_image->getClientOriginalExtension();
         
            $destinationPath = public_path('assets/grocery/product/images');
            $img = Image::make($additional_image->getRealPath());
            $img->save($destinationPath.'/'.$file);

            File::delete(public_path('assets/grocery/product/images/'.$additional_image_record[0]->additional_image));
            DB::table('grocery_product_aditional_images')
                ->where('id', $additional_image_id)
                ->update([ 
                    'additional_image' => $file, 
                ]);
        }

        return redirect()->back();
    }


    
    
}

<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Response;
use App\Models\Product;
use App\Models\Categories\TopCategory;
use App\Models\Categories\SubCategory;
use App\Models\Categories\ThirdLevelCategory;
use App\Models\ProductStock;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function productList($slug, $type, $category_id)
    {
        //$type 1 = Top Category , 2 = Sub Category, 3 = Third Level
        $brand = [];
        $products = Product::where('status', 1)->where('deleted_at', NULL);
        if ($type == 1) {
            $cate_name = TopCategory::find($category_id);
            $label = $cate_name->top_cate_name;
            $brand = Brand::where('top_category_id', $category_id)->where('status', 1)->get();
            $products->where('top_category_id', $category_id);
        } elseif ($type == 2) {
            $cate_name = SubCategory::with('topCategory')->find($category_id);
            $label = $cate_name->TopCategory->top_cate_name;
            $brand = Brand::where('sub_category_id', $category_id)->where('status', 1)->get();
            $products->where('sub_category_id', $category_id);
        } else {
            $cate_name = ThirdLevelCategory::with(['topCategory', 'subCategory'])->find($category_id);
            $label = $cate_name->TopCategory->top_cate_name;
            $brand = Brand::where('sub_category_id', $cate_name->top_category_id)->where('status', 1)->get();
            $products->where('third_level_sub_category_id', $category_id);
        }
        $min_price = $products->min('price');
        $max_price = $products->max('price');
        $products = $products->orderBy('id', 'desc')->paginate(18);
        $top_category = DB::table('top_category')
            ->where('status', 1)
            ->get();

        $categories = [];
        foreach ($top_category as $key => $item) {

            $sub_categories = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get();

            if (!empty($sub_categories) && count($sub_categories) > 0) {

                foreach ($sub_categories as $keys => $items) {

                    $last_categories = DB::table('third_level_sub_category')
                        ->where('sub_category_id', $items->id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

                    $items->last_category = $last_categories;
                }
            }

            $categories[] = [
                'top_category_id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'sub_categories' => $sub_categories
            ];
        }
        $price_range = [
            'min' => $min_price,
            'max' => $max_price
        ];
        return view('web.product.product-list', compact('products', 'label', 'categories', 'brand', 'category_id', 'type', 'price_range'));
    }

    public function productDetail($slug, $product_id)
    {
        /** Product Details **/
        $product_detail = Product::where('id', $product_id)->where('status', 1)->where('deleted_at', NULL)->first();
        // if (empty($product_detail->price)) {
        //         $p_stock = DB::table('product_stock')
        //         ->where('product_id', $product_detail->id)
        //         ->where('status', 1)
        //         ->orderBy('price', 'ASC')
        //         ->first();

        //     $product_detail->price = $p_stock->price;
        //     $product_detail->discount = $p_stock->discount;
        // }

        /** Product Size Stock **/
        // $product_size_stock = DB::table('product_stock')
        //     ->where('product_stock.product_id', $product_id)
        //     ->where('product_stock.stock', '>', 0)
        //     ->where('product_stock.status', 1)
        //     ->get();
        /** Product Color **/
        // $product_color = DB::table('product_color_mapping')
        //     ->where('product_color_mapping.product_id', $product_id)
        //     ->where('product_color_mapping.status', 1)
        //     ->get();

        /** Product Slider Images **/
        // $product_slider_images = DB::table('product_additional_images')
        //     ->where('product_id', $product_id)
        //     ->get();
        $related_product = Product::where('status', 1)->where('id', '!=', $product_id)->where('deleted_at', NULL);
        if (!empty($product_detail->third_level_sub_category_id)) {
            $related_product->where('third_level_sub_category_id', $product_detail->third_level_sub_category_id);
        } elseif (!empty($product_detail->sub_category_id)) {
            $related_product->where('sub_category_id', $product_detail->sub_category_id);
        } elseif (!empty($product_detail->top_category_id)) {
            $related_product->where('top_category_id', $product_detail->top_category_id);
        }
        $related_product = $related_product->inRandomOrder()->get();

        return view('web.product.single-product', compact('product_detail', 'related_product'));
    }

    public function productSearch($keyword)
    {
        $keyword = ucfirst($keyword);
        $keyword = explode(" ", $keyword);

        $product_list = "";
        $products = DB::table('product')
            ->Where(function ($query) use ($keyword) {

                for ($i = 0; $i < count($keyword); $i++) {
                    $query->orWhere('product.product_name', 'like',  '%' . $keyword[$i] . '%');
                }
            });

        $products = $products
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->select('product.*')
            ->distinct('product.product_name')
            ->get();

        foreach ($products as $key => $value) {

            if (empty($value->price)) {

                $p_stock = DB::table('product_stock')
                    ->where('product_id', $value->id)
                    ->where('status', 1)
                    ->orderBy('price', 'ASC')
                    ->first();

                $value->price = $p_stock->price;
                $value->discount = $p_stock->discount;
            }
        }

        if (!empty($products)) {

            foreach ($products as $key => $item) {

                $url = asset('assets/product_images/' . $item->banner);

                if (!empty($item->discount)) {
                    $discount_amount = ($item->price * $item->discount) / 100;
                    $amount = ($item->price - $discount_amount);
                } else
                    $amount = $item->price;

                $product_list = $product_list . "<div class=\"row\"><span class=\"triup glyphicon glyphicon-triangle-top\"></span></div> <div class=\"row livesrc\"><div class=\"col-md-3\"><img src=\"" . $url . "\" width=\"100\"></div><div class=\"col-md-9\"><p style=\"font-weight: bold;\"><a href=\"" . route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) . "\">" . $item->product_name . "</a></p><p>₹" . $amount . "</p></div></div>";
            }
        }

        if (!empty($product_list))
            print $product_list;
        else {
            $product_list = "";

            print $product_list;
        }
    }

    public function productPriceCheck(Request $request)
    {
        $price_and_discount = 0;
        if (!empty($request->input('stock_id'))) {
            $p_stock = ProductStock::find($request->input('stock_id'));
            $price_and_discount = $p_stock->discount . "," . $p_stock->price;
        }

        print $price_and_discount;
    }

    public function priceFilter(Request $request)
    {
        $category_id = $request->input('category_id');
        $type = $request->input('type');
        $sorted_by = $request->input('sort');
        $sorted_by == NULL ? 1 : $sorted_by;
        $price_range = $request->input('price_range');
        $brand_ids = $request->input('brand');
        if (!empty($price_range)) {
            $price_range = explode(';', $price_range);
            $min = $price_range[0];
            $max = $price_range[1];
        }
        if ($type == 1) {
            $products = Product::where('status', 1)->where('deleted_at', NULL);
            if (isset($min, $max) && !empty($min) && !empty($max)) {
                $products = Product::whereBetween('price', [$min, $max]);
            }
            $cate_name = TopCategory::find($category_id);
            $label = $cate_name->top_cate_name;
            if(!empty($brand_ids)){
                $brands = Brand::whereIn('id', $brand_ids)->where('status', 1)->get();
            }
            $products->where('top_category_id', $category_id);
            if (isset($sorted_by) && !empty($sorted_by)) {
                if ($sorted_by == 1) {
                    $products->orderBy('product.id', 'DESC');
                }
                if ($sorted_by == 2) {
                    $products->orderBy('product.price', 'ASC');
                }
                if ($sorted_by == 3) {
                    $products->orderBy('product.price', 'DESC');
                }
            }
            if (!empty($brands) && count($brands) > 0) {
                $products->where(function ($q) use ($brands) {
                    $brand_count = true;
                    foreach ($brands as $brand) {
                        if (isset($brand) && !empty($brand)) {
                            if ($brand_count) {
                                $q->where('product.brand_id', $brand->id);
                                $brand_count = false;
                            } else {
                                $q->orWhere('product.brand_id', $brand->id);
                            }
                        }
                    }
                });
            }
        } elseif ($type == 2) {
            $products = Product::where('status', 1)->where('deleted_at', NULL);
            if (isset($min, $max) && !empty($min) && !empty($max)) {
                $products = Product::whereBetween('price', [$min, $max]);
            }
            $cate_name = SubCategory::with('topCategory')->find($category_id);
            $label = $cate_name->TopCategory->top_cate_name;
            if(!empty($brand_ids)){
                $brands = Brand::whereIn('id', $brand_ids)->where('status', 1)->get();
            }
            $products->where('sub_category_id', $category_id);
            if ($sorted_by == 1) {
                $products->orderBy('product.id', 'DESC');
            }
            if ($sorted_by == 2) {
                $products->orderBy('product.price', 'ASC');
            }
            if ($sorted_by == 3) {
                $products->orderBy('product.price', 'DESC');
            }
            if (!empty($brands) && count($brands) > 0) {
                $products->where(function ($q) use ($brands) {
                    $brand_count = true;
                    foreach ($brands as $brand) {
                        if (isset($brand) && !empty($brand)) {
                            if ($brand_count) {
                                $q->where('product.brand_id', $brand->id);
                                $brand_count = false;
                            } else {
                                $q->orWhere('product.brand_id', $brand->id);
                            }
                        }
                    }
                });
            }
        } else {
            $products = Product::where('status', 1)->where('deleted_at', NULL);
            if (isset($min, $max) && !empty($min) && !empty($max)) {
                $products = Product::whereBetween('price', [$min, $max]);
            }
            $cate_name = ThirdLevelCategory::with(['topCategory', 'subCategory'])->find($category_id);
            $label = $cate_name->TopCategory->top_cate_name;
            if(!empty($brand_ids)){
                $brands = Brand::whereIn('id', $brand_ids)->where('status', 1)->get();
            }
            $products->where('third_level_sub_category_id', $category_id);
            if ($sorted_by == 1) {
                $products->orderBy('product.id', 'DESC');
            }
            if ($sorted_by == 2) {
                $products->orderBy('product.price', 'ASC');
            }
            if ($sorted_by == 3) {
                $products->orderBy('product.price', 'DESC');
            }
            if (!empty($brands) && count($brands) > 0) {
                $products->where(function ($q) use ($brands) {
                    $brand_count = true;
                    foreach ($brands as $brand) {
                        if (isset($brand) && !empty($brand)) {
                            if ($brand_count) {
                                $q->where('product.brand_id', $brand->id);
                                $brand_count = false;
                            } else {
                                $q->orWhere('product.brand_id', $brand->id);
                            }
                        }
                    }
                });
            }
        }
        $products = $products->paginate(18);

        $top_category = TopCategory::where('status', 1)->get();

        $categories = [];
        foreach ($top_category as $key => $item) {

            $sub_categories = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get();

            if (!empty($sub_categories) && count($sub_categories) > 0) {

                foreach ($sub_categories as $keys => $items) {

                    $last_categories = DB::table('third_level_sub_category')
                        ->where('sub_category_id', $items->id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->get();

                    $items->last_category = $last_categories;
                }
            }

            $categories[] = [
                'top_category_id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'sub_categories' => $sub_categories,
            ];
        }

        return view('web.include.products', compact('products', 'categories', 'label'));
    }

    // public function sorting(Request $request){
    //     $brand = [];
    //     $sorted_by = $request->input('selected');
    //     $category_id = $request->input('category_id');
    //     $type = $request->input('type');
    //     $products = Product::where('status', 1)->where('deleted_at', NULL);
    //     if($type == 1){
    //         $cate_name = TopCategory::find($category_id);
    //         $label = $cate_name->top_cate_name;
    //         $brand = Brand::where('top_category_id',$category_id)->where('status',1)->get();
    //         $products->where('top_category_id',$category_id);
    //         if($sorted_by == 1){
    //             $products->orderBy('product.id', 'DESC');
    //         }
    //         if ($sorted_by == 2) {
    //             $products->orderBy('product.price', 'ASC');
    //         }
    //         if ($sorted_by == 3) {
    //             $products->orderBy('product.price', 'DESC');
    //         }
    //     }elseif($type == 2){
    //         $cate_name = SubCategory::with('topCategory')->find($category_id);
    //         $label = $cate_name->TopCategory->top_cate_name;
    //         $brand = Brand::where('sub_category_id',$category_id)->where('status',1)->get();
    //         $products->where('sub_category_id',$category_id);
    //         if($sorted_by == 1){
    //             $products->orderBy('product.id', 'DESC');
    //         }
    //         if ($sorted_by == 2) {
    //             $products->orderBy('product.price', 'ASC');
    //         }
    //         if ($sorted_by == 3) {
    //             $products->orderBy('product.price', 'DESC');
    //         }            
    //     }else{
    //         $cate_name = ThirdLevelCategory::with(['topCategory', 'subCategory'])->find($category_id);
    //         $label = $cate_name->TopCategory->top_cate_name;
    //         $brand = Brand::where('sub_category_id',$cate_name->top_category_id)->where('status',1)->get();
    //         $products->where('third_level_sub_category_id',$category_id);
    //         if($sorted_by == 1){
    //             $products->orderBy('product.id', 'DESC');
    //         }
    //         if ($sorted_by == 2) {
    //             $products->orderBy('product.price', 'ASC');
    //         }
    //         if ($sorted_by == 3) {
    //             $products->orderBy('product.price', 'DESC');
    //         }
    //     }
    //     $products = $products->paginate(18);

    //     $top_category = DB::table('top_category')
    //     ->where('status', 1)
    //     ->get();

    //     $categories = [];
    //     foreach ($top_category as $key => $item) {

    //         $sub_categories = DB::table('sub_category')
    //             ->where('top_category_id', $item->id)
    //             ->where('status', 1)
    //             ->orderBy('id', 'ASC')
    //             ->get();

    //         if(!empty($sub_categories) && count($sub_categories) > 0){

    //             foreach($sub_categories as $keys => $items){

    //                 $last_categories = DB::table('third_level_sub_category')
    //                     ->where('sub_category_id', $items->id)
    //                     ->where('status', 1)
    //                     ->orderBy('id', 'ASC')
    //                     ->get();

    //                 $items->last_category = $last_categories;
    //             }
    //         }

    //         $categories[] = [
    //             'top_category_id' => $item->id,
    //             'top_cate_name' => $item->top_cate_name,
    //             'sub_categories' => $sub_categories
    //         ];
    //     }

    //     return view('web.include.products', compact('products', 'categories', 'brand', 'label'));
    // }
}

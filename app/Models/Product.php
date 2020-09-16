<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [	
        'sku_id',
        'product_type',
        'product_name', 
        'slug',
        'top_category_id',
        'sub_category_id',
        'third_level_sub_category_id',
        'brand_id',
        'discount',
        'stock',
        'desc',
        'price',
        'banner',
        'size_chart',
        'status',
        'order_status'];

        public function productAdditionalImages()
        {
            return $this->hasMany('App\Models\ProductAdditionalImage', 'product_id', 'id');
        }

        public function productColorMapping()
        {
            return $this->hasMany('App\Models\ProductColorMapping', 'product_id', 'id');
        }

        public function productStock()
        {
            return $this->hasMany('App\Models\ProductStock', 'product_id', 'id');
        }
}

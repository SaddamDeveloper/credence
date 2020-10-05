<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stock';
    protected $fillable = [	
        'product_id',
        'size',
        'stock',
        'price',
        'discount',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
    public function color()
    {
        return $this->belongsTo('App\Models\ProductColorMapping', 'product_id', 'id');
    }
    public function image()
    {
        return $this->belongsTo('App\Models\ProductAdditionalImage', 'product_id', 'id');
    }
}

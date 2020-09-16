<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionalImage extends Model
{
    protected $table = 'product_additional_images';
    protected $fillable = ['product_id', 'additional_image'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColorMapping extends Model
{
    protected $table = 'product_color_mapping';
    protected $fillable = [	
        'product_id',
        'color',
        'color_code',
        'status'];

        public function product()
        {
            return $this->belongsTo('App\Models\Product', 'product_id', 'id');
        }
}

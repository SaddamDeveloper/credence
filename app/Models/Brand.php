<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $fillable = [
        'top_category_id',
        'sub_category_id',
        'brand_name',
        'status'
    ];

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'brand_id', 'id');
    }
}

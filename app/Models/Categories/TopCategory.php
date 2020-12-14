<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    protected $table = 'top_category';
    protected $fillable = [
        'top_cate_name',
        'tax',
        'slug',
        'status',
        'hasSubcategory'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'top_category_id', 'id');
    }

    public function subCategory()
    {
        return $this->hasMany('App\Models\Categories\SubCategory', 'top_category_id', 'id');
    }
}

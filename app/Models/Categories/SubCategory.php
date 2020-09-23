<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_category';
    protected $fillable = [
        'top_category_id',
        'sub_cat_name',
        'slug',
        'status',
        'hasSubcategory'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'sub_category_id', 'id');
    }

    public function thirdLevelCategories()
    {
        return $this->hasMany('App\Models\Categories\ThirdLevelCategory', 'sub_category_id', 'id');
    }

    public function topCategory()
    {
        return $this->belongsTo('App\Models\Categories\TopCategory', 'top_category_id', 'id');
    }
    
}

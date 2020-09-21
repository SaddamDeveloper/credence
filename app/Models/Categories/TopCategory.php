<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    protected $table = 'top_category';
    protected $fillable = [
        'top_cate_name',
        'slug',
        'status',
        'hasSubcategory'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'top_category_id', 'id');
    }
}

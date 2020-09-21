<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class ThirdLevelCategory extends Model
{
    protected $table = 'third_level_sub_category';
    protected $fillable = [
        'sub_category_id',
        'top_category_id',
        'third_level_sub_category_name',
        'slug',
        'status'
    ];
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'third_level_sub_category_id', 'id');
    }
}

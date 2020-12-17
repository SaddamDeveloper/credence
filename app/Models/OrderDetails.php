<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_detail';
    protected $fillable = ['order_id', 'charges_id','stock_id', 'price','product_id', 'discount', 'quantity'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
    public function stock()
    {
        return $this->belongsTo('App\Models\ProductStock', 'stock_id', 'id');
    }

    public function charges(){
        return $this->belongsTo('App\Models\Charges','charges_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    // public function color()
    // {
    //     return $this->belongsTo('App\Models\ProductColorMapping', 'foreign_key', 'other_key');
    // }
}

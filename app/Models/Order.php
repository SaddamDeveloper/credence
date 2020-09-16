<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['order_id', 'user_id', 'address_id', 'payment_id','payment_order_id', 'payment_signature', 'amount', 'cashondelivery', 'payment_status', 'order_status'];

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetails', 'order_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'foreign_key', 'other_key');
    }
}

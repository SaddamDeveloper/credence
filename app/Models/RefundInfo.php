<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundInfo extends Model
{
    protected $table='refund_infos';

    protected $fillable = ['user_id','order_id','amount','reason','ac_no','ac_name','ifsc','branch','status'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User\User','user_id','id');
    }
}

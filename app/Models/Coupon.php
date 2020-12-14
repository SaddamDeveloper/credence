<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table='coupons';
    protected $primarykey ='id';
    protected $fillable = [
        'code','status','discount','description'
    ];
}

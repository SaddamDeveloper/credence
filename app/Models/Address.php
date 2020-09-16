<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = [	
        'user_id',
        'name',
        'address',
        'city',
        'state',
        'pin_code',
        'email',
        'mobile_no'];

        public function user()
        {
            return $this->belongsTo('App\Models\User', 'address_id', 'id');
        }
}

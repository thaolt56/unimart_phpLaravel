<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{   
    protected $guarded = [];
    function product(){
        return $this->belongsTo('App\Product');
    }
}

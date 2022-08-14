<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'product_images', 'status', 'product_id', 
    ];
    function product(){
        return $this->belongsTo('App\Product','product_id');
    }
}

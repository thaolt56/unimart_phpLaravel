<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table ='products';
    use SoftDeletes;
    protected $fillable = [
        'name', 'thumbnail', 'slug', 'status', 'price', 'desc' ,
        'content','highlight','user_id', 'cat_id',
    ];

    function user(){
        return $this->belongsTo('App\Users','user_id');
    }
    function category(){
        return $this->belongsTo('App\Cat_product','cat_id');
    }
    function image_detail(){
        return $this->hasMany('App\Image','product_id');
    }
}

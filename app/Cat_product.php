<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat_product extends Model
{
    protected $table = 'category_product';
    protected $fillable = [
        'name', 'parent_id', 'slug',
    ];

    function productCatChild(){
        return $this->hasMany(Cat_product::class,'parent_id');
    }
    function productCatParent(){
        return $this->belongsTo(Cat_product::class,'parent_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permission extends Model
{   
    protected $guarded = [];
    function permission_child(){
        return $this->hasMany(permission::class,'parent_id');
    }
    
}

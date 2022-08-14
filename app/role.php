<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class role extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','display_name'];

    
    function permission(){
        return $this->belongsToMany('App\permission','permission_roles','role_id','permission_id');
    }
}

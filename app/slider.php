<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class slider extends Model
{   
    use SoftDeletes;
    protected $fillable=[
        'slider_path','status','user_id'
    ];
    public function user(){
        return  $this->belongsTo('App\User','user_id');
     }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class post extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'title', 'content', 'cat_id', 'status', 'user_id', 'slug' ,'thumbnail',
    ];

    protected $table='posts';//khai bao model
   public function user(){
       return  $this->belongsTo('App\User','user_id');
    }
    public function category_post(){
       return  $this->belongsTo('App\category_post','cat_id');
    }
}

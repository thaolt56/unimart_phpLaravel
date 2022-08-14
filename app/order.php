<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class order extends Model
{
   protected $guarded = [];
   use SoftDeletes;
   function customer(){
      return $this->belongsTo('App\customer','customer_id');
   }
}

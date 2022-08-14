<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{   
    protected $table='pages';//khai bao model
    use SoftDeletes;
    protected $fillable = [
        'title', 'content','creator','editor'
    ];

}

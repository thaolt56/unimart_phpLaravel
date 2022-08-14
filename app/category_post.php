<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_post extends Model
{
    protected $table='category_posts';//khai bao model

    protected $fillable = [
        'name', 'parent_id', 'slug',
    ];
}

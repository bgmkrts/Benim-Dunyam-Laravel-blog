<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   function articleCount()
{
    return $this->hasMany(Article::class,'category_id','id')->count();
}


}



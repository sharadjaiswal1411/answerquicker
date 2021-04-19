<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;


    public function categories(){

    	return $this->hasMany('App\Models\Category');
    }

    public function featuredCategories(){

    	return $this->hasMany('App\Models\Category')->where('featured','=',1);
    }
}

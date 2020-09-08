<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    public function category(){
        return $this->belongsTo('App\Models\Category', 'category');
    }

    public function app_users(){
        return $this->belongsToMany('App\Models\AppUser')->using('App\Models\Like');
    }
}

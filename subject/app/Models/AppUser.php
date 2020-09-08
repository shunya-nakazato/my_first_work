<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    //
    public function articles(){
        return $this->belongsToMany('App\Models\Article')->using('App\Models\Like');
    }
}

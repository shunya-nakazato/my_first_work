<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLike;

class UserLikeController extends Controller
{
    //
    public function index(Request $request){
        $user_like = new UserLike();
        $user_like->app_user_id = $request->app_user_id;
        $user_like->article_id = $request->article_id;
        $user_like->save();
    
        return [
            "result" => "ok",
            "user_like" => $user_like,
        ];
    }
}

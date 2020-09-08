<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    //
    public function index(Request $request){
        $like = new Like();
        $like->app_user_id = $request->app_user_id;
        $like->article_id = $request->article_id;
        $like->save();
 
         return [
             "result" => "ok",
             "like" => $like,
         ];
    }
    
    public function delete(Request $request){
        $like = Like::where('app_user_id', $request->login_id)->where('article_id', $request->id)->first();
        $like->delete();
 
         return [
             "result" => "ok",
         ];
    }
}

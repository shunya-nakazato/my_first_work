<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use App\Models\Category;
use App\Models\Like;
use App\Models\Article;

class AppUserController extends Controller
{
    //
   public function index(){
        $app_users = AppUser::get();
        
        // それぞれのユーザーのいいね数を配列にする
        $likes_count = [];
        foreach($app_users as $app_user){
            $likes_count[$app_user->id] = Like::where('app_user_id', '=', $app_user->id)->count();
        };

        return view('app_user.list', compact('app_users', 'likes_count'));
   }

   public function detail($id){
        $app_user = AppUser::where('id', '=', $id)->first();
        // いいねテーブルからユーザーがいいねした日でソートして、article_idを取得
        $articles_id = Like::orderByDesc('created_at')->where('app_user_id', $app_user->id)->select('article_id')->get();
        // いいねした記事を配列にする
        $like_articles = [];
        // いいねの数を配列にする
        $like_articles_count = Like::where('app_user_id', $app_user->id)->count();

        // 記事テーブルからいいねした記事を取得
        foreach($articles_id as $article_id){
            $like_articles[] = Article::where('id', $article_id->article_id)->first();
        };

        return view('app_user.detail', compact('app_user', 'like_articles', 'like_articles_count', 'like_articles'));
   }

    //    API
   public function register(Request $request){
    //    バリデーションとエラーメッセージの表示
        if(AppUser::where('email', $request->email)->first()){
            return [
                "result" => "ng",
                "error_message" => "このメールアドレスはすでに登録されています",
            ];
        }
        if(strlen($request->password) < 8){
            return [
                "result" => "ng",
                "error_message" => "パスワードは8文字以上で入力してください",
            ];
        }


        $app_user = new AppUser();
        $app_user->name = $request->name;
        $app_user->email = $request->email;
        $app_user->password = $request->password;
        $app_user->save();

        return [
            "result" => "ok",
            "app_user" => $app_user,
        ];
    }
   
   public function login(Request $request){
        $app_user = AppUser::where('email', '=', $request->email)->where('password', '=', $request->password)->first();

        // エラーメッセージの表示
        if($app_user){
            return [
                "result" => "ok",
                "app_user" => $app_user,
            ];
        }else{
            return [
                "result" => "ng",
                "error_message" => "メールアドレスまたはパスワードが間違っています",
            ];
        }
   }
}

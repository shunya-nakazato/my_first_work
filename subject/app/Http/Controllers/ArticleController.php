<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Like;

class ArticleController extends Controller
{
    //
    public function index(){
        $articles = Article::where('delete_flg', 'flase')->orderByDesc('created_at')->get();
        $categories = Category::get();
        
        // 記事ごとのいいね数を配列にする
        $likes_count = [];
        foreach($articles as $article){
            $likes_count[$article->id] = Like::where('article_id', '=', $article->id)->count();
        };

        // 記事のカテゴリーカラムをカテゴリー名に置き換える
        foreach($articles as $article){
            $category_id = $article->category;
            $category_name = Category::where('id', '=', $category_id)->first()->category_name;
            $article->category = $category_name;
        }
        
        return view('home', compact('articles', 'likes_count'));
    }

    public function create(){
        $categories = Category::where('delete_flg', 'flase')->get();

        return view('article.create', compact('categories'));
    }

    public function store(Request $request){
        // バリデーションとエラーメッセージ
        $validatedData = $request->validate([
            'title' => ['required', 'max:30'],
            'article_image' => ['required'],
            'category' => ['required'],
            'text' => ['required'],
        ]);

        // 画像ファイルを取得
        $image = $request->file('article_image');
        // 取得した画像ファイルをstorage/app/public/内にフォルダを作って保存
        $temp_path = $image->store('public/images');
        // 上のファイルを読み込む用のパスを作成(IPアドレス/admin/storage/...)
        $read_temp_path = str_replace('public/', 'storage/', $temp_path);
        
        $article = new Article();

        $article->title = $request->title;
        $article->image_path = $read_temp_path;
        $article->category = $request->category;
        $article->text = $request->text;

        $article->save();

        return redirect('/home');
    }

    public function detail($id){
        $article = Article::where('id', '=', $id)->where('delete_flg', 'flase')->first();
        $categories = Category::get();
        // いいね数を取得
        $like_count = Like::where('article_id', $article->id)->count();

        return view('article.detail', compact('article', 'categories', 'like_count'));
    }

    public function edit(Request $request){
        $validatedData = $request->validate([
            'title' => ['required', 'max:30'],
            'category' => ['required'],
            'text' => ['required'],
        ]);
        
        $article = Article::where('id', '=', $request->id)->where('delete_flg', 'flase')->first();

        // 画像の変更があったかを確認
        if($request->article_image){
            $image = $request->file('article_image');
            $temp_path = $image->store('public/images');
            $read_temp_path = str_replace('public/', 'storage/', $temp_path);
            $article->image_path = $read_temp_path;
        }
        
        $article->title = $request->title;
        $article->category = $request->category;
        $article->text = $request->text;

        $article->save();

        return redirect('/home');
    }

    public function delete(Request $request){
        $article = Article::where('id', $request->id)->where('delete_flg', 'flase')->first();
        $article->delete_flg = true;
        $article->save();

        return redirect('/home');
    }

    // API\    
    public function read(Request $request){
        $article = Article::where('id', '=', $request->id)->where('delete_flg', 'flase')->first();
        $category = Category::where('id', '=', $article->category)->first();
        $categories = Category::where('delete_flg', 'flase')->get();
        // ログインユーザーがいいねしているかを確認
        $like= Like::where('article_id', '=', $article->id)->where('app_user_id', '=', $request->login_id)->first();
        // 記事のいいね数を取得
        $likes_count = Like::where('article_id', $article->id)->count();

        $category_id = $article->category;
        $article->category = $category->category_name;

        return [
            "result" => "ok",
            "article" => $article,
            "category_id" => $category_id,
            "categories" => $categories,
            "like" => $like,
            "likes_count" => $likes_count
        ];
    }
    
    public function all_read($login_id){
        $articles = Article::where('delete_flg', 'flase')->orderByDesc('created_at')->get();
        $categories = Category::where('delete_flg', 'flase')->get();
        // カテゴリーごとの記事の配列を作る
        $articles_each_categories = [];
        $likes= [];

        // ログインユーザーがいいねをしているを判定するための配列
        foreach($articles as $article){
            $likes[$article->id] = Like::where('article_id', '=', $article->id)->where('app_user_id', '=', $login_id)->first();
        };

        // カテゴリーごとの最新記事を5個取得
        foreach($categories as $category){
            foreach($articles as $article){
                if(count($articles_each_categories) < 6){
                    if($category->id == $article->category){
                        $articles_each_categories[$category->id][] = $article;
                    }
                }
            }
        }

        return [
            "result" => "ok",
            "articles" => $articles,
            "categories" => $categories,
            "articles_each_categories" => $articles_each_categories,
            "likes" => $likes
        ];
    }

    public function category_read(Request $request){
        $articles = Article::where('category', '=', $request->id)->where('delete_flg', 'flase')->orderByDesc('created_at')->get();
        $categories = Category::where('delete_flg', 'flase')->get();
        $likes= [];

        // ログインユーザーがいいねをしているを判定するための配列
        foreach($articles as $article){
            $likes[$article->id] = Like::where('article_id', '=', $article->id)->where('app_user_id', '=', $request->login_id)->first();
        };

        return [
            "result" => "ok",
            "articles" => $articles,
            "categories" => $categories,
            "likes" => $likes
        ];
    }
}

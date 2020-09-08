<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::where('delete_flg', 'flase')->get();

        return view('category.list', compact('categories'));
    }

    public function store(Request $request){
        // 記事の新規作成ページでカテゴリーを追加した場合に、新記事の入力内容を保存
        $session_article_title = $request->session_article_title;
        $session_article_text = $request->session_article_text;
        $request->session()->put([
            'session_article_title' => $session_article_title,
            'session_article_text' => $session_article_text,
        ]);

        $validatedData = $request->validate([
            'category_name' => ['required', 'unique:categories', 'max:10'],
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();

        
        return back();
    }

    public function edit(Request $request){
        $validatedData = $request->validate([
            'category_name' => ['required', 'unique:categories', 'max:10'],
        ]);

        $category = Category::where('id', $request->id)->where('delete_flg', 'flase')->first();
        $category->category_name = $request->category_name;
        $category->save();

        return redirect('/category');
    }

    public function delete(Request $request){
        $category = Category::where('id', $request->id)->where('delete_flg', 'flase')->first();
        $category->delete_flg = true;
        $category->save();

        return redirect('/category');
    }
}

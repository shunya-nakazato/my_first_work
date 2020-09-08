@extends('layouts.app')

@section('title', 'ホーム')

@section('content')

@include('article.create_style')
<div class="container">
    <form action="{{ route('article_store') }}" method='POST' enctype="multipart/form-data">
         @csrf
        <!-- タイトル -->
        <div class="form-group">
            <label for="article-title">タイトル</label>
            @if(session('session_article_title'))<!-- 記入内容を保持する -->
                <input type="text" class="form-control" id="article-title" name="title" aria-describedby="article-title-help" value="{{ session()->pull('session_article_title', 'default') }}">
            @else
                <input type="text" class="form-control" id="article-title" name="title" aria-describedby="article-title-help">
            @endif
            <small id="article-title-help" class="form-text text-muted">最大25文字</small>
            @error('title')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>
        <!-- 写真 -->
        <div class="user-icon-dnd-wrapper form-group">
            <input type="file" name="article_image" id="input_file" accept="image/*">
            <div id="preview_field"></div>
            <div id="drop_area"><p id="drag_and_drop">+画像をドロップ、または選択してください</p></div>
            <div id="image_clear_button"><span class="material-icons" style="font-size: 40px;">cancel_presentation</span></div>
        </div>
            @error('article_image')
                <small class="error-message">{{ $message }}</small>
            @enderror
        <!-- カテゴリ選択 -->
        <div class="form-group" id="category">
            <label for="article-category">カテゴリを選択</label>
            <select multiple class="form-control" id="article-category" name="category">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
            </select>
            @error('category')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>
        <!-- カテゴリー追加フォーム -->
        <input name="category_name" form="create-category" placeholder="カテゴリーを追加" style="background-color: #fff; border: 1px solid #ced4da; border-radius: 0.25rem; height: 37.4px; margin-right: 10px; width: 300px;">
        <input class="btn btn-secondary" type="submit" value="追加" form="create-category"><!-- form内で別のformを置く場合は、form本体は外に置き、input submitでformを指定 -->
        <br>
        @error('category_name')
            <small class="error-message">{{ $message }}</small>
        @enderror
        <!-- 本文 -->
        <div class="form-group">
            <label for="article-text">本文</label>
            @if(session('session_article_text'))
                <textarea class="form-control" id="article-text" name="text" rows="10">{{ session()->pull('session_article_text', 'default') }}</textarea>
            @else
                <textarea class="form-control" id="article-text" name="text" rows="10"></textarea>
            @endif
            @error('text')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>
        <!-- 送信ボタン -->
        <button type="submit" class="btn btn-primary" style="width: 98px">作成</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">キャンセル</a>
    </form>
    <!-- 新しいカテゴリ作成のためのフォーム -->
    <form id="create-category" action="{{ route('category_store') }}" method='POST'>
        @csrf
        <input type="hidden" id="session-article-title" name="session_article_title">
        <input type="hidden" id="session-article-text" name="session_article_text">
    </form>
</div>
@include('article.create_script')
@endsection

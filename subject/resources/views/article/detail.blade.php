@extends('layouts.app')

@section('title', 'ホーム')

@section('content')

@include('article.detail_style')
<div class="container">
    <form action="{{ route('article_edit') }}" method='POST' enctype="multipart/form-data"><!-- 画像を送信する場合は、enctypeを指定 -->
         @csrf
        <input type="hidden" name="id" value="{{ $article->id }}">
        <div class="row">
            <div class="col">
                <p>ID：{{ $article->id }} &ensp; 作成日時：{{ $article->created_at}} &ensp; 更新日時：{{ $article->updated_at}}</p>
                <!-- ハートのアイコン -->
                <p style="color: #F54EA2"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/></svg> &thinsp; {{ $like_count }}</p>
            </div>
        </div>
        <!-- 送信ボタン -->
        <div class="row justify-content-end">
            <button type="submit" class="btn btn-primary" style="width: 98px; margin-right: 10px;">更新</button>
            <button id="delete-btn" type="button" class="btn btn-danger" style="width: 98px; margin-right: 10px;">削除</button>
            <a href="{{ route('home') }}" class="btn btn-secondary" style='margin-right: 16px;'>キャンセル</a>
        </div>
        <!-- タイトル -->
        <div class="form-group">
            <label for="article-title">タイトル</label>
            <input type="text" class="form-control" id="article-title" name="title" aria-describedby="article-title-help" value='{{ $article->title }}'>
            <small id="article-title-help" class="form-text text-muted">最大25文字</small>
            @error('title')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>
        <!-- 写真 -->
        <div class="user-icon-dnd-wrapper form-group">
            <input type="file" name="article_image" id="input_file" accept="image/*" value="">
            <div id="preview_field">
                <!-- 画像のパスを指定 -->
                @php
                    $image_path ="/admin/".$article->image_path
                @endphp
                <img src='{{ $image_path }}' class='image'>
            </div>
            <div id="drop_area"><p id="drag_and_drop">+画像をドロップ、または選択してください</p></div>
            <div id="image_clear_button"><span class="material-icons" style="font-size: 40px;">cancel_presentation</span></div>
        </div>
        <!-- カテゴリ選択 -->
        <div class="form-group" id="category">
            <label for="article-category">カテゴリを選択</label>
            <select multiple class="form-control" id="article-category" name="category">
            @foreach($categories as $category)
                @if($category->id == $article->category)
                    <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                @else
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endif
            @endforeach
            </select>
            @error('category')
                <small class="error-message">{{ $message }}</small>
             @enderror
        </div>
        <!-- 本文 -->
        <div class="form-group">
            <label for="article-text">本文</label>
            <textarea class="form-control" id="article-text" name="text" rows="10">{{ $article->text }}</textarea>
            @error('text')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>
    </form>
    <!-- 削除用のフォーム -->
    <form id="article-delete" action="{{ route('article_delete') }}" method="post">
        @csrf
        <!-- クエリパラメータは使わずにidを送信する方法 -->
        <input type="hidden" name="id" value="{{ $article->id }}">
    </form>
</div>
<script>
    $('#delete-btn').click(function(){
        // アラートを出す
        var result = window.confirm("{{ $article->title }}を削除しますか？");
        if(result){
            // 削除のフォームを実行
            $('#article-delete').submit();
        }
    })
</script>
@include('article.detail_script')
@endsection

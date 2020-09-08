@extends('layouts.app')

@section('title', 'ユーザー管理')

@section('content')
<style>    
    .hover:hover {
        cursor: pointer;
        background-color: #dee2e6;
    }
</style>
<div class="container">
    <div class="row" style="padding-top: 20px; clear: right;">
        <table class="table">
            <thead>
                <tr class="d-flex">
                    <th class="col">ID</th>
                    <th class="col">名前</th>
                    <th class="col">メールアドレス</th>
                    <th class="col">お気に入り数</th>
                    <th class="col">更新日時</th>
                    <th class="col">作成日時</th>
                </tr>
            </thead>
            <tbody>
                <tr id="{{ $app_user->id }}" class="d-flex">
                    <th class="col">{{ $app_user->id }}</th>
                    <td class="col">{{ $app_user->name }}</td>
                    <td class="col">{{ $app_user->email }}</td>
                    <td class="col">{{ $like_articles_count }}</td>
                    <td class="col">{{ $app_user->updated_at }}</td>
                    <td class="col">{{ $app_user->created_at}}</td>
                </tr>
            </tbody>
        </table>
        <div class="container">
            <p>お気に入り記事一覧</p>
            @if($like_articles != null)
                <hr style="margin: 0;">
                @foreach($like_articles as $like_article)
                    <div class="row justify-content-center {{ $like_article->id }} hover" style="padding: 16px;">
                        <div class="col" style="font-weight: bold; color: #2470a0">
                            {{ $like_article->title}}
                        </div>
                    </div>
                    <hr style="margin: 0;">
                @endforeach
            @else
                <P>お気に入り記事はありません</P>
            @endif
        </div>
    </div>
</div>
<script>
    @foreach($like_articles as $like_article)
        $('.{{ $like_article->id }}').click(function(){
            $id = {{ $like_article->id }};
            window.location.href = "/admin/article/detail/" + $id;
        })
    @endforeach
</script>

@endsection
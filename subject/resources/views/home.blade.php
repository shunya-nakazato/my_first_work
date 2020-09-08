@extends('layouts.app')

@section('title', 'ホーム')

<style>
    #article-create-btn {
        background-color: white;
        border-color: #2176bd;
        color: #2176bd;
    }

    #article-create-btn:hover {
        background-color: #2176bd;
        border-color: #2176bd;
        color: white;
    }

    .image-trim {
        width: 70%;
        position: relative;
    }
    
    .image-trim::before {
        content: "";
        display: block;
        padding-top: 75%;
    }
</style>

@section('content')
<div class="container">
    <a href="{{ route('article_create') }}" class="btn btn-primary btn-lg active btn-block" id="article-create-btn" role="button" aria-pressed="true">新規作成</a>
    <div class="row" style="padding-top: 20px; clear: right;">
        <table class="table table-hover">
            <thead>
                <tr class="d-flex">
                    <th class="col">ID</th>
                    <th class="col">サムネイル</th>
                    <th class="col">タイトル</th>
                    <th class="col">お気に入り数</th>
                    <th class="col">更新日時</th>
                    <th class="col">作成日時</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr id="{{ $article->id }}" class="d-flex" onMouseOver="this.style.cursor = 'pointer'">
                        <th class="col">{{ $article->id }}</th>
                        <td class="col">
                            <div class="image-trim">
                                <img src="{{ $article->image_path }}" class="card-img-top" style="width: 100%; height: 100%; position: absolute; top: 0; object-fit: cover;">
                            </div>
                        </td>
                        <td class="col" style="font-weight: bold; color: #2470a0">{{ $article->title }}</td>
                        <td class="col">{{ $likes_count[$article->id] }}</td>
                        <td class="col">{{ $article->updated_at }}</td>
                        <td class="col">{{ $article->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    @foreach($articles as $article)
        $('#{{ $article->id }}').click(function(){
            $id = {{ $article->id }};
            window.location.href = "./article/detail/" + $id;
        })
    @endforeach
</script>

@endsection
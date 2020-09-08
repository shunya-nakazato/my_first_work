@extends('layouts.app')

@section('title', 'カテゴリー管理')

@section('content')
<style>
    .btn {
        padding: 3px 6px;
        font-size: 0.75rem;
    }

    input:focus{
        outline: none;
    }

    .error-message {
        color: red;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        @error('category_name')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>
    <div class="row justify-content-end">
        <form action="{{ route('category_store') }}" method='POST'>
            @csrf
            <input name="category_name" style="background-color: #fff; border: 1px solid #ced4da; border-radius: 0.25rem; height: 30px; margin-right: 10px; margin-top: 30px; width: 300px;" placeholder="カテゴリーを追加">
            <input class="btn btn-primary" type="submit" value="追加">
        </form>
    </div>
    <div class="row" style="padding-top: 20px; clear: right;">
        <table class="table">
            <thead>
                <tr class="d-flex">
                    <th class="col">ID</th>
                    <th class="col">カテゴリ名</th>
                    <th class="col">更新日時</th>
                    <th class="col">作成日時</th>
                    <th class="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr id="{{ $category->id }}" class="d-flex" onMouseOver="this.style.cursor = 'pointer'">
                        <th class="col">{{ $category->id }}</th>
                        <td class="col">
                            <form id="category-edit" action="{{ route('category_edit') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <input id="update-btn" type="text" name="category_name" value="{{ $category->category_name}}" style="width: 80%; background-color: #fff; border: none; box-shadow: 0 0 10px 0 rgba(0,0,0,0.15);">
                        </td>
                        <td class="col">{{ $category->updated_at }}</td>
                        <td class="col">{{ $category->created_at}}</td>
                        <td class="col">
                            <button type="submit" class="btn btn-primary" form="category-edit">更新</button>
                            <button type="button" class="btn btn-dark {{ $category->id }}-delete-btn">削除</button>
                        </td>
                    </tr>
                    <form id="category-delete-{{ $category->id }}" action="{{ route('category_delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                    </form>
                    <script>
                        $('.{{ $category->id }}-delete-btn').click(function(){
                            // アラート
                            var result = window.confirm('{{ $category->category_name }}' +"を削除しますか？");
                            if(result){
                                // 削除のフォームを実行
                                $('#category-delete-{{ $category->id }}').submit();
                            }
                        })
                    </script>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    @foreach($categories as $category)
    @endforeach
</script>
@endsection
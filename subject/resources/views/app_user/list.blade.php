@extends('layouts.app')

@section('title', 'ユーザー管理')

@section('content')
<div class="container">
    <div class="row" style="padding-top: 20px; clear: right;">
        <table class="table table-hover">
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
                @foreach($app_users as $app_user)
                    <tr id="{{ $app_user->id }}" class="d-flex" onMouseOver="this.style.cursor = 'pointer'">
                        <th class="col">{{ $app_user->id }}</th>
                        <td class="col">{{ $app_user->name }}</td>
                        <td class="col">{{ $app_user->email }}</td>
                        <td class="col">{{ $likes_count[$app_user->id] }}</td>
                        <td class="col">{{ $app_user->updated_at }}</td>
                        <td class="col">{{ $app_user->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    @foreach($app_users as $app_user)
        $('#{{ $app_user->id }}').click(function(){
            $id = {{ $app_user->id }};
            console.log($id);
            window.location.href = "./detail/" + $id;
        })
    @endforeach
</script>

@endsection
@extends('layouts.app')

@section('title', '画像テスト')

@section('content')
        <img src="{{ asset($image_data['read_temp_path']) }}" style="width:500px; height: auto;">

@endsection
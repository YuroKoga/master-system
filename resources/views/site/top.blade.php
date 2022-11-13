@extends('layouts.new-master')

{{-- ページ内容 --}}
@section('content')
    <!-- トップ画面の画像 -->
    <div class="jumbotron"
        style="background: url({{ asset('img/top-sumbnail/takoyaki.jpg') }}) center no-repeat; background-size: cover;">
        <div class="container">
            <h1 class="h1 text-white">観光支援システム</h1>
            <p class="text-white mb-4">バーチャル空間の都市内を周遊して，観光の下見ができるシステムです．</p>
            <a href="virtual-walking" class="btn btn-lg btn-primary mb-2">バーチャル街歩き &raquo</a><br>
            <a href="making-plan" class="btn btn-lg btn-primary mb-2">旅程管理をする &raquo</a><br>
            <a href="making-log" class="btn btn-lg btn-primary mb-2">観光記録を作成する &raquo</a><br>
        </div>
    </div>
@endsection

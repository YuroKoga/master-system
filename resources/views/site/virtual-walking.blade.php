@extends('layouts.new-master')

{{-- ページ内容 --}}
@section('content')
    <!-- トップ画面の画像 -->
    <div class="jumbotron mb-4"
        style="background: url({{ asset('img/top-sumbnail/takoyaki.jpg') }}) center no-repeat; background-size: cover;">
        <div class="container">
            <h1 class="h1 text-white">バーチャル街歩き</h1>
            <p class="text-white">バーチャル空間の都市内を周遊して，観光の下見ができるシステムです．</p>

        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <div class="card shadow m-0 mb-lg-4">
                <div class="card-body">
                    <div class="align-items-center">
                        {{-- プランメモ --}}
                        <p class="text-gray-800">
                            各観光プラン・観光記録から機能を利用することができます。
                        </p>
                        <a href="{{ route('user.mypage') }}" class="btn btn-primary mr-2 mb-2">マイページ &raquo</a>
                        <p class="text-gray-800">
                            【利用方法】<br>
                            マイページ &raquo 今後の旅程 &raquo 作成したプランの詳細ボタン &raquo ”3Dマップ”タブ
                        </p>
                        <a href="{{ route('sharing-log') }}" class="btn btn-primary mb-2">観光記録リスト &raquo</a>
                        <p class="text-gray-800">
                            【利用方法】<br>
                            観光記録リスト &raquo 観光記録の詳細ボタン &raquo ”3Dマップ”タブ
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

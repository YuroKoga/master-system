@extends('layouts.new-master')
@section('page_title')
    設定
@endsection
@section('script')
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-2"></div>
        <!-- コンテンツ -->
        <div class="col-lg-8">
            <!-- Page Heading -->
            <div class="d-none d-md-flex px-md-4 align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">設定</h1>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- リスト -->
                    <ul class="list-group list-group-flush">
                        <!-- アイテム -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="row no-gutters align-items-center">
                                <i class="fas fa-bell fa-fw mr-2"></i>メールアドレスの変更（未実装）
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="row no-gutters align-items-center">
                                <i class="fas fa-bell fa-fw mr-2"></i>パスワードの変更（未実装）
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="row no-gutters align-items-center">
                                <i class="fas fa-bell fa-fw mr-2"></i>アカウントの削除（未実装）
                            </div>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    @endsection

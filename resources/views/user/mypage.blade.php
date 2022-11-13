@extends('layouts.new-master')
@section('page_title')
    マイページ
@endsection
@section('script')
@endsection

@section('content')
    <?php $user = Auth::user(); ?>
    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-2"></div>

        <!-- 作成した観光プラン一覧 -->
        <div class="col-lg-8">

            <!-- Page Heading -->
            <div class="d-none d-md-flex align-items-center justify-content-between mb-4">
                <img class="img-profile rounded-circle mr-4" style="height:50px;" src="../img/undraw_profile.svg">
                <!-- ユーザの名前 -->
                <h1 class="h3 mb-0 text-gray-800 mr-4">{{ $user->name }}</h1>
                <!-- 変更ボタン -->
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm mr-auto"><i
                        class="fas fa-pen fa-sm text-white-50"></i> ユーザ名の変更</a>
            </div>

            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <!-- ヘッダータブ -->
                    <ul class="nav nav-pills card-header-pills" id="mypageTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#pills-plan" id="pills-plan-tab" data-toggle="pill"
                                role="tab" aria-controls="pills-plan" aria-selected="true">今後の旅程</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pills-records" id="pills-records-tab" data-toggle="pill"
                                role="tab" aria-controls="pills-records" aria-selected="false">観光記録</a>
                        </li>
                    </ul>
                    <!-- 以上ヘッダータブ -->
                </div>
                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- タブの内容 -->
                    <div class="tab-content" id="pills-mypageContent" style="height: 100%;">

                        {{-- ///////////////
                            タブ - プラン
                        //////////////////// --}}
                        <div class="tab-pane fade show active" id="pills-plan" role="tabpanel"
                            aria-labelledby="pills-plan-tab" style="height: 100%;">

                            <!-- リスト -->
                            <ul class="list-group list-group-flush">

                                <!-- アイテム -->
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($plans as $plan)
                                    @if ($plan->user_id == Auth::user()->id && $plan->status == 1)
                                        <li href="#" class="list-group-item">
                                            <div class="row no-gutters align-items-center mb-2">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        created: {{ $plan->created_at }}</div>
                                                    <a class="row no-gutters align-items-center border-bottom"
                                                        style="text-decoration:none;">
                                                        <div class="col">
                                                            <div class="h5 font-weight-bold text-primary">
                                                                {{ $plan->title }}</div>
                                                        </div>
                                                    </a>
                                                    <a class="row my-2" style="text-decoration:none;">
                                                        <div class="col">
                                                            <span class="text-gray-600">{{ $plan->content }}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto mr-2">
                                                    <a href="/user/mypage/{{ $plan->plan_id }}"
                                                        class="btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                        <span class="text">詳細</span>
                                                    </a>
                                                </div>
                                                <div class="col-auto mr-2">
                                                    <a href="/making-log/plan={{ $plan->plan_id }}"
                                                        class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">観光記録を作成</span>
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="/user/mypage/delete-plan/{{ $plan->id }}"
                                                        class="btn btn-danger btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">削除</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        @php
                                            $count++;
                                        @endphp
                                    @endif
                                @endforeach

                                {{-- もしプランが一つも登録されてなかったら --}}
                                @if ($count == 0)
                                    <p class="m-4">作成した観光プランがありません。<a
                                            href="{{ route('making-plan') }}">こちら</a>から観光記録を作成してください．
                                    </p>
                                @endif

                            </ul>
                        </div>
                        <!-- タブ - 観光記録 -->
                        <div class="tab-pane fade" id="pills-records" role="tabpanel" aria-labelledby="pills-records-tab"
                            style="height: 100%;">
                            <p class="m-4">観光記録がありません。<a href="{{ route('making-log') }}">こちら</a>から観光記録を作成してください．
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    @endsection

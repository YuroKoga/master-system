@extends('layouts.new-master')
@section('page_title')
    観光プランの詳細
@endsection

@section('script')
    {{-- -----------------------------------------------------
    // マップについての処理
    ----------------------------------------------------- --}}
    {{-- arcgis-2Dmapping.jsへ値の受け渡し --}}
    <script type="text/javascript">
        var spots = @json($spots);
        var categories = @json($categories);
        var plan = @json($plan);
        var plan_data = @json($plan_data);
    </script>

    {{-- spots, categories, plan, plan_data が必要 --}}
    <script src="{{ asset('js/site/arcgis-2Dmapping.js') }}"></script>

    {{-- -----------------------------------------------------
    ● ArcGIS for JavaScript に関する処理（2D大阪，3D大阪の表示）
    ----------------------------------------------------- --}}
    <script src="{{ asset('js/site/arcgis-3Dmapping.js') }}"></script>
@endsection

@section('content')
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb d-none d-md-flex">
            <li class="breadcrumb-item"><a href="{{ route('/') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.mypage') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                @foreach ($plan as $val)
                    {{ $val->title }}
                @endforeach
            </li>
        </ol>
    </nav>
    <div class="card shadow mb-0 mb-lg-4">
        <div class="card-body">
            <div class="align-items-center">

                {{-- 作成日時 --}}
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    @foreach ($plan as $val)
                        {{ $val->created_at }}
                    @endforeach
                </div>

                {{-- プランタイトル --}}
                <h1 class="h3 pb-1 text-primary border-bottom">
                    @foreach ($plan as $val)
                        {{ $val->title }}
                    @endforeach
                </h1>

                {{-- プランメモ --}}
                <span class="mb-0 text-gray-800">
                    @foreach ($plan as $val)
                        {{ $val->content }}
                    @endforeach
                </span>

            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- GISを表示するカード -->
        <div class="col-xl-9 col-lg-8">
            <div class="card shadow mb-md-4" style="height: 70vh;">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <!-- タブ -->
                    <ul class="nav nav-pills card-header-pills" id="mapTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="#pills-2Dmap" id="pills-2Dmap-tab" data-toggle="pill" role="tab"
                                aria-controls="pills-2Dmap" aria-selected="true">2Dマップ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#pills-3Dmap" id="pills-3Dmap-tab" data-toggle="pill"
                                role="tab" aria-controls="pills-3Dmap" aria-selected="false">3Dマップ</a>
                        </li>
                    </ul>
                    <!-- 以上タブ -->
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- タブの内容 -->
                    <div class="tab-content" id="pills-mapTabContent" style="height: 100%;">
                        <!-- 2Dマップタブ -->
                        <div class="tab-pane fade " id="pills-2Dmap" role="tabpanel" aria-labelledby="pills-2Dmap-tab"
                            style="height: 100%;">
                            <!-- 2Dマップ を表示する要素 -->
                            <div id="mapViewOsaka" class="h-100"></div>
                        </div>
                        <!-- 3Dマップタブ -->
                        <div class="tab-pane fade show active" id="pills-3Dmap" role="tabpanel"
                            aria-labelledby="pills-3Dmap-tab" style="height: 100%;">
                            <!-- 3Dマップ を表示する要素 -->
                            <div id='sceneViewOsaka' style="height: 100%;"></div>
                            <!-- Play Button -->
                            <div class="card bg-transparent h-50 py-0"
                                style="position:absolute; top:calc(100% - 120px); right:0;bottom:0;left:0;padding:1.25rem; border:none;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-2">
                                            <div class="row">
                                                {{-- Camera Reset Button --}}
                                                <div class="col text-center">
                                                    <div class="btn btn-secondary mx-auto text-center"
                                                        id="cameraResetButton">
                                                        <i class="fas fa-arrows-rotate fa-2x text-white w-100"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="row">
                                                {{-- backward Button --}}
                                                <div class="col-3 text-center">
                                                    <div class="btn btn-primary mx-auto text-center">
                                                        <i class="fas fa-backward fa-2x text-white w-100"></i>
                                                        <span
                                                            class="text-xs font-weight-bold text-wihte text-uppercase mb-1">
                                                            backward</span>
                                                    </div>
                                                </div>
                                                {{-- Play Button --}}
                                                <div class="col-3 text-center">
                                                    <div class="btn btn-primary mx-auto text-center" id="playButton">
                                                        <i class="fas fa-play fa-2x text-white w-100"></i>
                                                        <span
                                                            class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            play</span>
                                                    </div>
                                                </div>
                                                {{-- fast Button --}}
                                                <div class="col-3 text-center">
                                                    <div class="btn btn-primary mx-auto text-center">
                                                        <i class="fas fa-forward fa-2x text-white w-100"></i>
                                                        <span
                                                            class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            fast</span>
                                                    </div>
                                                </div>
                                                {{-- pause Button --}}
                                                <div class="col-3 text-center">
                                                    <div class="btn btn-primary mx-auto text-center">
                                                        <i class="fas fa-pause fa-2x text-white w-100"></i>
                                                        <span
                                                            class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                            pause</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-2">
                                            <div class="row">
                                                {{-- Sun Button --}}
                                                <div class="col text-center">
                                                    <div class="btn btn-secondary mx-auto text-center" id="sunButton">
                                                        <i class="fas fa-sun fa-2x text-white w-100"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="col-xl-3 col-lg-4">
            <div class="row-auto">
                <div class="card shadow mb-4" style="height:60vh;">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="overflow-auto" style="height:100%;">
                            {{-- プランを順番に取り出す --}}
                            @foreach ($plan_data as $key => $data)
                                <!-- One Spot -->
                                <div class="mb-2">
                                    <div>{{ $data['time'] }}</div>
                                    <div class="card border-left-info py-2" style="border-color:0 0 0 blue;">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center mb-2">
                                                <div class="col mr-2">

                                                    <!-- カテゴリーの表示 -->
                                                    @foreach ($categories as $val)
                                                        @if ($val->id == $spots[$data['spot_id']]->category_id)
                                                            <div
                                                                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                {{ $val->name }}</div>
                                                        @endif
                                                    @endforeach

                                                    <!-- スポット名の表示 -->
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $spots[$data['spot_id']]->name }}
                                                    </div>

                                                </div>
                                                <!-- Icon -->
                                                <div class="col-auto">
                                                    <!-- 各カテゴリーのアイコンを表示 -->
                                                    {{--
                                                        | 2:名所・史跡
                                                        | 3:寺・神社
                                                        | 4:イルミネーション
                                                        | 5:テーマパーク
                                                        | 6:公園・植物園
                                                        | 7:温泉
                                                        | 8:祭り・イベント
                                                        | 9:美術館・博物館
                                                        | 10:自然・景勝地
                                                        | 11:花火
                                                        | 12:花見
                                                        | その他
                                                    --}}
                                                    <img class="img-fluid" style="width:2rem"
                                                        @switch($spots[$data['spot_id']]->category_id)
                                                        @case(2)
                                                        src="{{ asset('/img/map-pin/popular.svg') }}"
                                                        @break

                                                        @case(3)
                                                        src="{{ asset('../img/map-pin/temple.svg') }}"
                                                        @break

                                                        @case(4)
                                                        src="{{ asset('../img/map-pin/illumination.svg') }}"
                                                        @break

                                                        @case(5)
                                                        src="{{ asset('../img/map-pin/themepark.svg') }}"
                                                        @break

                                                        @case(6)
                                                        src="{{ asset('../img/map-pin/park.svg') }}"
                                                        @break

                                                        @case(7)
                                                        src="{{ asset('../img/map-pin/spa.svg') }}"
                                                        @break

                                                        @case(8)
                                                        src="{{ asset('../img/map-pin/event.svg') }}"
                                                        @break

                                                        @case(9)
                                                        src="{{ asset('../img/map-pin/museum.svg') }}"
                                                        @break

                                                        @case(10)
                                                        src="{{ asset('../img/map-pin/nature.svg') }}"
                                                        @break

                                                        @case(11)
                                                        src="{{ asset('../img/map-pin/firework.svg') }}"
                                                        @break

                                                        @case(12)
                                                        src="{{ asset('../img/map-pin/hanami.svg') }}"
                                                        @break

                                                        @default
                                                        src="{{ asset('../img/map-pin/other.svg') }}"
                                                    @endswitch
                                                        alt="...">

                                                </div>
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    {{ $data['note'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> スポット
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <!-- リセットボタン -->
                    <a href="/making-plan/reset" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">リセット</span>
                    </a>
                </div>
                <div class="col-6">
                    <!-- 保存ボタン -->
                    <a href="/making-plan/confirm" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">保存</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- 周辺のスポット -->
        <div class="col">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">周辺のスポット</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- スポットリスト -->
                    <ul class="list-group list-group-flush">
                        <!-- 繰り返し -->
                        <?php
                            $s = 'A';
                            for($i=1;$i<=2;$i++){ ?>
                        <!-- スポット -->
                        <li class="list-group-item">
                            <div class="row no-gutters align-items-center border-bottom">
                                <div class="col">
                                    <div class="text-s text-info text-uppercase">
                                        名所・史跡</div>
                                    <div class="h5 font-weight-bold text-primary">通天閣</div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-auto">
                                    <img class="img-fluid rounded mb-4" style="width: 25rem;"
                                        src="{{ asset('img/tutenkaku.jpg') }}" alt="...">
                                </div>
                                <div class="col">
                                    <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                        <li class="list-group-item">観光スポットB</li>
                        <li class="list-group-item">観光スポットC</li>
                        <li class="list-group-item">観光スポットD</li>
                        <li class="list-group-item">観光スポットE</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

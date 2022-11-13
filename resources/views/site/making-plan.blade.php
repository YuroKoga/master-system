@extends('layouts.new-master')
@section('page_title')
    観光プランの作成
@endsection

@section('script')
    {{-- -----------------------------------------------------
    // マップについての処理
    ----------------------------------------------------- --}}
    {{-- arcgis-2Dmapping.jsへ値の受け渡し --}}
    <script type="text/javascript">
        var mode = 0; //making:0
        var spots = @json($spots);
        var categories = @json($categories);
        var plan_data = @json($plan_data);
    </script>

    {{-- spots, categories, plan_data が必要 --}}
    <script src="{{ asset('js/site/arcgis-2Dmapping.js') }}"></script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-none d-md-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">観光プランの作成</h1>
        <a href="{{ route('spot.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> 新規スポットの追加</a>
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
                            <a class="nav-link active" href="#pills-2Dmap" id="pills-2Dmap-tab" data-toggle="pill"
                                role="tab" aria-controls="pills-2Dmap" aria-selected="true">2Dマップ</a>
                        </li>
                    </ul>
                    <!-- 以上タブ -->
                    <!-- ドロップダウン -->
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
                    <!-- 以上ドロップダウン -->
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- タブの内容 -->
                    <div class="tab-content" id="pills-mapTabContent" style="height: 100%;">
                        <div class="tab-pane fade show active" id="pills-2Dmap" role="tabpanel"
                            aria-labelledby="pills-2Dmap-tab" style="height: 100%;">
                            <!-- 2Dマップ を表示する要素 -->
                            <div id="viewMap" class="h-100"></div>
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
                            @if ($count == 0)
                                <div class="text">マップのアイコンをクリックして，スポットを登録してください。</div>
                            @endif
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
                                                        @if ($val->id == $data['spot']->category_id)
                                                            <div
                                                                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                {{ $val->name }}</div>
                                                        @endif
                                                    @endforeach

                                                    <!-- スポット名の表示 -->
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $data['spot']->name }}
                                                    </div>

                                                </div>
                                                <!-- Icon -->
                                                <div class="col-auto">
                                                    {{--
                                                        |
                                                        | ■ 各カテゴリーのアイコンを表示
                                                        |
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
                                                        |
                                                    --}}
                                                    @if ($data['spot']->category_id == 2)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/popular.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 3)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/temple.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 4)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/illumination.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 5)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/themepark.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 6)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/park.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 7)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/spa.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 8)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/event.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 9)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/museum.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 10)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/nature.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 11)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/firework.svg" alt="...">
                                                    @elseif ($data['spot']->category_id == 12)
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/hanami.svg" alt="...">
                                                    @else
                                                        <img class="img-fluid" style="width:2rem"
                                                            src="../img/map-pin/other.svg" alt="...">
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- スポットのメモの表示 --}}
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    {{ $data['note'] }}
                                                </div>
                                            </div>
                                            <div class="row no-gutters align-items-center">

                                                @if ($loop->index != 0)
                                                    <div class="col-auto">
                                                        {{-- 入れ替えボタン --}}
                                                        <form action="making-plan/change/{{ $key }}/"
                                                            method="post">
                                                            @csrf
                                                            <input type="submit" class="btn btn-info btn-dell mr-2"
                                                                value="上と入れ替え">
                                                        </form>
                                                    </div>
                                                @endif

                                                <div class="col-auto">
                                                    {{-- 削除ボタン --}}
                                                    <form action="making-plan/delete-spot/{{ $key }}/"
                                                        method="post">
                                                        @csrf
                                                        <input type="submit" class="btn btn-info btn-dell"
                                                            value="削除">
                                                    </form>
                                                </div>
                                                <div class="col"></div>
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
                @if ($count == 0)
                @else
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
                @endif
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
                                    <img class="img-fluid rounded mb-4" style="width: 25rem;" src="img/tutenkaku.jpg"
                                        alt="...">
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

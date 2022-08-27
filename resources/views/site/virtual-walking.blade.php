@extends('layouts.new-master')
@section('script')
    {{-- -----------------------------------------------------
     マップについての処理
    ----------------------------------------------------- --}}
    <script>
        console.log('script OK?');
        //機能の呼び出し
        require([
            "esri/Map",
            "esri/views/MapView"

        ], function(
            Map,
            MapView,
        ) {
            //ベース地図の呼び出し
            const map = new Map({
                basemap: "streets"
            });
            //表示範囲の指定
            const view = new MapView({
                container: "divMapView",
                map: map,
                center: [136.570, 36.479],
                zoom: 11
            });
        });
    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-none d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">バーチャル街歩き体験</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Scene View -->
        <div class="col-xl-9 col-lg-8 mh-100">
            <div class="card shadow mb-0">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Scene view</h6>
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
                <div class="card-body p-0">
                    <div class="chart-area" style="height: 70vh;">
                        <!-- View を表示する要素 -->
                        <div id="divMapView"></div>
                    </div>
                </div>
            </div>

            <!-- Play Button -->
            <div class="mb-4">
                <div class="card bg-Secondary shadow h-50 py-0">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto mx-auto text-center">
                                <i class="fas fa-backward fa-2x text-gray-600 w-100"></i>
                                <span class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    backward</span>
                            </div>
                            <div class="col-auto mx-auto text-center">
                                <i class="fas fa-play fa-2x text-gray-600 w-100"></i>
                                <span class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    play</span>
                            </div>
                            <div class="col-auto mx-auto text-center">
                                <i class="fas fa-forward fa-2x text-gray-600 w-100"></i>
                                <span class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    fast</span>
                            </div>
                            <div class="col-auto mx-auto text-center">
                                <i class="fas fa-pause fa-2x text-gray-600 w-100"></i>
                                <span class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    pause</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Timeline-->
        <div class="col-xl-3 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
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
                    <div class="overflow-auto">
                        <!-- 繰り返し -->
                        <?php for($i=1;$i<=10;$i++){ ?>
                        <!-- One Spot -->
                        <div class="mb-2">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                カテゴリ</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">ダミー</div>
                                        </div>
                                        <!-- Icon -->
                                        <div class="col-auto">
                                            <i class="fas fa-shop fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> 寺・神社
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> 名所・史跡
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> コンビニ
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

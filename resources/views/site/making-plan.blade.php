@extends('layouts.new-master')
@section('page_title')
    観光計画の作成
@endsection
@section('script')
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-none d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">観光計画の作成</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- GISを表示するカード -->
        <div class="col-xl-9 col-lg-8">
            <div class="card shadow mb-md-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <!-- タブ -->
                    <ul class="nav nav-pills card-header-pills" id="mapTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#pills-2Dmap" id="pills-2Dmap-tab" data-toggle="pill"
                                role="tab" aria-controls="pills-2Dmap" aria-selected="true">2Dマップ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pills-3Dmap" id="pills-3Dmap-tab" data-toggle="pill" role="tab"
                                aria-controls="pills-3Dmap" aria-selected="false">3Dマップ</a>
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
                    <div class="tab-content" id="pills-mapTabContent">
                        <div class="tab-pane fade show active" id="pills-2Dmap" role="tabpanel"
                            aria-labelledby="pills-2Dmap-tab">
                            <!-- 2Dマップ を表示する要素 -->
                            <div id="divMapView" style="height: 30rem;"></div>
                        </div>
                        <div class="tab-pane fade" id="pills-3Dmap" role="tabpanel" aria-labelledby="pills-3Dmap-tab">
                            <!-- 3Dマップ を表示する要素 -->
                            <div id='SceneOsaka' style="height: 30rem;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
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
                    <!-- 繰り返し -->
                    <?php for($i=1;$i<=3;$i++){ ?>
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
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
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
                                        カテゴリ</div>
                                    <div class="h5 font-weight-bold text-primary">観光スポット<?php echo $s++; ?></div>
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="col-auto">
                                    <img class="img-fluid rounded mb-4" style="width: 25rem;" src="img/dog.jpg"
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

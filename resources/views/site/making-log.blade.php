@extends('layouts.new-master')
@section('page_title')
    観光記録の作成
@endsection
@section('script')
    {{-- -----------------------------------------------------
    マップについての処理
    ----------------------------------------------------- --}}
    <script language="javascript" type="text/javascript">
        function loadLayers(layers) {
            const ddLayerList = document.getElementById("ddLayerList");
            layers.forEach(l => {
                let o = document.createElement("option");
                o.textContent = l.title;
                o.layer = l;
                ddLayerList.appendChild(o)
            });
        }

        require([
                "esri/WebMap",
                "esri/views/MapView",
                "esri/widgets/Search",
                "esri/widgets/ScaleBar",
                "esri/Graphic",
                "esri/tasks/RouteTask",
                "esri/tasks/support/RouteParameters",
                "esri/tasks/support/FeatureSet"
            ],
            (WebMap, MapView) => {
                const map = new WebMap({
                    "portalItem": {
                        "id": "93fde900d72a4d98aeb21826749bdfb2"
                    }
                });
                const view = new MapView({
                    "container": "divMapView",
                    "map": map
                })

                map.when(() => loadLayers(scene.layers))

            })
    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-none d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">観光記録の作成</h1>
        <a href="{{ route('spot.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> 新規スポットの追加</a>
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
                            <div class="col-auto mx-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto mx-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto mx-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto mx-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan -->
        <div class="col-xl-3 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
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
                    <div class="mt-4 text-center small" style="height: 70vh;">
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
@endsection

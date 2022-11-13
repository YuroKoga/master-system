@extends('layouts.new-master')
@section('page_title')
    確認
@endsection

@section('script')
    {{-- -----------------------------------------------------
    // マップについての処理
    ----------------------------------------------------- --}}
    <script>
        // 観光スポットの読み込み
        var spots = @json($spots);
        var categories = @json($categories);
        var plan_data = @json($plan_data);

        // マップの初期位置を設定
        var def_lng = 135.4983028;
        var def_lat = 34.7055051;
        var def_zoom = 13;

        // 以下過去のコード
        // // 中心座標を最後に選択したスポットにする
        // // (最初は調布駅)
        // var def_zoom = 13;
        // if (!planArray.length && !newSpotArray.length) {
        //     var def_lng = 139.5446124;
        //     var def_lat = 35.6518205;
        // } else if (!newSpotArray.length) {
        //     var def_lng = parseFloat(planArray[planArray.length - 1]['spot_lng']);
        //     var def_lat = parseFloat(planArray[planArray.length - 1]['spot_lat']);
        // } else {
        //     var def_lng = parseFloat(newSpotArray[0]['lng']);
        //     var def_lat = parseFloat(newSpotArray[0]['lat']);
        //     var def_zoom = parseInt(newSpotArray[0]['zoom']);
        // }

        require([
            // モジュールの読み込み
            "esri/Map",
            "esri/views/MapView",
            "esri/widgets/Search",
            "esri/widgets/ScaleBar",
            "esri/widgets/LayerList",
            "esri/Graphic",
            "esri/tasks/RouteTask",
            "esri/tasks/support/RouteParameters",
            "esri/tasks/support/FeatureSet"
        ], function(
            Map,
            MapView,
            Search,
            ScaleBar,
            LayerList,
            Graphic,
            RouteTask,
            RouteParameters,
            FeatureSet
        ) {
            // Map の作成
            const map = new Map({
                basemap: "topo", // "streets-navigation-vector"か"topo"が無難
            });

            // View の作成
            var view = new MapView({
                container: "viewMap", // View を表示する DOM ノードを参照
                map: map, // map オブジェクトを参照
                zoom: def_zoom,
                center: {
                    longitude: def_lng,
                    latitude: def_lat
                }
            });

            //ZOOMボタンの削除
            view.ui.empty("top-left");

            //----------
            //検索の追加
            //----------
            var searchWidget = new Search({
                view: view
            });
            view.ui.add(searchWidget, {
                position: "top-right",
                index: 2
            });

            //--------------
            //スケールの追加
            //--------------
            // const scalebar = new ScaleBar({
            //   view: view,
            //   unit: "dual"
            // });
            // view.ui.add(scalebar, "bottom-left");

            //------------
            //ルートの追加
            //------------

            // ArcGISのルート機能を使用するための処理
            var routeTask = new RouteTask({
                // url: "https://route.arcgis.com/arcgis/rest/services/World/Route/NAServer/Route_World"  // ログイン必要
                url: "https://utility.arcgis.com/usrsvcs/servers/cc6d0780de3b4863a26cb2cec0a77926/rest/services/World/Route/NAServer/Route_World" //ログイン不要（山本研究室のArcGISのプロキシ）
            });

            const travelModeObject = {
                "distanceAttributeName": "Kilometers",
                "impedanceAttributeName": "Kilometers",
                "simplificationToleranceUnits": "esriMeters",
                "uturnAtJunctions": "esriNFSBAllowBacktrack",
                "useHierarchy": false,
                "name": "",
                "simplificationTolerance": 2,
                "timeAttributeName": "WalkTime",
                "restrictionAttributeNames": ["Avoid Toll Roads", "Avoid Ferries"],
                "type": "WALK",
                "attributeParameterValues": [{}]
            };

            //-------------------------------
            // プランにあるルートの表示▽
            //-------------------------------
            for (let i = 0; i < plan_data.length; i++) {
                nowSpotId = parseInt(plan_data[i]['spot_id']);
                planLng = parseFloat(spots[nowSpotId]['longitude']); //スポットの緯度
                planLat = parseFloat(spots[nowSpotId]['latitude']); //スポットの経度
                view.graphics.add({
                    symbol: {
                        type: "simple-marker",
                        color: "green",
                        size: "20px",
                        outline: {
                            color: "white",
                            width: 1
                        }
                    },
                    geometry: {
                        type: "point",
                        longitude: planLng,
                        latitude: planLat
                    }
                })
                if (i > 0) {
                    getRoute();
                }
            }


            // ルートを取得する関数

            function getRoute() {
                // Setup the route parameters
                var routeParams = new RouteParameters({
                    stops: new FeatureSet({
                        features: view.graphics.toArray()
                    }),
                    returnDirections: true,
                    travelMode: travelModeObject
                });
                // Get the route
                routeTask.solve(routeParams).then(function(data) {
                    data.routeResults.forEach(function(result) {
                        result.route.symbol = {
                            type: "simple-line",
                            color: [5, 150, 255],
                            width: 3
                        };
                        view.graphics.add(result.route);
                        console.log(result.route);
                    });

                });
            }

            //--------------------------
            // プランにあるスポットを表示
            //--------------------------
            addPlanSpotGraphic();

            function addPlanSpotGraphic() {
                for (let i = 0; i < plan_data.length; i++) {
                    nowSpotID = plan_data[i]['spot_id'];
                    planSpotName = spots[nowSpotID]['name']; //スポットの名称
                    planSpotMemo = plan_data[i]['note']; //スポットの紹介文
                    planSpotLat = parseFloat(spots[nowSpotID]['latitude']); //スポットの経度
                    planSpotLng = parseFloat(spots[nowSpotID]['longitude']); //スポットの緯度

                    // 座標
                    var mapPoint = {
                        type: "point",
                        longitude: planSpotLng,
                        latitude: planSpotLat
                    };

                    // ポップアップ
                    var mapPopUp = {
                        title: planSpotName,
                        content: ""
                    };
                    // ポップアップにプランのスポットのメモを追加
                    if (planSpotMemo != null) {
                        mapPopUp.content = mapPopUp.content + "<p>" + planSpotMemo + "</p>";
                    }

                    // graphicを追加（最初のスポットだけ色が違う）
                    if (i == 0) {
                        addGraphic("start", mapPoint, mapPopUp);
                    } else {
                        addGraphic("next", mapPoint, mapPopUp);
                    }

                }
            }

            function addGraphic(type, point, popUp) {
                var graphic = new Graphic({
                    symbol: {
                        type: "simple-marker",
                        color: (type === "type1") ? "#EDED9D" : (type === "type2") ? "#93ED9E" : (type ===
                                "type3") ? "#B2C7ED" : (type === "type4") ? "#EDD29D" : (type === "type5") ?
                            "#EDB5A8" : (type === "type6") ? "#CAABED" : (type === "type7") ? "#9DEDD8" : (
                                type === "type8") ? "#F0D3DE" : (type === "type9") ? "#D9F5FD" : (type ===
                                "type10") ? "#A3F7CC" : (type === "type0") ? "#cccccc" : (type ===
                                "start") ? "white" : "red",
                        size: "20px",
                        outline: {
                            color: (type === "start") ? "red" : "white",
                            width: 1
                        }
                    },
                    geometry: point,
                    popupTemplate: popUp
                });
                view.graphics.add(graphic);
            }

        });
    </script>

    {{-- -----------------------------------------------------
    ● ArcGIS for JavaScript に関する処理（2D大阪，3D大阪の表示）
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
            "esri/WebScene",
            "esri/views/SceneView",
            "esri/widgets/LayerList",
            "esri/widgets/Search",
            "esri/widgets/ScaleBar",
            "esri/Graphic",
            "esri/tasks/RouteTask",
            "esri/tasks/support/RouteParameters",
            "esri/tasks/support/FeatureSet"
        ], function(WebMap, MapView, WebScene, SceneView, Search, LayerList) {
            // 2Dマップの構成
            const map = new WebMap({
                "portalItem": {
                    "id": "93fde900d72a4d98aeb21826749bdfb2" // 旧
                    // "id": "31a9714035f444c4a4ac3daf806c488d" // 新
                }
            });
            // 2Dマップのビューを作成
            const mapView = new MapView({
                "container": "divMapView",
                "map": map
            });
            // 3Dマップの構成
            const scene = new WebScene({
                "portalItem": {
                    "id": "58d1da6134a447f29029d5f9fc6a54c2"
                }
            });
            // 3Dマップのビューを作成
            const sceneView = new SceneView({
                "container": "SceneOsaka",
                "map": scene
            });
            // Layer Widget
            var layerList = new LayerList({
                view: view,
            })
            // Search
            // const searchWidget = new Search({
            //     "view": mapView
            // });
            // view.ui.add(searchWidget, {
            //     position: "top-left",
            //     index: 2
            // });
            map.when(() => loadLayers(scene.layers))
        });
    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">プランの登録</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- GISを表示するカード -->
        <div class="col-xl-9 col-lg-8">
            <div class="card shadow mb-md-4" style="height: 70vh;">
                <!-- Card Header - Dropdown -->
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">マップ</h6>
                    <!-- 以上タブ -->
                    <!-- ドロップダウン -->
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
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
                <div class="card shadow mb-4" style="height:45vh;">
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
            <!-- タイトルと説明の入力 -->
            <div class="row-auto">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="/making-plan/saving" id="plan_form">
                            <div class="mb-0">
                                <label class="form-label font-weight-bold text-primary">プランのタイトル</label>
                                <input from="plan_form" class="form-control" type="text" name="planTitle"
                                    aria-describedby="タイトル"><br>
                            </div>
                            <div class="mb-0">
                                <label class="form-label font-weight-bold text-primary">プランの説明</label>
                                <div class="area">
                                    <textarea from="plan_form" type="text" class="textarea form-control" id="planNote" name="planNote"
                                        placeholder="プランの説明" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <!-- リセットボタン -->
                                    <a href="/making-plan" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                        <span class="text">編集画面に戻る</span>
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <!-- 保存ボタン -->

                                    <button type="submit" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">登録する</span>
                                    </button>

                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

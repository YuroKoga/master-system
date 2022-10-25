{{-- ===============================================================
■：レイアウト new-master.blade.php
=============================================================== --}}

<?php

//htmlspecialcharsを省略する関数
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start(); //セッションスタート

//-----------------------------------------------------
//  〇：初めてこの画面に来たとき
//-----------------------------------------------------

// セッション配列に情報を格納
if (!isset($_SESSION['spot_plan'])) {
    //  観光プランを格納するセッション配列を生成
    $_SESSION['spot_plan'] = [];
    $_SESSION['order'] = 0;

    //  スポットの情報をセッション配列に格納
    $f = fopen('csv/spotlist_osaka.csv', 'r');
    $i = 0;
    while ($row = fgetcsv($f)) {
        $_SESSION['spot_array'][$i]['No'] = $row[0]; // No(スポット番号)を格納
        $_SESSION['spot_array'][$i]['name'] = $row[1]; // name(スポットの名称)を格納
        $_SESSION['spot_array'][$i]['spot_lat'] = $row[2]; // spot_lat(経度)を格納
        $_SESSION['spot_array'][$i]['spot_lng'] = $row[3]; // spot_lng(緯度)を格納
        // $_SESSION['spot_array'][$i]['category'] = $row[4]; // category(カテゴリー)を格納
        // $_SESSION['spot_array'][$i]['visible'] = $row[6]; // 表示するかどうかの値を格納
        $i++;
    }
    fclose($f);
}

//-----------------------------------------------------
//  〇：マップ表示
//  スポット情報をCSVファイルから取得し、JavaScriptへ渡す
//-----------------------------------------------------

$f = fopen('csv/spotlist_osaka.csv', 'r');
$i = 0;
while ($row = fgetcsv($f)) {
    $spot_array[$i]['No'] = $row[0]; //Noを取得
    $spot_array[$i]['name'] = $row[1]; //nameを取得
    $spot_array[$i]['spot_lat'] = $row[2]; //spot_lat(経度)を取得
    $spot_array[$i]['spot_lng'] = $row[3]; //spot_lng(緯度)を取得
    // $spot_array[$i]['category'] = $row[4]; //categoryを取得
    // $spot_array[$i]['visible'] = $row[6]; // 表示するかどうかの値を取得
    ++$i;
}
fclose($f);

//-----------------------------------------------------
//  JavaScriptにjson形式で渡す
//-----------------------------------------------------
$spot_array = json_encode($spot_array); // スポット情報
$plan_array = json_encode($_SESSION['spot_plan']); //プランの情報
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    {{-- ページタイトルをそれぞれのページに要求 --}}
    @component('components.header')
        @slot('page_title')
            @yield('page_title')
        @endslot
    @endcomponent

    {{-- 追加CSSがあれば取得 --}}
    @yield('additional_css')
    {{-- -----------------------------------------------------
    // マップについての処理
    ----------------------------------------------------- --}}
    <script>
        //-----------------------------------------------------
        // CSVファイルの読み込み
        //-----------------------------------------------------
        let spotArray = <?php echo $spot_array; ?>;
        let planArray = <?php echo $plan_array; ?>;

        // 中心座標を最後に選択したスポットにする
        // (最初は調布駅)
        var def_zoom = 13;
        if (!planArray.length && !newSpotArray.length) {
            var def_lng = 139.5446124;
            var def_lat = 35.6518205;
        } else if (!newSpotArray.length) {
            var def_lng = parseFloat(planArray[planArray.length - 1]['spot_lng']);
            var def_lat = parseFloat(planArray[planArray.length - 1]['spot_lat']);
        } else {
            var def_lng = parseFloat(newSpotArray[0]['lng']);
            var def_lat = parseFloat(newSpotArray[0]['lat']);
            var def_zoom = parseInt(newSpotArray[0]['zoom']);
        }

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
                basemap: "streets-navigation-vector", // "streets-navigation-vector"か"topo"が無難
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
                url: "https://utility.arcgis.com/usrsvcs/appservices/kY3BNFUNyPBeKKwi/rest/services/World/Route/NAServer/Route_World/solve" //ログイン不要（山本研究室のArcGISのプロキシ）
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
            // ルートの表示
            //-------------------------------
            for (let i = 0; i < planArray.length; i++) {
                planLng = parseFloat(planArray[i]['spot_lng']); //スポットの緯度
                planLat = parseFloat(planArray[i]['spot_lat']); //スポットの経度
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

            //-------------------------
            // 全スポットをマップに表示
            //-------------------------
            addAllSpotGraphic();

            function addAllSpotGraphic() {
                for (let i = spotArray.length - 1; i > 0; i--) {
                    spotNum = parseInt(spotArray[i]['No']); //スポット番号
                    spotName = spotArray[i]['name']; //スポットの名称
                    spotLat = parseFloat(spotArray[i]['spot_lat']); //スポットの経度
                    spotLng = parseFloat(spotArray[i]['spot_lng']); //スポットの緯度
                    spotCategory = spotArray[i]['category']; //スポットのカテゴリ
                    spotVisible = spotArray[i]['visible']; //スポットの表示

                    console.log(spotVisible);
                    if (spotVisible == "FALSE") {
                        continue;
                    }
                    // 座標
                    var mapPoint = {
                        type: "point",
                        longitude: spotLng,
                        latitude: spotLat
                    };

                    // ポップアップ
                    var mapPopUp = {
                        title: spotName + '<span class="spot_title_category">（' + spotCategory + '）</span>',
                        content: '<span id="pics"></span>' +
                            '<form  action="making_post.php" method="post" enctype="multipart/form-data">' +
                            '<label for="spot_image">画像: </label>' +
                            '<input type="file" id="spot_image" name="spot_image" accept="image/*" onchange="var fileReader=new FileReader();var file=event.target.files[0];fileReader.onload=function(){image=this.result;imagetag="<img src=" + image + " />";document.getElementById("pics").innerHTML=imagetag;};fileReader.readAsDataURL(file);"><br>' +
                            '<div class="area">' +
                            '<textarea type="text" class="textarea" id="spot_memo" name="spot_memo" placeholder="紹介文" autocomplete="off">' +
                            '</textarea></div><br>' +
                            '所要時間：<input type="number" class="times" name="hours">時間<input type="number" class="times" name="minutes">分' +
                            '<button name="spot" value="' + spotNum + '">このスポットを追加</button></form>'
                    };

                    // graphicを追加（カテゴリーごとに色が違う）
                    if (spotCategory === "名所・史跡") {
                        addGraphic("type1", mapPoint, mapPopUp);
                    } else if (spotCategory === "公園・植物園") {
                        addGraphic("type2", mapPoint, mapPopUp);
                    } else if (spotCategory === "公共施設") {
                        addGraphic("type3", mapPoint, mapPopUp);
                    } else if (spotCategory === "飲食店") {
                        addGraphic("type4", mapPoint, mapPopUp);
                    } else if (spotCategory === "寺・神社") {
                        addGraphic("type5", mapPoint, mapPopUp);
                    } else if (spotCategory === "美術館・博物館") {
                        addGraphic("type6", mapPoint, mapPopUp);
                    } else if (spotCategory === "温泉") {
                        addGraphic("type7", mapPoint, mapPopUp);
                    } else if (spotCategory === "花見") {
                        addGraphic("type8", mapPoint, mapPopUp);
                    } else if (spotCategory === "祭り・イベント") {
                        addGraphic("type9", mapPoint, mapPopUp);
                    } else if (spotCategory === "テーマパーク") {
                        addGraphic("type10", mapPoint, mapPopUp);
                    } else {
                        addGraphic("type0", mapPoint, mapPopUp);
                    }
                }
            }

            //--------------------------
            // プランにあるスポットを表示
            //--------------------------
            addPlanSpotGraphic();

            function addPlanSpotGraphic() {
                for (let i = 0; i < planArray.length; i++) {
                    planName = planArray[i]['spot_name']; //スポットの名称
                    planLng = parseFloat(planArray[i]['spot_lng']); //スポットの緯度
                    planLat = parseFloat(planArray[i]['spot_lat']); //スポットの経度
                    planCategory = planArray[i]['category']; //スポットのカテゴリー
                    planMemo = planArray[i]['memo']; //スポットの紹介文
                    planImg = planArray[i]['spot_image']; //スポットの画像
                    planHours = planArray[i]['hours']; //スポットの時間
                    planMinutes = planArray[i]['minutes']; //スポットの分

                    // 座標
                    var mapPoint = {
                        type: "point",
                        longitude: planLng,
                        latitude: planLat
                    };

                    // ポップアップ
                    var mapPopUp = {
                        title: planName + "<span class=\"spot_title_category\">（" + planCategory + "）</span>",
                        content: ""
                    };
                    if (planImg != null) {
                        mapPopUp.content = mapPopUp.content + "<img id=\"spot_image\" src=\"" + planImg +
                            "\"><br><br>";
                        console.log("planImg:" + planImg);
                    }
                    if (planMemo != "") {
                        mapPopUp.content = mapPopUp.content + "<p>" + planMemo + "</p>";
                        console.log("planMemo:" + planMemo);
                    }
                    if (planHours != "" || planMinutes != "") {
                        mapPopUp.content = mapPopUp.content + "<p>所要時間：";
                        if (planHours != "") {
                            mapPopUp.content = mapPopUp.content + planHours + "時間";
                            console.log("planHours:" + planHours);
                        }
                        if (planMinutes != "") {
                            mapPopUp.content = mapPopUp.content + planMinutes + "分";
                            console.log("planMinutes:" + planMinutes);
                        }
                        mapPopUp.content = mapPopUp.content + "</p>";
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
    // {{-- -----------------------------------------------------
    // ● ArcGIS for JavaScript に関する処理
    // ----------------------------------------------------- --}}
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
            const map = new WebMap({
                "portalItem": {
                    "id": "93fde900d72a4d98aeb21826749bdfb2"
                }
            });
            const mapView = new MapView({
                "container": "divMapView",
                "map": map
            });
            const scene = new WebScene({
                "portalItem": {
                    "id": "58d1da6134a447f29029d5f9fc6a54c2"
                }
            });
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
    @yield('script')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        {{-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="top">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-person-walking"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name', 'system') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="top">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>トップ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                function
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="sceneview" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>街歩き体験</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <p class="text-center mb-2"><strong>アンケート</strong>にご協力お願いします！</p>
                <a class="btn btn-success btn-sm" href="http://www.si.is.uec.ac.jp/yamamotohp/">アンケート</a>
            </div>

        </ul> --}}
        <!-- End of Sidebar -->



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-md-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topber - Brand -->
                    <a class="topbar-brand d-flex align-items-center justify-content-center" href="top">
                        <div class="sidebar-brand-icon d-none d-md-block">
                            <i class="fa-solid fa-person-walking"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3 d-none d-md-block">{{ config('app.name', 'system') }}</div>
                    </a>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="検索..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Pages Collapse Menu -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="virtual-walking">
                                <i class="fas fa-fw fa-person-walking"></i>
                                <span class="mr-2 d-none d-xl-inline text-gray-600 small">街歩き体験</span>
                            </a>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="making-plan">
                                <i class="fas fa-fw fa-pen-to-square"></i>
                                <span class="ml-1 mr-2 d-none d-xl-inline text-gray-600 small">旅程管理</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="making-log">
                                <i class="fas fa-fw fa-map-location-dot"></i>
                                <span class="ml-1 mr-2 d-none d-xl-inline text-gray-600 small"> 観光記録の作成</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" href="sharing-log">
                                <i class="fas fa-fw fa-handshake"></i>
                                <span class="ml-1 mr-2 d-none d-xl-inline text-gray-600 small"> 観光記録の共有</span>
                            </a>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to
                                            download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                    Alerts</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        @if (Route::has('login'))
                            <li class="nav-item dropdown no-arrow">
                                @auth
                                    <?php $user = Auth::user(); ?>
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $user->name }}</span>
                                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            プロフィール
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                            設定
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                            作成履歴
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            ログアウト
                                        </a>
                                    </div>
                                @else
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">未ログイン</span>
                                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                    </a>
                                    <!-- ドロップダウン -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            ログイン
                                        </a>
                                        @if (Route::has('register'))
                                            <a class="dropdown-item" href="{{ route('register') }}">
                                                <i class="fas fa-user-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                                新規利用登録
                                            </a>
                                        @endif
                                    </div>
                                @endauth
                            </li>
                        @endif
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid px-0 px-lg-4">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2022 山本佳世子研究室</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ログアウトしますか？</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">"ログアウト" を選択するとセッションを終了します.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">キャンセル</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">ログアウト</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>

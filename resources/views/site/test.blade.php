@extends('layouts.new-master')
@section('page_title')
    観光プランの作成
@endsection

@section('css')
@endsection

@section('script')
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
    <div class="d-none d-md-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">観光プランの作成</h1>
        <a href="{{ route('spot.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> 新規スポットの追加</a>
    </div>
@endsection

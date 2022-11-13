// 観光スポットの読み込み（外部から読み込みはできないため，ビュー側で記述）
// var spots = @json($spots);
// var categories = @json($categories);
// var plan = @json($plan);
// var plan_data = @json($plan_data);

// マップの初期位置を設定
var def_lng = 135.4983028;
var def_lat = 34.7055051;
var def_zoom = 17;

// 中心座標をプランに登録されたスポットにする
try {
    // plan が定義されている場合
    var def_lng = parseFloat(plan[0]['longitude']);
    var def_lat = parseFloat(plan[0]['latitude']);
    // var def_zoom = parseInt(plan[0]['zoom']);
} catch (e) {
}
try {
    if(mode == 0){
        var def_lng = 135.4983028;
        var def_lat = 34.7055051;
        var def_zoom = 14;
    }
} catch (e) {
}

// 過去のコード
// (最初は調布駅)
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
    try{
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
                    // view.graphics.add(result.route);
                    // console.log(result.route);
                });

            });
        }
    } catch (e) {}


    //-------------------------
    // 全スポットをマップに表示
    //-------------------------

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

    /*
    | - addAllSpotGraphic();
    | "spots"の長さだけforを回し，一つずつ打点する．
    */
    function addAllSpotGraphic() {
        for (let i = spots.length - 1; i > 0; i--) {
            spotNum = parseInt(spots[i]['id']); //スポット番号
            spotName = spots[i]['name']; //スポットの名称
            spotLat = parseFloat(spots[i]['latitude']); //スポットの経度
            spotLng = parseFloat(spots[i]['longitude']); //スポットの緯度
            spotCategory = spots[i]['category_id']; //スポットのカテゴリ
            spotVisible = spots[i]['status']; //スポットの表示

            if (spotVisible != 1) {
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
                title: spotName,
                content: '<form action="/making-plan/add-spot-to-plan" method="post" enctype="multipart/form-data">' +
                    '<div class="area"><textarea type="text" class="textarea" id="spotNote" name="spotNote" placeholder="メモ" autocomplete="off"></textarea></div>' +
                    '<input type="time" name="spotTime"><br>' +
                    '<button name="spotId" value="' + spotNum + '">このスポットをプランに追加</button></form>'
            };

            // graphicを追加（カテゴリーごとに色が違う）
            addGraphic("type0", mapPoint, mapPopUp);

            // 過去のコード（カテゴリーごとの色分け）▽
            // // graphicを追加（カテゴリーごとに色が違う）
            // if (spotCategory === "名所・史跡") {
            //     addGraphic("type1", mapPoint, mapPopUp);
            // } else if (spotCategory === "公園・植物園") {
            //     addGraphic("type2", mapPoint, mapPopUp);
            // } else if (spotCategory === "公共施設") {
            //     addGraphic("type3", mapPoint, mapPopUp);
            // } else if (spotCategory === "飲食店") {
            //     addGraphic("type4", mapPoint, mapPopUp);
            // } else if (spotCategory === "寺・神社") {
            //     addGraphic("type5", mapPoint, mapPopUp);
            // } else if (spotCategory === "美術館・博物館") {
            //     addGraphic("type6", mapPoint, mapPopUp);
            // } else if (spotCategory === "温泉") {
            //     addGraphic("type7", mapPoint, mapPopUp);
            // } else if (spotCategory === "花見") {
            //     addGraphic("type8", mapPoint, mapPopUp);
            // } else if (spotCategory === "祭り・イベント") {
            //     addGraphic("type9", mapPoint, mapPopUp);
            // } else if (spotCategory === "テーマパーク") {
            //     addGraphic("type10", mapPoint, mapPopUp);
            // } else {
            //     addGraphic("type0", mapPoint, mapPopUp);
            // }
        }
    }
    addAllSpotGraphic();

    //--------------------------
    // プランにあるスポットを表示
    //--------------------------
    try {
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

    } catch (e) {}
});


// 本編
require([
    "esri/WebMap",
    "esri/views/MapView",
    "esri/widgets/LayerList",
    "esri/widgets/Search",
    "esri/widgets/ScaleBar",
    "esri/Graphic",
    "esri/tasks/RouteTask",
    "esri/tasks/support/RouteParameters",
    "esri/tasks/support/FeatureSet"
], function(
    WebMap,
    MapView,
    Search,
    ScaleBar,
    LayerList,
    Graphic,
    RouteTask,
    RouteParameters,
    FeatureSet
) {
    // 2Dマップの構成
    const mapOsaka = new WebMap({
        "portalItem": {
            "id": "93fde900d72a4d98aeb21826749bdfb2" // 旧
            // "id": "31a9714035f444c4a4ac3daf806c488d" // 新
        }
    });
    // 2Dマップのビューを作成
    const mapView = new MapView({
        container: "mapViewOsaka",
        map: mapOsaka,
        zoom: def_zoom,
        center: {
            longitude: def_lng,
            latitude: def_lat
        }
    });

    //----------
    //検索の追加
    //----------
    var searchWidget = new Search({
        view: mapView
    });
    mapView.ui.add(searchWidget, {
        position: "top-right",
        index: 2
    });

    //-------------------------------
    // プランにあるルートの表示▽
    //-------------------------------

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
    // ルートを取得する関数
    function getRoute() {
        // Setup the route parameters
        var routeParams = new RouteParameters({
            stops: new FeatureSet({
                features: mapView.graphics.toArray()
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
                mapView.graphics.add(result.route);
                // console.log("result.route:");
                // console.log(result.route);
            });

        });
    }

    // ルート追加
    try{
        addPlanRouteGraphic();
        function addPlanRouteGraphic() {
            for (let i = 0; i < plan_data.length; i++) {
                nowSpotId = parseInt(plan_data[i]['spot_id']);
                planLng = parseFloat(spots[nowSpotId]['longitude']); //スポットの緯度
                planLat = parseFloat(spots[nowSpotId]['latitude']); //スポットの経度
                mapView.graphics.add({
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
        }
    } catch (e) {}

    //--------------------------
    // プランにあるスポットを表示
    //--------------------------
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
        mapView.graphics.add(graphic);
    }
    try {
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

    } catch (e) {}
});


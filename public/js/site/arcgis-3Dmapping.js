// マップの初期位置を設定
var def_lng = 135.4983028;
var def_lat = 34.7055051;
var def_zoom = 17;

// 中心座標をプランに登録されたスポットにする
try {
    // plan が定義されている場合
    var defX = parseFloat(plan[0]['longitude']);
    var defY = parseFloat(plan[0]['latitude']);
    // var def_zoom = parseInt(plan[0]['zoom']);
} catch (e) {
}
try {
    if(mode == 0){
        var defX = 135.4983028;
        var defY = 34.7055051;
        var defZoom = 14;
    }
} catch (e) {
}

// 本編
require([
    "esri/Map",
    "esri/WebScene",
    "esri/views/SceneView",
    "esri/geometry/geometryEngine",
    "esri/core/watchUtils",
    "esri/layers/WebTileLayer",
    "esri/layers/FeatureLayer",
    "esri/widgets/LayerList",
    "esri/widgets/Search",
    "esri/widgets/ScaleBar",
    "esri/widgets/Legend",
    "esri/layers/GraphicsLayer",
    "esri/Graphic",
    "esri/tasks/RouteTask",
    "esri/tasks/support/RouteParameters",
    "esri/tasks/support/FeatureSet",
    "dojo/domReady!",
], function(
    Map,
    WebScene,
    SceneView,
    geometryEngine,
    watchUtils,
    WebTileLayer,
    FeatureLayer,
    LayerList,
    Search,
    ScaleBar,
    Legend,
    GraphicsLayer,
    Graphic,
    RouteTask,
    RouteParameters,
    FeatureSet,
) {

    // 現在時刻の取得
    var now = new Date("2022-11-11T12:00:00");

    // 3Dマップの構成
    const sceneOsaka = new WebScene({
        "portalItem": {
            "id": "58d1da6134a447f29029d5f9fc6a54c2"
        }
    });

    // 3Dマップのビューを作成
    const sceneView = new SceneView({
        qualityProfile: "medium",
        container: "sceneViewOsaka",
        map: sceneOsaka,

        camera: {
            // autocasts as new Camera()
            position: {
                // autocasts as new Point()
                x: defX,
                y: defY - 0.01,
                z: 100
            },
            heading: 0.34445102566290225,
            tilt: 82.95536300536367
        },
        environment: {
            lighting: {
                date: now,
                directShadowsEnabled: true
            },
            atmosphere: {
                quality: "midium"
            }
        }
    });

    /* **************************
    // ウィジェット追加
    **************************** */
    // const legend = new Legend ({
    //     view:sceneView
    // });

    // sceneView.ui.add(legend, "top-right");

    // Searchウィジェット
    const searchWidget = new Search({
        "view": sceneView
    });
    sceneView.ui.add(searchWidget, {
        position: "top-left",
        index: 0
    });

    // レイヤーの表示
    let layerList = new LayerList({
        view: sceneView,
        // executes for each ListItem in the LayerList
        listItemCreatedFunction: function (event) {

            // The event object contains properties of the
            // layer in the LayerList widget.

            let item = event.item;

            if (item.title === "US Demographics") {
                // open the list item in the LayerList
                item.open = true;
                // change the title to something more descriptive
                item.title = "Population by county";
                // set an action for zooming to the full extent of the layer
                item.actionsSections = [[{
                    title: "Go to full extent",
                    className: "esri-icon-zoom-out-fixed",
                    id: "full-extent"
                }]];
            }
        }
    });

    sceneView.ui.add(layerList, "top-right");

    // 3Dシンボルを追加

    /* **************************
    // 3Dマップのカメラをリセットボタン
    **************************** */
    window["view"] = sceneView;
    // let start = Date.now(); // 開始時間を覚える
    var cameraResetButton = document.getElementById("cameraResetButton");

    // ビューの日照を一時間後にする
    function setCamera() {
        view.camera = {
            position: {
                // autocasts as new Point()
                x: defX,
                y: defY - 0.001,
                z: 50
            },
            heading: 0.34445102566290225,
            tilt: 70
        };
    }

    // ビューの日照を現在に設定
    view.when(function() {

    });

    cameraResetButton.onclick = setCamera;

    /* **************************
    // 3Dマップの日照を更新
    **************************** */
    window["view"] = sceneView;
    // let start = Date.now(); // 開始時間を覚える
    var button = document.getElementById("sunButton");

    // ビューの日照を一時間後にする
    function nextStep() {
        now.setHours(now.getHours() + 1);
        view.environment.lighting.date = now;
    }

    // ビューの日照を現在に設定
    view.when(function() {
        view.environment = {
            lighting: {
                date: now,
                directShadowsEnabled: true
            },
            atmosphere: {
                quality: "high"
            }
        };
    });

    button.onclick = nextStep;


    /*********************
     * Add graphics layer
     *********************/
    const graphicsLayer = new GraphicsLayer({title:"プラン情報"});
    sceneOsaka.add(graphicsLayer);

    //-------------------------------
    // プランにあるルートの表示
    //-------------------------------

    // ArcGISのルート機能を使用するための処理
    var routeTask = new RouteTask({
        // url: "https://route.arcgis.com/arcgis/rest/services/World/Route/NAServer/Route_World"  // ログイン必要
        url: "https://utility.arcgis.com/usrsvcs/servers/cc6d0780de3b4863a26cb2cec0a77926/rest/services/World/Route/NAServer/Route_World" //ログイン不要（山本研究室のArcGISのプロキシ）
    });

    // 歩行に合わせたルートに設定
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

    var routeObject = [];   // ルートの緯度経度座標を入れる配列
    var routeArrayLength = [];  // スポット間のルートの配列の長さを入れる配列
    // routeObject[0] = 0;
    routeArrayLength[0] = 0;
    var j = 0;
    // ルートを取得する関数
    function getRoute(index) {
        // console.log("getRoute start.");
        // Setup the route parameters
        var routeParams = new RouteParameters({
            stops: new FeatureSet({
                features: graphicsLayer.graphics.toArray()
            }),
            returnDirections: true,
            travelMode: travelModeObject
        });
        // Get the route
        routeTask.solve(routeParams).then(function(data) {
            data.routeResults.forEach(function(result) {
                result.route.symbol = {
                    type: "simple-line",
                    color: [226, 119, 40],
                    width: 5
                };
                graphicsLayer.graphics.add(result.route);

                if(result.route.geometry.paths.length === plan_data.length - 1){
                    // routeObjectにルートのパスを挿入
                    result.route.geometry.paths.forEach(function(val){
                        routeObject[j] = val;
                        j++;
                    })
                }
                routeArrayLength[index] = j;
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
                const pointGraphic = new Graphic({
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
                        x: planLng,
                        y: planLat,
                        z: 5
                    }
                })
                graphicsLayer.graphics.add(pointGraphic);
                if (i > 0) {
                    getRoute(i);
                }
            }
        }
    } catch (e) {}

    /*************************
     * プランにあるスポットを表示
     *************************/
    function addGraphic(type, point, popUp) {
        const markerSymbol = {
            type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
            color: (type === "type1") ? "#EDED9D" : (type === "type2") ? "#93ED9E" : (type ===
                "type3") ? "#B2C7ED" : (type === "type4") ? "#EDD29D" : (type === "type5") ?
            "#EDB5A8" : (type === "type6") ? "#CAABED" : (type === "type7") ? "#9DEDD8" : (
                type === "type8") ? "#F0D3DE" : (type === "type9") ? "#D9F5FD" : (type ===
                "type10") ? "#A3F7CC" : (type === "type0") ? "#cccccc" : (type ===
                "start") ? "white" : "red",
            size: "20px",
            outline: {
                // autocasts as new SimpleLineSymbol()
                color: (type === "start") ? "red" : "white",
                width: 1
            }
        };
        const pointGraphic = new Graphic({
            geometry: point,
            symbol: markerSymbol,
            popupTemplate: popUp
        });
        graphicsLayer.graphics.add(pointGraphic);
    }

    // プランのスポットに柱を追加
    function addPillar(x,y){
        const polyline = {
            type: "polyline", // autocasts as new Polyline()
            paths: [[planSpotLng, planSpotLat, 0], [planSpotLng, planSpotLat, 1000]]
        };

        const lineSymbol = {
            type: "simple-line", // autocasts as SimpleLineSymbol()
            color: [226, 119, 40, 0.5],
            width: 4
        };

        const polylineGraphic = new Graphic({
            geometry: polyline,
            symbol: lineSymbol
        });

        graphicsLayer.add(polylineGraphic);
    }

    // プランのスポットを表示
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
                const mapPoint = {
                    type: "point", // autocasts as new Point()
                    x: planSpotLng,
                    y: planSpotLat,
                    z: 5
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
                    addPillar(planSpotLng,planSpotLat);
                } else {
                    addGraphic("next", mapPoint, mapPopUp);
                    addPillar(planSpotLng,planSpotLat);
                }

            }
        }

    } catch (e) {}

    /* **************************
    // 3Dマップの視点を自動で更新
    **************************** */

    // ピンのシンボルの定義
    var pinSymbol = {
        type: "point-3d",
        symbolLayers: [{
            type: "icon",
            size: 8,
            resource: { primitive: "circle" },
            material: { color: "dodgerblue" }
        }],
        verticalOffset: {
            minWorldLength: 1.7,
            screenLength: 1.7,
            maxWorldLength: 15
        },
        callout: {
            type: "line",
            size: .1,
            color: [50, 50, 50],
            border: {
                width: 0,
                color: [50, 50, 50]
            }
        }
    };

    // ピンのシンボルをグラフィックとして定義する
    var movingPin = new Graphic({
        symbol: pinSymbol,
    });

    // Watches a property for becoming falsy once.
    function waitForUpdates() {
        return watchUtils.whenNotOnce(sceneView, "updating");
    }

    // // スライドを適用する
    // function applySlide(name, props = {}) {
    //     var slide = sceneView.map.presentation.slides.find(s => s.title.text === name);
    //     return waitForUpdates().then(() => slide.applyTo(sceneView, props));
    // }

    var moveGraphicsLayer = new GraphicsLayer();
    var planGeometryPromise;
    // カメラの設定
    // var camera = {
    //     "position":{
    //         "spatialReference":{
    //             "latestWkid":3857,  // wkid:3857 は WGS 1984(新ID)
    //             "wkid":102100}, //wkid:102100 は WGS 1984(旧ID)
    //             "x":defX,
    //             "y":defY,
    //             "z":8610.004744450562
    //         },
    //     "heading":93.10542349391606,
    //     "tilt":58.06561973227666
    // };


    sceneView.when()
        // .then(() => applySlide("Intro", {animate: false}))
        .then(() => {
            sceneView.map.add(moveGraphicsLayer);
            movingPin.geometry = {
                type: "point",
                longitude: defX,
                latitude: defY,
            };
            planGeometryPromise={
                type: "polyline",
                // paths: [[
                //     // [1355002.556,347334.684],
                //     // [1355063.331,346525.752],
                //     // [1355020.90,347147.48],
                //     // [1354727.78,346502.76]
                //     [135.5002556,34.7334684],
                //     [135.5063331,34.6525752],
                //     [135.502090,34.714748],
                //     [135.472778,34.650276]
                // ]]
                paths: routeObject
            };

        })
        .then(() => waitForUpdates())
        .then(() => {
            moveGraphicsLayer.add(movingPin);
                console.log("addPin");
        }).catch(console.error);

    window.parent.document.getElementById("playButton").addEventListener("click", () => {
        // waitForUpdates()
        //     .then(() => planGeometryPromise)
        //     .then(plan => animateLine(plan))
        //     .catch(console.error);
        animateLine(planGeometryPromise, 0);
    });

    // pointA から pointB までの距離を返す
    function distance(pointA, pointB) {
        const a = pointA[0] - pointB[0];
        const b = pointA[1] - pointB[1];
        return Math.sqrt(a * a + b * b);
    }

    // pointA から pointB を見る角度(Heading)を返す
    function heading(pointA, pointB) {
        const atan2 = Math.atan2(pointB[1] - pointA[1], pointB[0] - pointA[0]);
        return (
        90 - atan2 * 180 / Math.PI
        );
    }

    function animateLine(geometry, count) {
        /*
        *****************************************************************************************************
        */
        const AREA_ANIMATION_DURATION = 10000; //アニメーションの時間[ms]
        var is_stop = false;
        const path = geometry.paths[count];     // geometryのpaths[0]を代入

        const start = path[0];              // path[0]を代入
        const waypoints = path.slice(1);    // path[1]以降をシャローコピーして代入
        // waypoints.push(start);  // waypoints の末尾に start を追加
        const durations = [];   // waypoints のポイント間の時間を入れる配列
        let totalLength = 0;    // waypoints全ての距離の総和

        waypoints.forEach((point, index) => {
            const length = distance(point, path[index]);    // ひとつ前のポイントとの距離lengthを取得
            durations.push(length); // durationsの末尾にlengthを追加
            totalLength += length;  // totalLengthにlengthを加算
        });

        durations.forEach((duration, index) => {
            durations[index] = duration * AREA_ANIMATION_DURATION / totalLength;    // durationsを時間に変換
        });

        const paths = [start];

        // movingPoint：移動先のポイント
        const movingPoint = {
            type: "point",
            spatialReference: geometry.spatialReference,
            longitude: start[0],
            latitude: start[1]
        };

        // スタート地点から現在の視点の距離
        const initialDistance = distance(start, [
            sceneView.camera.position.longitude,
            sceneView.camera.position.latitude
        ]);

        function completeAnimation() {
            paths.push([movingPoint.longitude, movingPoint.latitude]);
        }


        // 再帰構造になっている．
        let index = 0;
        let startTime = null;
        let previousPoint = null;
        function step(timestamp) {

            // durations.length が index より小さければアニメーション終了
            if (durations.length <= index) {
                console.log("Completed animation");

                is_stop = true;
                count++;

                if(count < geometry.paths.length && is_stop){
                    animateLine(geometry, count);
                }
                return;
            }

            // startTimeが定義されていなければアニメーション開始時のタイムスタンプを代入
            if (!startTime) {
                startTime = timestamp;
                previousPoint = [movingPoint.longitude, movingPoint.latitude];
            }

            var progress = timestamp - startTime;

            const sp = Math.min(1.0, progress / durations[index]);  // 当時のdurationをprogressが超えない範囲だよ
            movingPoint.longitude = previousPoint[0] + (waypoints[index][0] - previousPoint[0]) * sp;
            movingPoint.latitude = previousPoint[1] + (waypoints[index][1] - previousPoint[1]) * sp;

            movingPin.geometry = movingPoint;

            if (paths.length) {
                // createGraphic(paths.concat([[movingPoint.x, movingPoint.y]]));

                // Update camera（一時的なカメラの変数を宣言，現在の座標）
                const camera = sceneView.camera.clone();

                // Position (distace関数を呼び出して，現在のカメラの座標からmovingPointまでの距離を算出）
                const currentDistance = distance(
                    [movingPoint.longitude, movingPoint.latitude],
                    [sceneView.camera.position.longitude, sceneView.camera.position.latitude]
                );
                // dX:x座標の差，dY:y座標の差
                const dX = movingPoint.longitude - camera.position.longitude;
                const dY = movingPoint.latitude - camera.position.latitude;

                // カメラのpositionを更新
                camera.position.longitude =
                    camera.position.longitude +
                    dX * (currentDistance - initialDistance) / initialDistance;
                camera.position.latitude =
                    camera.position.latitude +
                    dY * (currentDistance - initialDistance) / initialDistance;
                // camera.position.z = camera.position.z + (elevation - previousElevation);

                // カメラのHeading（コンパス方位，北が０）を更新.
                camera.heading = heading(
                    [sceneView.camera.position.longitude, sceneView.camera.position.latitude],
                    [movingPoint.longitude, movingPoint.latitude]
                );

                sceneView.camera = camera;
                // console.log(camera.position.longitude,camera.position.latitude);
                // console.log(sceneView.camera.position.x, sceneView.camera.position.y);

                // previousElevation = elevation;
            }

            if (progress >= durations[index]) {
                completeAnimation();
                startTime = timestamp + (durations[index] - progress);
                previousPoint = [movingPoint.longitude, movingPoint.latitude];
                index++;
            }

            window.requestAnimationFrame(step);
        }
        window.requestAnimationFrame(step);


    }

});


// 以下いつか使うかもなメモ

    /*
    | レイヤーの読み込み
    */
    // // WebTileLayer:地理院タイル（淡色地図）
    // const gsipaleLyr = new WebTileLayer({
    //     urlTemplate:"https://cyberjapandata.gsi.go.jp/xyz/pale/{level}/{col}/{row}.png",
	//     id:"gsipale",
	//     opacity:0.9,
	//     copyright:"地理院タイル（淡色地図）",
	//     visible: false
    // });
    // // LOD1の読み込み
    // const modelLod1OsakaLayer = new FeatureLayer({
    //     url: "https://uec-yamamoto.maps.arcgis.com/home/item.html?id=aa05977592004efba71fb76920fb95c8",
    //     id: "3DCityModelLOD1",
    // });
    // // LOD2の読み込み
    // const modelLod2OsakaLayer = new FeatureLayer({
    //     url: "https://uec-yamamoto.maps.arcgis.com/home/item.html?id=e123870d9b58493bb2091903f17fe486",
    //     id: "3DCityModelLOD2",
    // });

        // const sceneOsaka = new Map({
    //     basemap: "streets",
    //     layers:[gsipaleLyr]
    // });
    // sceneOsaka.add(modelLod1OsakaLayer, 0);
    // sceneOsaka.add(modelLod2OsakaLayer, 0);

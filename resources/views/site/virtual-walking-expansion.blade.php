<!DOCTYPE html>
<html lang="ja">

<head>
    {{-- headタグの共通部分はcpmponents/header.blade.phpに記述 --}}
    @component('components.header')
        <!-- Page Title -->
        @slot('page_title')
            バーチャル街歩き体験
        @endslot
    @endcomponent

    {{-- -----------------------------------------------------
    ● ArcGISのJavaScriptに関する記述
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
                "esri/WebScene",
                "esri/views/SceneView",
                "esri/widgets/Search",
                "esri/widgets/ScaleBar",
                "esri/Graphic",
                "esri/tasks/RouteTask",
                "esri/tasks/support/RouteParameters",
                "esri/tasks/support/FeatureSet"
            ],
            (WebScene, SceneView) => {
                const scene = new WebScene({
                    "portalItem": {
                        "id": "ab5f4026c0ae4fc5852a0d0d73982ff8"
                    }
                });
                const view = new SceneView({
                    "container": "SceneOsaka",
                    "map": scene
                })

                scene.when(() => loadLayers(scene.layers))

            })

        console.log('map loading OK.');
    </script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

                    <!-- Close button -->
                    <div class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-xmark"></i>
                    </div>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle ml-auto">
                        <i class="fa fa-bars"></i>
                    </button>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid p-0">
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Scene View -->
                        <div class="col mh-100">

                            <div class="card mb-0">
                                <!-- Card Body -->
                                <div class="card-body p-0" style="height: calc(100vh - 230px);">

                                    <!-- View を表示する要素 -->
                                    <div id='SceneOsaka' class="h-100"></div>
                                    <div id='divToolbar'>
                                        <label>レイヤー</label>
                                        <select id='ddLayerList'>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <!-- Play Button -->

                            <div class="card bg-Secondary shadow m-auto py-0">
                                <div class="card-body" style="height:100px;">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto mx-auto text-center">
                                            <i class="fas fa-backward fa-2x text-gray-600 w-100"></i>
                                            <span class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                                                backward</span>
                                        </div>
                                        <div class="col-auto mx-auto text-center">
                                            <i class="fas fa-play fa-2x text-gray-600 w-100"></i>
                                            <span class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                                                play</span>
                                        </div>
                                        <div class="col-auto mx-auto text-center">
                                            <i class="fas fa-forward fa-2x text-gray-600 w-100"></i>
                                            <span class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                                                fast</span>
                                        </div>
                                        <div class="col-auto mx-auto text-center">
                                            <i class="fas fa-pause fa-2x text-gray-600 w-100"></i>
                                            <span class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                                                pause</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                    <!-- Footer -->
                    <div class="pos-f-b">

                        <div class="collapse" id="navbarToggleExternalContent">
                            <div class="bg-primary p-4">
                                <h5 class="text-white h4">Collapsed content</h5>
                                <span class="text-gray-100">Toggleable via the navbar brand.</span>
                            </div>
                        </div>
                        <nav class="navbar navbar-dark bg-primary">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="h3 text-white ml-3">Timeline</div>
                        </nav>
                    </div>
                    <!-- End of Footer -->
                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->



        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom scripts for all pages-->
        <script src="{{ Asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>

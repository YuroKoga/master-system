@extends('layouts.new-master')
@section('page_title')
    観光記録の共有
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">観光記録を共有する</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <a href="#" class="card-body p-0 m-0" style="text-decoration:none;">
                    <!-- Thumbnail -->
                    <img class="img-fluid rounded p-0 m-0 mb-3" style="width: 25rem;" src="img/no_image.jpg" alt="...">
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center p-0 m-0">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2021/1/20 18:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">観光プラン</div>
                        </div>
                        <div class="col w-100">
                            <span class="text-gray-600">二泊三日の観光プランです。
                            </span>
                        </div>
                        <div class="row">
                            <!-- fav info -->
                            <div class="col m-2">
                                <a href="#" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-heart"></i>
                                    </span>
                                    <span class="text">1</span>
                                </a>
                            </div>
                            <!-- user info -->
                            <div class="col-auto m-2">
                                <img class="img-profile rounded-circle" width="32" src="img/undraw_profile_6.svg">
                                <a class="mx-2 text-gray-600 small">user3</a>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters align-items-center p-0 mx-2 mb-2">
                        <div class="col-auto mr-2">
                            <a href="#" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="text">詳細</span>
                            </a>
                        </div>
                        <div class="col-auto mr-2">
                            <a href="#" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text">観光記録を作成</span>
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- 以上Plan -->


        {{-- 以下ダミー --}}
        {{-- * --}}
        {{-- * --}}
        <!-- 繰り返し -->
        <?php for($i=1;$i<=10;$i++){ ?>
        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <a href="#" class="card-body p-0 m-0" style="text-decoration:none;">
                    <!-- Thumbnail -->
                    <img class="img-fluid rounded p-0 m-0 mb-3" style="width: 25rem;" src="img/dog.jpg" alt="...">
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center p-0 m-0">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col w-100">
                            <span
                                class="text-gray-600">この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </span>
                        </div>
                        <div class="row">
                            <div class="col m-2">
                                <a href="#" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-heart"></i>
                                    </span>
                                    <span class="text">1</span>
                                </a>
                            </div>
                            <div class="col-auto m-2">
                                <img class="img-profile rounded-circle" width="32" src="img/undraw_profile_7.svg">
                                <a href="#" class="mx-2 text-gray-600 small">user4</a>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters align-items-center p-0 mx-2 mb-2">
                        <div class="col-auto mr-2">
                            <a href="#" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="text">詳細</span>
                            </a>
                        </div>
                        <div class="col-auto mr-2">
                            <a href="#" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text">観光記録を作成</span>
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- 以上Plan -->
        <?php } ?>
        {{-- * --}}
        {{-- * --}}
        {{-- 以上ダミー --}}
        <ul class="sharing_plan">
            <div id="plan-all-contents"></div> <!-- コンテンツの埋め込み先をid指定 -->
        </ul>
    </div>
    <script>
        console.log('data trade OK?');
        console.log('{{ $test }}');
        // [1] 配列のデータを用意
        var allPlanArray = '{{ $test }}';
        console.log(allPlanArray);

        // // [2] pagination.jsの設定
        // $(function() {
        //     $('#plan-all-pager').pagination({ // plan-all-pagerにページャーを埋め込む
        //         dataSource: allPlanArray,
        //         pageSize: 10, // 1ページあたりの表示数
        //         prevText: '&lt;',
        //         nextText: '&gt;',
        //         onePageOnlyDisplay: false,
        //         ellipsisMode: true,
        //         // ページがめくられた時に呼ばれる
        //         callback: function(data, pagination) {
        //             // dataの中に次に表示すべきデータが入っているので、html要素に変換
        //             $('#plan-all-contents').html(template(data)); // plan-all-contentsにコンテンツを埋め込む
        //         }
        //     });
        // });
        // // [3] データ1つ1つをhtml要素に変換する
        // function template(dataArray) {
        //     return dataArray.map(function(data) {
        //         if (data.bought == 0) {
        //             var bought = "-";
        //         } else {
        //             var bought = data.bought;
        //         }
        //         return '<ul class="plan_list"><li class="list"><a href="sharing_plan.php?path=' + data.filePath +
        //             '"><span class="title"> ' + data.title + '</span></a>' +
        //             '<a href="sharing_plan.php?path=' + data.filePath + '"><span class="comment"> ' + data.comment +
        //             '</span></a>' +
        //             '<a><span class="usr_name">' + data.usr_name + '</span><span class="date">' + data.date +
        //             '</span></a>' +
        //             '<a><span class="bought">購買数：' + bought +
        //             '</span><span class="detail_button"><form action="sharing_plan.php" method="GET"><button type="submit" name="path" value="' +
        //             data.filePath + '">詳細</button></form></span></a></li></ul>'
        //     })
        // }
    </script>
@endsection

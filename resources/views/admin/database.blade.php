@extends('layouts.new-master')
@section('page_title')
    データベース
@endsection
@section('script')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-none d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">データベース</h1>
    </div>
    @if ($userID == 1)
        <!-- DataTales -->
        <div class="card shadow mb-4">

            {{-- header --}}
            <div class="card-header py-3">

                <!-- タブ -->
                <ul class="nav nav-pills card-header-pills" id="databaseTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pills-users" id="pills-users-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-users" aria-selected="true">ユーザー</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pills-spots" id="pills-spots-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-spots" aria-selected="false">スポット</a>
                    </li>
                </ul>
                <!-- 以上タブ -->

            </div>

            {{-- カードの内容 --}}
            <div class="card-body">
                <!-- タブの内容 -->
                <div class="tab-content" id="pills-Content">

                    <!-- タブ１のコンテンツ(user_table) -->
                    <div class="tab-pane fade show active" id="pills-users" role="tabpanel"
                        aria-labelledby="pills-users-tab">
                        <!-- テーブル -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>email</th>
                                        <th>created_at</th>
                                        <th>updated_at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>{{ $user->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- テーブルここまで -->
                    </div>
                    <!-- タブ２のコンテンツ(spot_table) -->
                    <div class="tab-pane fade" id="pills-spots" role="tabpanel" aria-labelledby="pills-spots-tab">
                        <form type="post">
                            <button>csv->database</button>
                        </form>
                        <?php
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
                        ?>
                        <!-- テーブル -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>spot_lat</th>
                                        <th>spot_lng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{ $i = 1 }}
                                    @foreach ($spot_array as $spots)
                                        <tr>
                                            <td>{{ $spot_array[$i]['No'] }}</td>
                                            <td>{{ $spot_array[$i]['name'] }}</td>
                                            <td>{{ $spot_array[$i]['spot_lat'] }}</td>
                                            <td>{{ $spot_array[$i]['spot_lng'] }}</td>
                                        </tr>
                                        {{ $i++ }}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- テーブルここまで -->
                    </div>
                </div>
            </div>
        </div>
        <!-- カードここまで -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    @else
        <div class="h4">権限がありません．</div>
    @endif

@endsection

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
                    <!-- タブ１ -->
                    <li class="nav-item">
                        <a class="nav-link active" href="#pills-users" id="pills-users-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-users" aria-selected="true">ユーザー</a>
                    </li>
                    <!-- タブ２ -->
                    <li class="nav-item">
                        <a class="nav-link" href="#pills-spots" id="pills-spots-tab" data-toggle="pill" role="tab"
                            aria-controls="pills-spots" aria-selected="false">スポット</a>
                    </li>
                    <!-- タブ３ -->
                    <li class="nav-item">
                        <a class="nav-link" href="#pills-categories" id="pills-categories-tab" data-toggle="pill"
                            role="tab" aria-controls="pills-categories" aria-selected="false">カテゴリー</a>
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
                    <!-- タブ１ここまで -->

                    {{-- //////////////////////////// --}}
                    {{--                              --}}
                    {{-- タブ２のコンテンツ(spot_table) --}}
                    {{--                              --}}
                    {{-- //////////////////////////// --}}

                    <div class="tab-pane fade" id="pills-spots" role="tabpanel" aria-labelledby="pills-spots-tab">

                        {{-- メッセージ --}}
                        <div class="text">{{ $cnt }}件登録しました。</div>

                        {{-- csvファイルのアップロード --}}
                        <form action="/database/spot" method="post" enctype="multipart/form-data">
                            @csrf
                            CSVファイル：<br />
                            <input type="file" name="csvfile" /><br />
                            <input type="submit" value="アップロード" />
                        </form>

                        <!-- テーブル -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>spot_lat</th>
                                        <th>spot_lng</th>
                                        <th>category_id</th>
                                        <th>reviews</th>
                                        <th>url</th>
                                        <th>delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spots as $val)
                                        <tr>
                                            <td>{{ $val->id }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->address }}</td>
                                            <td>{{ $val->latitude }}</td>
                                            <td>{{ $val->longitude }}</td>
                                            <td>{{ $val->category_id }}</td>
                                            <td>{{ $val->reviews }}</td>
                                            <td>{{ $val->url }}</td>
                                            <td>
                                                <form action="database/spot/delete/{{ $val->id }}" method="post">
                                                    @csrf
                                                    <input type="submit" class="btn btn-danger btn-dell" value="削除">
                                                </form>
                                            </td>
                                            {{-- <td>{{ $spot_array[$loop->index]['No'] }}</td>
                                            <td>{{ $spot_array[$loop->index]['name'] }}</td>
                                            <td>{{ $spot_array[$loop->index]['spot_lat'] }}</td>
                                            <td>{{ $spot_array[$loop->index]['spot_lng'] }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- テーブルここまで -->
                    </div>
                    <!-- タブ２ここまで -->
                    {{-- //////////////////////////// --}}
                    {{--                              --}}
                    {{-- タブ３のコンテンツ(category_list_table) --}}
                    {{--                              --}}
                    {{-- //////////////////////////// --}}

                    <div class="tab-pane fade" id="pills-categories" role="tabpanel" aria-labelledby="pills-categories-tab">

                        {{-- csvファイルのアップロード --}}
                        <form action="/database/category" method="post" enctype="multipart/form-data">
                            @csrf
                            新しいカテゴリー：<br />
                            <input type="text" name="category_name" />
                            <input type="submit" value="登録" />
                        </form>

                        <!-- テーブル -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>user_id</th>
                                        <th>delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $val)
                                        {{-- @if ($loop->index == 0)
                                            @continue
                                        @endif --}}
                                        <tr>
                                            <td>{{ $val->id }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td>{{ $val->user_id }}</td>
                                            <td>
                                                <form action="database/category/delete/{{ $val->id }}" method="post">
                                                    @csrf
                                                    <input type="submit" class="btn btn-danger btn-dell" value="削除">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- テーブルここまで -->
                    </div>
                    <!-- タブ２ここまで -->
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

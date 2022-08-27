@extends('layouts.new-master')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">プランを共有する</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;"
                            src="csv/plan/img/1202131_20203147_7138_1.jpg" alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2021/1/20 20:35</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">花火が見たい</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>同じ花火は来年見られないですよ。
                                一生に一度の花火を綺麗にみるプラン</p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;"
                            src="csv/plan/img/7150136_31130001_2710_1.jpg" alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2021/1/20 18:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">調布七福神の内、６つを訪ねる</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>夫々のお寺で祭っている恵比須様、布袋様などの小さな像を買い集めるのも一考。正月は通常台紙７００円、各お寺で印を押してもらうため３００円を払って七福神巡りも面白いです。徒歩では約１日かかります。このほかには祇園寺があります。
                            </p>
                        </div>

                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                        </div>
                        <a class="mx-2 text-gray-600 small">Administrator</a>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div>

        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/no_image.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2021/1/20 18:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">観光プラン</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>二泊三日の観光プランです。</p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div>

        {{-- 以下ダミー --}}
        {{-- * --}}
        {{-- * --}}

        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div>
        <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Douglas McGee</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div> <!-- Plan Display -->
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid rounded px-0 mt-3 mb-4" style="width: 25rem;" src="img/dog.jpg"
                            alt="...">
                    </div>
                    <!-- Contents -->
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                2022/1/1 00:01</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 w-100">ダミー</div>
                        </div>
                        <div class="col-auto w-100">
                            <p>この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、
                            </p>
                        </div>
                        <div class="col-auto">
                            <img class="img-profile rounded-circle" width="32" src="img/undraw_profile.svg">
                            <a class="mx-2 text-gray-600 small">Administrator</a>
                        </div>
                    </div>
                </div><i class="fa-solid fa-bridge-suspension"></i>
            </div>
        </div>

        {{-- * --}}
        {{-- * --}}
        {{-- 以上ダミー --}}
    </div>
@endsection

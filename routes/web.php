<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|------------------------
| ■ 各画面に関して
|------------------------
|
| / --TOP画面
| /virtual-walking --TOP画面
| /virtual-walking/expansion --TOP画面
| /making-plan --TOP画面
| /making-log --TOP画面
| /sharing-log --TOP画面
| /spot/add --TOP画面
|
*/

Route::get('/', function () {
    return view('site.top');
})->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/top', function () {
    return view('site.top');
})->name('top');

Route::get('/404', function () {
    return view('site.404');
})->name('404');

// Main Function
Route::get('/virtual-walking', function () {
    return view('site.virtual-walking');
})->name('virtual-walking');

Route::get('/virtual-walking/expansion', function () {
    return view('site.virtual-walking-expansion');
})->name('virtual-walking.expansion');

/*
| ○ 観光プラン作成
*/
// ビュー
Route::get('/making-plan', 'App\Http\Controllers\CreatingPlanController@index')->name('making-plan');
// プランに観光スポットを一つ追加
Route::match(['get', 'post'], '/making-plan/add-spot-to-plan', 'App\Http\Controllers\CreatingPlanController@addSpotToPlan');
// スポットの入れ替えボタン
Route::match(['get', 'post'], 'making-plan/change/{id}/', 'App\Http\Controllers\CreatingPlanController@change');
// スポットの削除ボタン
Route::match(['get', 'post'], 'making-plan/delete-spot/{id}/', 'App\Http\Controllers\CreatingPlanController@deleteSpot');
// プランをリセット
Route::match(['get', 'post'], '/making-plan/reset', 'App\Http\Controllers\CreatingPlanController@reset');
// プランを確認
Route::match(['get', 'post'], '/making-plan/confirm', 'App\Http\Controllers\CreatingPlanController@confirm');
// プランを保存
Route::match(['get', 'post'], '/making-plan/saving', 'App\Http\Controllers\CreatingPlanController@saving');


/*
| ○ 観光記録作成
*/
// ビュー
Route::get('/making-log', 'App\Http\Controllers\CreatingLogController@index')->name('making-log');
// プランを引用して記録を作成する場合
Route::match(['get', 'post'], '/making-log/plan={planId}', 'App\Http\Controllers\CreatingLogController@fromPlan');
// 記録を引用して記録を作成する場合
Route::match(['get', 'post'], '/making-log/log={logId}', 'App\Http\Controllers\CreatingLogController@fromLog');

Route::get('/sharing-log', function () {
    $allPlan = [];
    $f = fopen('csv/plan/planList.csv', 'r');
    $i = 0;
    // CSVファイルの読み込み
    while ($row = fgetcsv($f)) {
        //   $row = convertToUTF8($row);
        // 値を取得し、配列に入れる
        $allPlan[$i] = [
            'filePath' => $row[0],
            'usr_name' => $row[1],
            'date' => $row[2],
            'title' => $row[3],
            'comment' => $row[4],
            'bought' => $row[5],
        ];
        $i++;
    }
    fclose($f);

    // 順番を入れ替える
    for ($i = 0; $i < count($allPlan); $i++) {
        $tmp[$i] = $allPlan[count($allPlan) - $i - 1];
    }
    $allPlan = $tmp;

    if ($allPlan) {
        $allPlanJson = json_encode($allPlan);
    }
    $data["allPlan"] = $allPlan;
    $data["allPlanJson"] = $allPlanJson;
    $data["test"] = 'testyade';
    return view('site.sharing-log', $data);
})->name('sharing-log');

Route::get('/spot/add', function () {
    return view('site.add-new-spot');
})->name('spot.add');

/*
|------------------------
| ■ ユーザに関して
|------------------------
|
| user.mypage
| user.config
|
*/

/*
| ○ マイページ
*/
// マイページのビュー
Route::get('/user/mypage', 'App\Http\Controllers\MypageController@index')->middleware(['auth'])->name('user.mypage');
// プランの削除ボタン
Route::match(['get', 'post'], '/user/mypage/delete-plan/{id}/', 'App\Http\Controllers\MypageController@deletePlan');

// Route::get('/user/mypage', function () {
//     return view('user.mypage');
// })->middleware(['auth'])->name('user.mypage');

/*
| ○ プランの詳細
*/
// プラン詳細画面のビュー
Route::get('/user/mypage/{plan_id}', 'App\Http\Controllers\MypageController@planDetail');

/*
| ○ 設定
*/
Route::get('/user/config', function () {
    return view('user.config');
})->name('user.config');

// ユーザー以上

/*
|------------------------
| ■ データベースに関して
|------------------------
|
| database //top
| database
|
*/

// データベースのビュー
Route::get('database', 'App\Http\Controllers\DatabaseController@index')->name('database');

// CSVファイルのインポート
Route::match(['get', 'post'], 'database/spot', 'App\Http\Controllers\SpotController@importCSV');
// スポット削除
Route::match(['get', 'post'], 'database/spot/delete/{id}/', 'App\Http\Controllers\SpotController@delete');
// 新規カテゴリー登録
Route::match(['get', 'post'], 'database/category', 'App\Http\Controllers\DatabaseController@addCategory');
// カテゴリー削除
Route::match(['get', 'post'], 'database/category/delete/{id}/', 'App\Http\Controllers\DatabaseController@categoryDelete');

// その他

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    return view('site.test');
});

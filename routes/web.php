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

Route::get('/', function () {
    return view('site.top');
})->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/top', function () {
    return view('site.top');
});

Route::get('/404', function () {
    return view('site.404');
});

// Main Function
Route::get('/virtual-walking', function () {
    return view('site.virtual-walking');
});

Route::get('/virtual-walking-expansion', function () {
    return view('site.virtual-walking-expansion');
});

Route::get('/making-plan', function () {
    return view('site.making-plan');
});

Route::get('/making-log', function () {
    return view('site.making-log');
});

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
});

Route::get('/database', [App\Http\Controllers\DatabaseController::class, 'getUserList']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Spot;
use App\Models\Category;

//===============================================================
//
//  ■：観光プラン作成コントローラ CreatingPlanController
//
//  1.作るための前処理
//  2.一つのスポットが選択されたとき．
//
//===============================================================

class CreatingPlanController extends Controller
{

    /*----------------------------------------------------
    |
    | ■ ビューの表示
    |
    -----------------------------------------------------*/
    public function index(Request $request)
    {

        // 始めてこの画面に来た時
        // セッション配列に情報を格納
        if (!$request->session()->exists('makingPlanData')) {

            //  観光プランを格納するセッション配列を生成
            $request->session()->put('makingPlanData', []);
        }

        // セッション配列の取得
        $makingPlanData = $request->session()->get('makingPlanData');

        // spotsテーブルの取得
        $spots = Spot::all();

        // category_listテーブルの取得
        $categories = Category::all();

        // プランのスポットの個数
        $count = 0;
        foreach ($makingPlanData as $row) {
            $count++;
        }

        $data = [
            "spots" => $spots,  // スポットのデータ（配列）
            "categories" => $categories,  // カテゴリーのデータ（配列）
            "plan_data_var" => var_export($makingPlanData, true),  // プランのデータ（文字列）
            "plan_data" => $makingPlanData,  // プランのデータ（配列）
            "count" => $count,  // プランのスポットの件数（int）
            "last_no" => $request->input('last_no'),  // 最後に登録したスポットの順番（int）
        ];

        // ビューを返す
        return view('site.making-plan', $data);
    }

    /*----------------------------------------------------
    |
    | ■ 作成中のプランにスポットを追加
    |
    -----------------------------------------------------*/
    public function addSpotToPlan(Request $request)
    {
        // セッション配列からプランのデータを取得
        $plan = $request->session()->get('makingPlanData');

        // プランのスポットの個数
        $count = 0;
        foreach ($plan as $row) {
            $count++;
        }

        // postされたspotIdからスポット情報の取り出し
        $spot_id = $request->get('spotId');
        $spot = Spot::find($spot_id);

        // ビューに渡すデータ
        $data = [
            "spot_id" => $spot_id - 1,
            "spot" => $spot,
            "note" => $request->get('spotNote'),
            "time" => $request->get('spotTime'),
        ];

        // セッション"makingPlanData"の末尾に$data
        $request->session()->put('makingPlanData.' . $count, $data);

        return redirect(route('making-plan', ['last_no' => $count]));
    }

    /*----------------------------------------------------
    |
    | ■ 入れ替えボタン
    |
    -----------------------------------------------------*/
    public function change(Request $request, $id)
    {
        // $idのデータ
        $tmp_now = $request->session()->get('makingPlanData.' . $id);
        // $idの前のデータ
        $tmp_pre = $request->session()->get('makingPlanData.' . $id - 1);
        // $idに前のデータを入れる
        $request->session()->put('makingPlanData.' . $id, $tmp_pre);
        // 前のデータに$idのデータを入れる
        $request->session()->put('makingPlanData.' . $id - 1, $tmp_now);

        // ビューを返す
        return redirect(route('making-plan'));
    }

    /*----------------------------------------------------
    |
    | ■ 削除ボタン
    |
    -----------------------------------------------------*/
    public function deleteSpot(Request $request, $id)
    {
        // $idのデータを削除
        $request->session()->forget('makingPlanData.' . $id);

        $count = $id;
        foreach ($request->session()->get('makingPlanData') as $row) {
            if ($request->session()->exists('makingPlanData.' . $count + 1)) {
                // 次のデータ
                $next =  $request->session()->get('makingPlanData.' . $count + 1);
                // 次のデータを入れる
                $request->session()->put('makingPlanData.' . $count, $next);
                $count++;
            } else {
                $request->session()->forget('makingPlanData.' . $count);
            }
        }
        // ビューを返す
        return redirect(route('making-plan'));
    }

    /*----------------------------------------------------
    |
    | ■ リセットボタンが押されたらリセット
    |
    -----------------------------------------------------*/
    public function reset(Request $request)
    {
        $count = 0;
        $request->session()->flush();

        return redirect(route('making-plan', ['count' => $count]));
    }


    /*----------------------------------------------------
    |
    | ■ 確認画面
    |
    -----------------------------------------------------*/
    public function confirm(Request $request)
    {
        // セッション配列の取得
        $makingPlanData = $request->session()->get('makingPlanData');

        // spotsテーブルの取得
        $spots = Spot::all();

        // category_listテーブルの取得
        $categories = Category::all();

        // プランのスポットの個数
        $count = 0;
        foreach ($makingPlanData as $row) {
            $count++;
        }

        $data = [
            "spots" => $spots,  // スポットのデータ（配列）
            "categories" => $categories,  // カテゴリーのデータ（配列）
            "plan_data" => $makingPlanData,  // プランのデータ（配列）
            "count" => $count,  // プランのスポットの件数（int）
        ];

        // ビューを返す
        return view('site.making-plan-confirm', $data);
    }

    /*----------------------------------------------------
    |
    | ■ 登録処理
    |
    -----------------------------------------------------*/
    public function saving(Request $request)
    {
        // セッション配列の取得
        $makingPlanData = $request->session()->get('makingPlanData');

        // リクエストの内容（プランのタイトルとメモ）を取得
        $plan_title = $request->input('planTitle', '名称未設定');
        $plan_note = $request->input('planNote');

        // プランのIDをランダムで数値コードとして生成（８桁）
        while (true) {
            $length = 8;
            $max = pow(10, $length) - 1;                    // コードの最大値算出
            $rand = random_int(0, $max);                    // 乱数生成
            $plan_id = sprintf('%0' . $length . 'd', $rand);     // 乱数の頭0埋め
            //すでにplan_idがあったらループし直し
            if (!DB::table('plans')->where('plan_id', $plan_id)->exists()) {
                break;
            }
        }

        // 中心座標の算出（最初に登録した場所）
        foreach ($makingPlanData as $key => $data) {
            $lat = Spot::where('id', $data['spot_id'] + 1)->value('latitude');
            $lng = Spot::where('id', $data['spot_id'] + 1)->value('longitude');
            break;
        }
        // $main_spot_id = $request->session()->get('makingPlanData.0.spot_id');
        // $lat = Spot::find($main_spot_id)->value('latitude');
        // $lng = Spot::find($main_spot_id)->value('longitude');

        // プランを登録
        DB::table('plans')->insert([
            'plan_id' => $plan_id,
            'user_id' => Auth::user()->id,
            'title' => $plan_title,
            'content' => $plan_note,
            'evaluated' => 0,
            'longitude' => $lng, // 中心座標の経度
            'latitude' => $lat, // 中心座標の緯度
            'zoom' => 17, // マップの拡大度
            'status' => 1, // 表示(1) or 非表示(0)
        ]);

        // プランの中身を登録
        foreach ($makingPlanData as $key => $data) {
            // 登録
            DB::table('plan_data')->insert([
                'plan_id' => $plan_id,
                'turn' => $key,
                'spot_id' => $data['spot_id']
            ]);
        }

        // セッションを削除
        $request->session()->flush();

        // リダイレクト
        return redirect('/user/mypage/' . $plan_id);
    }
}

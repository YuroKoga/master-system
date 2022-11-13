<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Spot;
use App\Models\Category;
use App\Models\Plan;
use App\Models\PlanData;

class MypageController extends Controller
{
    /*----------------------------------------------------
    |
    | [GET] ビューの表示
    |
    -----------------------------------------------------*/
    public function index(Request $request)
    {
        // spotsテーブルの取得
        $plans = Plan::all();

        // ビューに送るデータ
        $data = [
            "plans" => $plans,  // プランのデータ（配列）
        ];

        // ビューを返す
        return view('user.mypage', $data);
    }
    /*----------------------------------------------------
    |
    | [POST] 削除ボタン
    |
    -----------------------------------------------------*/
    public function deletePlan($id)
    {
        // $idのデータを不可視化
        $plan = Plan::find($id);
        $plan->status = 0;
        $plan->save();

        // データベースから削除したい場合はこちら↓

        // $idのデータを削除
        // $plan = Plan::find($id);
        // $plan->delete();

        // データベースの番号を１から振りなおす
        // $count = 1;
        // foreach (Plan::all() as $plan) {
        //     $plan->id = $count;
        //     $plan->save();
        //     $count++;
        // }

        // ビューを返す
        return redirect(route('user.mypage'));
    }
    /*----------------------------------------------------
    |
    | [GET] プラン詳細画面のビューの表示
    |
    -----------------------------------------------------*/
    public function planDetail(Request $request, $plan_id)
    {
        // spotsテーブルの取得
        $spots = Spot::all();

        // category_listテーブルの取得
        $categories = Category::all();

        // plansテーブルから該当のプランの取得
        $plan = Plan::where('plan_id', $plan_id)->get();

        // plan_dataテーブルから該当のプランのデータの取得
        $plan_data = PlanData::where('plan_id', $plan_id)->get();

        /*
        // ビューに送るデータ
        //
        // 例：
        // plan [
        //         [2] -> ['user_id' -> 1, 'title' -> 'title', 'content' -> 'hogehoge', ...,],
        //     ]
        //
        // plan_data [
        //         [3] -> ['plan_id' -> 12345678, 'turn' -> 0, 'spot_id' -> 100,],
        //         [4] -> ['plan_id' -> 12345678, 'turn' -> 0, 'spot_id' -> 100,],
        //         ......
        //     ]
        */
        $data = [
            "spots" => $spots,  // スポットのデータ（配列）
            "categories" => $categories,  // カテゴリーのデータ（配列）
            "plan" => $plan,  // プランのデータ（プランのタイトルやメモ）（配列）
            "plan_data" => $plan_data,  // プランの詳細データ（プランに含まれるスポットIDと順番）（配列）
        ];

        // ビューを返す
        return view('user.a-plan-detail', $data);
    }
}

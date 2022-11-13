<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Spot;
use App\Models\Category;

class CreatingLogController extends Controller
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
        return view('site.making-log', $data);
    }

    /*----------------------------------------------------
    |
    | ■ プランを引用して記録を作成する場合
    |
    -----------------------------------------------------*/
    public function fromPlan(Request $request, $planId)
    {

        // ビューを返す
        return redirect(route('making-log'));
    }

    /*----------------------------------------------------
    |
    | ■ 記録を引用して記録を作成する場合
    |
    -----------------------------------------------------*/
    public function fromLog(Request $request, $logId)
    {

        // ビューを返す
        return redirect(route('making-log'));
    }
}

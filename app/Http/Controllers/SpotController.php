<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Spot;
use App\Models\Category;

use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

class SpotController extends Controller
{
    /*----------------------------------------------------
    |
    | [GET] ビューの表示
    |
    -----------------------------------------------------*/
    public function index(Request $request)
    {
        // ビューを返す
        return redirect(route('database'));
    }

    /*----------------------------------------------------
    |
    | [POST] CSVファイルのインポート
    |
    -----------------------------------------------------*/
    public function importCSV(Request $request)
    {
        // CSV ファイル保存
        $tmpName = mt_rand() . "." . $request->file('csvfile')->guessExtension(); //TMPファイル名
        $request->file('csvfile')->move(public_path() . "/csv/tmp", $tmpName);
        $tmpPath = public_path() . "/csv/tmp/" . $tmpName;

        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $interpreter->unstrict();
        $lexer = new Lexer($config);

        //CharsetをUTF-8に変換、CSVのヘッダー行を無視
        $config->setToCharset("UTF-8");
        // $config->setFromCharset("sjis-win");
        $config->setIgnoreHeaderLine(true);

        $dataList = [];

        // 新規Observerとして、$dataList配列に値を代入
        $interpreter->addObserver(function (array $row) use (&$dataList) {
            // 各列のデータを取得
            $dataList[] = $row;
        });

        // CSVデータをパース
        $lexer->parse($tmpPath, $interpreter);

        // TMPファイル削除
        unlink($tmpPath);

        // 登録処理
        $count = 0;
        foreach ($dataList as $row) {
            // カテゴリ名からカテゴリIDを取得
            $category_name = $row[5];
            if (Category::where('name', $category_name)->exists()) {
                $category_id = Category::where('name', $category_name)->value('id');
            } else {
                $category_id = 0;
            }

            // 送信されたデータと一致するスポット名がデータベースにあれば更新する
            if ($row[3] == "" || $row[4] == "") {
            } else if (Spot::where('name', $row[1])->exists()) {
                // スポットを更新
                Spot::where('name', $row[1])->update([
                    'address' => $row[2],
                    'latitude' => $row[3],
                    'longitude' => $row[4],
                    'category_id' => $category_id,
                    'reviews' => $row[6],
                    'url' => $row[7],
                    'user_id' => 0
                ]);
            } else {
                // 新たにスポットを追加する
                DB::table('spots')->insert([
                    'name' => $row[1],
                    'address' => $row[2],
                    'latitude' => $row[3],
                    'longitude' => $row[4],
                    'category_id' => $category_id,
                    'reviews' => $row[6],
                    'url' => $row[7],
                    'user_id' => 0
                ]);
            }

            $count++;
        }

        return redirect(route('database', ['count' => $count]));
    }

    /*----------------------------------------------------
    |
    | [POST] スポットの削除
    |
    -----------------------------------------------------*/
    public function delete($id)
    {
        // $idのデータを削除
        $spot = Spot::find($id);
        $spot->delete();

        // データベースの番号を１から振りなおす
        $count = 1;
        foreach (Spot::all() as $val) {
            $val->id = $count;
            $val->save();
            $count++;
        }

        // ビューを返す
        return redirect(route('database'));
    }
}

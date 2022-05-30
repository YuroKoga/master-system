<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function planning()
    {
        return view('planning');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // POSTされたデータをDB（plansテーブル）に挿入
        // PLANモデルにDBへ保存する命令を出す

        // 同じタグがあるか確認
        $exist_tag = Tag::where('name', $data['tag'])->where('user_id', $data['user_id'])->first();
        if (empty($exist_tag['id'])) {
            // タグをインサート
            $tag_id = Tag::insertGetId(['name' => $data['tag'], 'user_id' => $data['user_id']]);
        } else {
            $tag_id = $exist_tag['id'];
        }

        //

        $memo_id = Plan::insertGetId([
            'user_id' => $data['user_id'],
            "title" => $data['title'],
            'content' => $data['content'],
            'evaluated' => 0,
            'lng' => 0,
            'lat' => 0,
            'zoom' => 0,
            'tag_id' => $tag_id,
            'status' => 1,
            'goto_at' => NULL,
        ]);

        // リダイレクト処理
        return redirect()->route('home');
    }

    public function edit($id)
    {
        // 該当するIDのメモをデータベースから取得
        $user = \Auth::user();
        $plan = Plan::where('status', 1)->where('id', $id)->where('user_id', $user['id'])
            ->first();
        //取得したメモをViewに渡す
        return view('edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        Plan::where('id', $id)->update(['content' => $inputs['content'], 'tag_id' => $inputs['tag_id']]);
        // リダイレクト処理
        return redirect()->route('home');
    }

    public function delete(Request $request, $id)
    {
        $inputs = $request->all();
        // 論理削除なので、status=2
        Plan::where('id', $id)->update(['status' => 2]);
        // リダイレクト処理
        return redirect()->route('home')->with('success', 'メモの削除が完了しました');
    }
}

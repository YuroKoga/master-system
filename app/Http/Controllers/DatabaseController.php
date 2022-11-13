<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Spot;
use App\Models\Category;

class DatabaseController extends Controller
{

    public function index(Request $request)
    {
        // ログイン中のユーザIDを取得
        $userID = Auth::id();

        // usersテーブルの取得
        $users = DB::table('users')->get();

        // spotsテーブルの取得
        $spots = Spot::all();

        // usersテーブルの取得
        $categories = Category::all();

        // post後のメッセージを取得
        $count = $request->input('count');

        $data = [
            "userID" => $userID,
            "users" => $users,
            "spots" => $spots,
            "categories" => $categories,
            'cnt' => $count
        ];

        // ビューを返す
        return view('admin.database', $data);
    }

    public function addCategory(Request $request)
    {
        $category_name = $request->get('category_name');
        DB::table('category_list')->insert([
            'name' => $category_name,
        ]);
        return redirect(route('database'));
    }
    public function categoryDelete($id)
    {
        $category = Category::find($id);
        $category->delete();
        // ビューを返す
        return redirect(route('database'));
    }
}

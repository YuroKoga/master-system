<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DatabaseController extends Controller
{
    public function getUserList()
    {

        $users = DB::table('users')->get();
        $userID = Auth::id();
        return view('admin.database', [
            "users" => $users,
            "userID" => $userID
        ]);
    }
}

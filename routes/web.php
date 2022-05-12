<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('hello', function(){
//     return view('hello.index');
// });

// use \App\Http\Middleware\HelloMiddleware; を追記
// Route::get('hello', 'App\Http\Controllers\HelloController@index')
//     ->middleware('hello');

Route::get('hello', 'App\Http\Controllers\HelloController@index');
Route::post('hello', 'App\Http\Controllers\HelloController@post');

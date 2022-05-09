<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('hello', function(){
//     return view('hello.index');
// });

// use \App\Http\Middleware\HelloMiddleware; を追記

Route::get('hello', 'App\Http\Controllers\HelloController@index')
	->middleware(\App\Http\Middleware\HelloMiddleware::class);
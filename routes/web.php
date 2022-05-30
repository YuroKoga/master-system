<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('hello', function(){
//     return view('hello.index');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('index');
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::get('/planning', 'App\Http\Controllers\HomeController@planning')->name('planning');
    Route::post('/store', 'App\Http\Controllers\HomeController@store')->name('store');
    Route::get('/edit/{id}', 'App\Http\Controllers\HomeController@edit')->name('edit');
    Route::post('/update/{id}', 'App\Http\Controllers\HomeController@update')->name('update');
    Route::post('/delete/{id}', 'App\Http\Controllers\HomeController@delete')->name('delete');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

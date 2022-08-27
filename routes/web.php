<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/top', function () {
    return view('site.top');
});
Route::get('/virtual-walking', function () {
    return view('site.virtual-walking');
});
Route::get('/making-plan', function () {
    return view('site.making-plan');
});
Route::get('/making-log', function () {
    return view('site.making-log');
});
Route::get('/sharing-log', function () {
    return view('site.sharing-log');
});

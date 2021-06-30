<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// LINE Messaging API / LINE Login
Route::post("/v1/line/entry", "V1\\LineController@entry")->name("line.entry");
// Route::get("/v1/line/login", "V1\\LineController@login")->name("line.login");

// LINE LIFF
Route::get("/v1/liff/today", "V1\\LiffController@today")->name("liff.today");
Route::get("/v1/liff/history", "V1\\LiffController@history")->name("liff.history");
Route::post("/v1/liff/getAccessToken", "V1\\LiffController@getAccessToken")->name("liff.getAccessToken");

Route::post('/today', 'TodayController@store')->name('today.store');

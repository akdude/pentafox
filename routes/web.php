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

Route::get('/git', function () {
    return view('welcome');
});


Route::get('/git/show-users','GitController@showUsers');

Route::get('/git/search-users','GitController@searchUsers');

Route::get('/move-the-box', function() {
	return view('game');
});

Route::get('/move-the-box-obstacle', function() {
	return view('obstacle');
});

Route::get('/diff', function() {
	return view('diff');
});

Route::get('/diff/calc', 'GitController@showCalc');
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
    return view('partial/content');
});

Route::get('/category','CategoryController@index');
Route::get('/categories','CategoryController@categories');
Route::post('/category','CategoryController@store');
Route::put('/category','CategoryController@update');
Route::put('/category/state','CategoryController@changeState');

Route::get('/article','ArticleController@index');
Route::post('/article','ArticleController@store');
Route::put('/article','ArticleController@update');
Route::put('/article/state','ArticleController@changeState');

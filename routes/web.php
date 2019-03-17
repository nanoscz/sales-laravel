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
// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=> ['guest']], function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login','Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=> ['auth']], function(){
    Route::post('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/main', function () {
        return view('partial/content');
    })->name('main');

    Route::group(['middleware'=> ['warehouse']], function(){

        Route::get('/category','CategoryController@index');
        Route::get('/categories','CategoryController@categories');
        Route::post('/category','CategoryController@store');
        Route::put('/category','CategoryController@update');
        Route::put('/category/state','CategoryController@changeState');
        
        Route::get('/article','ArticleController@index');
        Route::get('/articles','ArticleController@articles');
        Route::get('/articles/modal','ArticleController@modalarticles');
        Route::post('/article','ArticleController@store');
        Route::put('/article','ArticleController@update');
        Route::put('/article/state','ArticleController@changeState');
            
        Route::get('/provider','ProviderController@index');
        Route::get('/providers','ProviderController@providers');
        Route::post('/provider','ProviderController@store');
        Route::put('/provider','ProviderController@update');

        Route::get('/income','IncomeController@index');
        Route::post('/income','IncomeController@store');
        Route::put('/income/state','IncomeController@changeState');
        Route::get('/income/header','IncomeController@getHeader');
        Route::get('/income/detail','IncomeController@getDetail');
    });

    Route::group(['middleware'=> ['seller']], function(){
        Route::get('/client','ClientController@index');
        Route::post('/client','ClientController@store');
        Route::get('/clients','ClientController@clients');
        Route::put('/client','ClientController@update');
        Route::put('/client/state','ClientController@changeState');

        Route::get('/sale','SaleController@index');
        Route::get('/sale','SaleController@index');
        Route::post('/sale','SaleController@store');
        Route::put('/sale/state','SaleController@changeState');
        Route::get('/sale/header','SaleController@getHeader');
        Route::get('/sale/detail','SaleController@getDetail');
    });

    Route::group(['middleware'=> ['admin']], function(){
        
        Route::get('/category','CategoryController@index');
        Route::get('/categories','CategoryController@categories');
        Route::post('/category','CategoryController@store');
        Route::put('/category','CategoryController@update');
        Route::put('/category/state','CategoryController@changeState');
        
        Route::get('/article','ArticleController@index');
        Route::get('/articles','ArticleController@articles');
        Route::get('/articles/sales','ArticleController@listArticleSales');
        Route::get('/articles/search','ArticleController@searchArticles');
        Route::get('/articles/modal','ArticleController@modalarticles');
        Route::post('/article','ArticleController@store');
        Route::put('/article','ArticleController@update');
        Route::put('/article/state','ArticleController@changeState');
            
        Route::get('/provider','ProviderController@index');
        Route::get('/providers','ProviderController@providers');
        Route::post('/provider','ProviderController@store');
        Route::put('/provider','ProviderController@update');

        Route::get('/client','ClientController@index');
        Route::post('/client','ClientController@store');
        Route::get('/clients','ClientController@clients');
        Route::put('/client','ClientController@update');
        Route::put('/client/state','ClientController@changeState');

        Route::get('/rol','RolController@index');
        Route::get('/roles','RolController@roles');
        
        Route::get('/user','UserController@index');
        Route::post('/user','UserController@store');
        Route::put('/user','UserController@update');
        Route::put('/user/state','UserController@changeState');

        Route::get('/income','IncomeController@index');
        Route::post('/income','IncomeController@store');
        Route::put('/income/state','IncomeController@changeState');
        Route::get('/income/header','IncomeController@getHeader');
        Route::get('/income/detail','IncomeController@getDetail');

        Route::get('/sale','SaleController@index');
        Route::get('/sale','SaleController@index');
        Route::post('/sale','SaleController@store');
        Route::put('/sale/state','SaleController@changeState');
        Route::get('/sale/header','SaleController@getHeader');
        Route::get('/sale/detail','SaleController@getDetail');
    });  
});


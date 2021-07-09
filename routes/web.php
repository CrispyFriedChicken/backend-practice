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
//Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::middleware('auth')->group(function () {
    // Authentication Routes...
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    /*View Route*/
    //遊戲維護
    Route::group(['prefix' => 'games'], function () {
        Route::view('list', 'game.list');
        Route::view('create', 'game.create');
        Route::view('update', 'game.update');
    });
    //玩家維護
    Route::group(['prefix' => 'players'], function () {
        Route::view('list', 'player.list');
        Route::view('create', 'player.create');
        Route::view('update', 'player.update');
    });
    //注單查詢
    Route::group(['prefix' => 'orders'], function () {
        Route::view('list', 'order.list');
    });

    /*API Route*/
    Route::group(['prefix' => 'api'], function () {
        //遊戲維護
        Route::group(['prefix' => 'games'], function () {
            Route::post('', 'Api\GameController@create');
            Route::post('{uuid}', 'Api\GameController@update');
            Route::delete('{uuid}', 'Api\GameController@delete');
            Route::get('', 'Api\GameController@list');
        });
        //玩家維護
        Route::group(['prefix' => 'players'], function () {
            Route::post('', 'Api\PlayerController@create');
            Route::post('{uuid}', 'Api\PlayerController@update');
            Route::delete('{uuid}', 'Api\PlayerController@delete');
            Route::get('', 'Api\PlayerController@list');
        });
        //注單查詢
        Route::group(['prefix' => 'orders'], function () {
            Route::get('', 'Api\OrderController@list');
            Route::get('summary', 'Api\OrderController@summary');
        });
    });
});

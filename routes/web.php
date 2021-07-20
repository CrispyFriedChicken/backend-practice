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

/*View Route*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
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
    //每日注單結算報表
    Route::group(['prefix' => 'dailyOrderSummary'], function () {
        Route::view('list', 'dailyOrderSummary.list');
    });
    //報表分析
    Route::group(['prefix' => 'report'], function () {
        Route::view('revenueAnalysis', 'report.revenueAnalysis');
        Route::view('orderCountAnalysis', 'report.orderCountAnalysis');
        Route::view('gameRank', 'report.gameRank');
        Route::view('playerRank', 'report.playerRank');
    });
});

/*API Route*/
Route::post('/apiLogin', 'Api\LoginController@login');
Route::group(['prefix' => 'api'], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
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
        //每日注單結算報表
        Route::group(['prefix' => 'dailyOrderSummary'], function () {
            Route::get('', 'Api\DailyOrderSummaryController@list');
            Route::get('report', 'Api\DailyOrderSummaryController@report');
        });
        //報表分析
        Route::group(['prefix' => 'report'], function () {
            Route::get('revenueAnalysis', 'Api\ReportController@revenueAnalysis');
            Route::get('orderCountAnalysis', 'Api\ReportController@orderCountAnalysis');
            Route::get('gameRank', 'Api\ReportController@gameRank');
            Route::get('playerRank', 'Api\ReportController@playerRank');
        });
    });
});

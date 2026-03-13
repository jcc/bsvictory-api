<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| 股票推荐数据 API - 使用 stocks 数据库
|
*/

// 原有路由
Route::get('/saveRawByIp', 'RawController@saveRawByIp');
Route::get('/raw', 'RawController@getRaw');
Route::get('/stocks', 'StockController@getStocks');
Route::post('/update-stock', 'StockController@updateStockById');
Route::get('/daily-profit', 'DailyController@getDaily');

// 新增股票数据 API (使用 stocks 数据库)
Route::prefix('stocks')->group(function () {
    // 获取今日推荐股票
    // GET /api/stocks/recommendations?type=afternoon
    Route::get('/recommendations', [StockDataController::class, 'recommendations']);

    // 获取最新推荐
    // GET /api/stocks/latest?type=afternoon&limit=10
    Route::get('/latest', [StockDataController::class, 'latest']);

    // 获取今日快照
    // GET /api/stocks/snapshots?type=morning
    Route::get('/snapshots', [StockDataController::class, 'snapshots']);

    // 获取高换手率股票
    // GET /api/stocks/high-turnover?min=3.0&type=morning
    Route::get('/high-turnover', [StockDataController::class, 'highTurnover']);

    // 获取指定股票信息
    // GET /api/stocks/{code}?type=morning
    Route::get('/{code}', [StockDataController::class, 'show']);

    // 获取推荐详情
    // GET /api/stocks/recommendations/{id}
    Route::get('/recommendations/{id}', [StockDataController::class, 'recommendationDetail']);
});

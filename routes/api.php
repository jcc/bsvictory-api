<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/saveRawByIp', 'RawController@saveRawByIp');
Route::get('/raw', 'RawController@getRaw');
Route::get('/stocks', 'StockController@getStocks');

Route::post('/update-stock', 'StockController@updateStockById');

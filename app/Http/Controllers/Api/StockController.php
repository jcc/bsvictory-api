<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function getStocks (Request $request)
    {
        $date = $request->get('date');

        $stocks = Stock::whereDate('created_at', $date)->groupBy('code')->get();

        return $stocks;
    }
}

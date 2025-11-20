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

        $stocks = Stock::whereDate('created_at', $date)->get();

        return $stocks;
    }

    public function updateStockById(Request $request)
    {
        $stockId = $request->get('id');
        $remark = $request->get('remark', null);
        $canBuy = $request->get('can_buy', null);

        if (empty($stockId)) {
            return response()->json([
                'message' => '参数错误',
            ]);
        }

        $stock = Stock::find('id', $stockId);

        if (isset($stock)) {
            return response()->json([
                'message' => '记录不存在',
            ]);
        }

        $stock->remark = $remark;
        $stock->can_buy = $canBuy;
        $res = $stock->save();

        return $res;
    }
}

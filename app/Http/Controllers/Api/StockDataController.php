<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockRecommendation;
use App\Models\StockSnapshot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * 获取今日推荐股票
     * GET /api/stocks/recommendations?type=afternoon
     */
    public function recommendations(Request $request)
    {
        $type = $request->get('type', 'afternoon');
        $limit = $request->get('limit', 20);

        $recommendations = StockRecommendation::where('recommend_date', Carbon::now()->toDateString())
            ->where('recommend_type', $type)
            ->orderBy('stock_rank')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recommendations,
            'date' => Carbon::now()->toDateString(),
            'type' => $type,
        ]);
    }

    /**
     * 获取最新推荐股票
     * GET /api/stocks/latest?type=afternoon&limit=10
     */
    public function latest(Request $request)
    {
        $type = $request->get('type', 'afternoon');
        $limit = $request->get('limit', 10);

        $recommendations = StockRecommendation::getLatest($type, $limit);

        return response()->json([
            'success' => true,
            'data' => $recommendations,
            'type' => $type,
        ]);
    }

    /**
     * 获取今日快照
     * GET /api/stocks/snapshots?type=morning
     */
    public function snapshots(Request $request)
    {
        $type = $request->get('type', 'morning');
        
        $snapshots = StockSnapshot::getTodaySnapshots($type);

        return response()->json([
            'success' => true,
            'data' => $snapshots,
            'date' => Carbon::now()->toDateString(),
            'type' => $type,
            'count' => $snapshots->count(),
        ]);
    }

    /**
     * 获取高换手率股票
     * GET /api/stocks/high-turnover?min=3.0&type=morning
     */
    public function highTurnover(Request $request)
    {
        $minTurnover = $request->get('min', 3.0);
        $type = $request->get('type', 'morning');
        $limit = $request->get('limit', 50);

        $stocks = StockSnapshot::getHighTurnoverStocks($minTurnover, $type, $limit);

        return response()->json([
            'success' => true,
            'data' => $stocks,
            'min_turnover' => $minTurnover,
            'count' => $stocks->count(),
        ]);
    }

    /**
     * 获取指定股票信息
     * GET /api/stocks/:code
     */
    public function show(Request $request, string $code)
    {
        $type = $request->get('type', 'morning');
        
        $snapshot = StockSnapshot::getStockSnapshot($code, $type);

        if (!$snapshot) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $snapshot,
        ]);
    }

    /**
     * 获取股票推荐详情
     * GET /api/stocks/recommendations/:id
     */
    public function recommendationDetail(Request $request, int $id)
    {
        $recommendation = StockRecommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Recommendation not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recommendation,
        ]);
    }
}

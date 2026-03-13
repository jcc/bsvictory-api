<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRecommendation extends Model
{
    protected $connection = 'stocks';
    protected $table = 'stock_recommendations';

    public $timestamps = false;

    protected $fillable = [
        'recommend_date',
        'recommend_type',
        'stock_rank',
        'code',
        'name',
        'last_price',
        'change_rate',
        'buy_low',
        'buy_high',
        'volume_feature',
        'kline_shape',
        'capital_flow',
        'score',
        'pe_ratio',
        'pb_ratio',
        'turnover_rate',
        'total_market_val',
        'snapshot_id',
        'created_at',
    ];

    protected $casts = [
        'recommend_date' => 'date',
        'last_price' => 'decimal:4',
        'change_rate' => 'decimal:4',
        'buy_low' => 'decimal:4',
        'buy_high' => 'decimal:4',
        'score' => 'integer',
        'pe_ratio' => 'decimal:4',
        'pb_ratio' => 'decimal:4',
        'turnover_rate' => 'decimal:6',
        'total_market_val' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /**
     * 获取今日推荐
     */
    public static function getTodayRecommendations(string $type = 'afternoon')
    {
        return static::where('recommend_date', now()->toDateString())
            ->where('recommend_type', $type)
            ->orderBy('stock_rank')
            ->get();
    }

    /**
     * 获取最新推荐（按日期和类型）
     */
    public static function getLatest(string $type = 'afternoon', int $limit = 20)
    {
        return static::where('recommend_type', $type)
            ->orderBy('recommend_date', 'desc')
            ->orderBy('stock_rank')
            ->limit($limit)
            ->get();
    }

    /**
     * 按评分获取推荐
     */
    public static function getTopRecommendations(int $limit = 10, string $type = 'afternoon')
    {
        return static::where('recommend_type', $type)
            ->orderBy('score', 'desc')
            ->orderBy('stock_rank')
            ->limit($limit)
            ->get();
    }
}

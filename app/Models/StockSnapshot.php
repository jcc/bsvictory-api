<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSnapshot extends Model
{
    protected $connection = 'stocks';
    protected $table = 'stock_snapshot_records';

    public $timestamps = false;

    protected $fillable = [
        'snapshot_date',
        'code',
        'name',
        'record_type',
        'last_price',
        'open_price',
        'high_price',
        'low_price',
        'prev_close_price',
        'change_rate',
        'volume',
        'turnover',
        'turnover_rate',
        'amplitude',
        'avg_price',
        'volume_ratio',
        'ask_price',
        'bid_price',
        'ask_vol',
        'bid_vol',
        'pe_ratio',
        'pb_ratio',
        'total_market_val',
        'circular_market_val',
        'issued_shares',
        'outstanding_shares',
        'highest52weeks_price',
        'lowest52weeks_price',
        'suspension',
        'sec_status',
        'listing_date',
        'update_time',
        'created_at',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
        'record_type' => 'string',
        'last_price' => 'decimal:4',
        'open_price' => 'decimal:4',
        'high_price' => 'decimal:4',
        'low_price' => 'decimal:4',
        'prev_close_price' => 'decimal:4',
        'change_rate' => 'decimal:4',
        'volume' => 'integer',
        'turnover' => 'decimal:2',
        'turnover_rate' => 'decimal:6',
        'amplitude' => 'decimal:6',
        'avg_price' => 'decimal:4',
        'volume_ratio' => 'decimal:4',
        'ask_price' => 'decimal:4',
        'bid_price' => 'decimal:4',
        'ask_vol' => 'integer',
        'bid_vol' => 'integer',
        'pe_ratio' => 'decimal:4',
        'pb_ratio' => 'decimal:4',
        'total_market_val' => 'decimal:2',
        'circular_market_val' => 'decimal:2',
        'issued_shares' => 'integer',
        'outstanding_shares' => 'integer',
        'highest52weeks_price' => 'decimal:4',
        'lowest52weeks_price' => 'decimal:4',
        'suspension' => 'boolean',
        'listing_date' => 'date',
        'update_time' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * 获取今日快照
     */
    public static function getTodaySnapshots(string $type = 'morning')
    {
        return static::where('snapshot_date', now()->toDateString())
            ->where('record_type', $type)
            ->get();
    }

    /**
     * 获取指定股票的快照
     */
    public static function getStockSnapshot(string $code, string $type = 'morning')
    {
        return static::where('code', $code)
            ->where('record_type', $type)
            ->orderBy('snapshot_date', 'desc')
            ->first();
    }

    /**
     * 获取高换手率股票
     */
    public static function getHighTurnoverStocks(float $minTurnover = 3.0, string $type = 'morning', int $limit = 50)
    {
        return static::where('snapshot_date', now()->toDateString())
            ->where('record_type', $type)
            ->where('turnover_rate', '>=', $minTurnover)
            ->where('suspension', false)
            ->orderBy('turnover_rate', 'desc')
            ->limit($limit)
            ->get();
    }
}

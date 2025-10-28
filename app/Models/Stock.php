<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'name', 'model', 'code', 'current_price', 'yesterday_close', 'open_price', 'volume', 'bid_volume', 'ask_volume', 'buy1_price', 'buy1_volume', 'buy2_price', 'buy2_volume', 'buy3_price', 'buy3_volume', 'buy4_price', 'buy4_volume', 'buy5_price', 'buy5_volume', 'sell1_price', 'sell1_volume', 'sell2_price', 'sell2_volume', 'sell3_price', 'sell3_volume', 'sell4_price', 'sell4_volume', 'sell5_price', 'sell5_volume', 'trade_time', 'price_change', 'price_change_percent', 'highest_price', 'lowest_price', 'turnover', 'pe_ratio', 'amplitude', 'total_market_value', 'circulating_market_value',
    ];
}

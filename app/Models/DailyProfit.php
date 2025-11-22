<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyProfit extends Model
{
    protected $table = 'daily_profit';

    protected $fillable = ['date', 'profit', 'total_profit', 'stock_count', 'profit_stock_count', 'loss_stock_count', 'up_num', 'down_num', 'flat_num'];
}

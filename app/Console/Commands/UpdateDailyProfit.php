<?php

namespace App\Console\Commands;

use App\Models\DailyProfit;
use App\Models\Stock;
use Illuminate\Console\Command;

class UpdateDailyProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-daily-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计每日收益';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 统计每日平均收益
        $dailyAverages = Stock::selectRaw('DATE(created_at) as date, AVG(actual_profit) as profit, COUNT(id) as stock_count, SUM(CASE WHEN actual_profit > 0 THEN 1 ELSE 0 END) as profit_stock_count, SUM(CASE WHEN actual_profit < 0 THEN 1 ELSE 0 END) as loss_stock_count, SUM(actual_profit) as total_profit')
                       ->groupBy('date')
                       ->orderBy('date', 'asc')
                       ->get();

        DailyProfit::query()->upsert($dailyAverages->toArray(), ['date'], ['profit', 'total_profit', 'stock_count', 'profit_stock_count', 'loss_stock_count']);

        return 0;
    }
}

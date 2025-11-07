<?php

namespace App\Console\Commands;

use App\Models\DailyProfit;
use App\Models\Stock;
use Carbon\Carbon;
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
        $prevDay = $this->getPreviousTradingDay();

        // 统计每日平均收益
        $dailyAverages = Stock::selectRaw('AVG(actual_profit) as profit, COUNT(id) as stock_count, SUM(CASE WHEN actual_profit > 0 THEN 1 ELSE 0 END) as profit_stock_count, SUM(CASE WHEN actual_profit < 0 THEN 1 ELSE 0 END) as loss_stock_count, SUM(actual_profit) as total_profit')
                       ->whereDate('created_at', $prevDay)
                       ->first();

        $record = DailyProfit::whereDate('date', $prevDay)->first();

        if ($dailyAverages->stock_count > 0) {
            if (!$record) {
                DailyProfit::create([
                    'date' => $prevDay,
                    'profit' => $dailyAverages->profit,
                    'total_profit' => $dailyAverages->total_profit,
                    'stock_count' => $dailyAverages->stock_count,
                    'profit_stock_count' => $dailyAverages->profit_stock_count,
                    'loss_stock_count' => $dailyAverages->loss_stock_count,
                ]);
            } else {
                $record->update([
                    'profit' => $dailyAverages->profit,
                    'total_profit' => $dailyAverages->total_profit,
                    'stock_count' => $dailyAverages->stock_count,
                    'profit_stock_count' => $dailyAverages->profit_stock_count,
                    'loss_stock_count' => $dailyAverages->loss_stock_count,
                ]);
            }
        }

        return 0;
    }

    /**
     * 获取上一个交易日日期
     */
    protected function getPreviousTradingDay($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        do {
            $date = $date->subDay();
        } while ($date->isWeekend());

        return $date->format('Y-m-d');
    }
}

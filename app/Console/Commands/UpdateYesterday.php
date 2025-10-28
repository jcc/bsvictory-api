<?php

namespace App\Console\Commands;

use App\Models\Raw;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateYesterday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-yesterday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新昨天数据，今天开的价格写入，用于统计总收益';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 获取上一个交易日日期
        $yesterday = $this->getPreviousTradingDay();

        $raw = Raw::whereDate('created_at', $yesterday)->first();

        return $this->updateStocks($raw->data, $yesterday);
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

    /**
     * 更新次日开字段
     */
    protected function updateStocks ($data, $yesterday)
    {
        $codes = [];

        $items = $data->codes;
        $machineNums = [];

        if (empty($items)) {
            return false;
        }

        foreach ($items as $key => $machine) {
            $machineCodes = array_keys(get_object_vars($machine));

            if (!empty($machineCodes)) {
                foreach ($machineCodes as $machineCode) {
                    $machineNums[] = $key;
                    $items = explode('.', $machineCode);

                    $codes[] = strtolower($items[1]) . $items[0];
                }
            }
        }

        if (empty($codes)) {
            return false;
        }

        $response = make_request('http://qt.gtimg.cn/q=' . implode(',', $codes));

        $stocks = parse_response($response);

        foreach ($stocks as $key => $stock) {
            $stocks[$key]['model'] = $machineNums[$key];
        }

        $yesterdayNum = Stock::whereDate('created_at', $yesterday)->count();

        $oldStocks = Stock::whereDate('created_at', $yesterday)->get();

        if ($yesterdayNum) {
            foreach ($stocks as $stock) {
                $target = $oldStocks->where('code', $stock['code'])->where('model', $stock['model'])->first();
                $profit = number_format(($stock['open_price'] - $target['open_price']) / $target['open_price'] * 100, 2);

                $target->next_open = $stock['open_price'];
                $target->actual_profit = $profit;
                $target->save();
            }
        }

        return true;
    }
}

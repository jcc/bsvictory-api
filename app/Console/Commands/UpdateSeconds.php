<?php

namespace App\Console\Commands;

use App\Models\Raw;
use App\Models\Stock;
use Illuminate\Console\Command;

class UpdateSeconds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-seconds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每 5 秒更新当天数据';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $record = Raw::whereDate('created_at', today())->first();

        return $this->saveStocks($record->data);
    }
    /**
     * 更新数据
     */
    protected function saveStocks ($data)
    {
        $codes = [];

        $items = $data->codes;
        $machineNums = [];

        if (empty($items)) {
            print('empty');
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
            print('empty');
            return false;
        }

        $response = make_request('http://qt.gtimg.cn/q=' . implode(',', $codes));

        $stocks = parse_response($response);

        foreach ($stocks as $key => $stock) {
            $stocks[$key]['model'] = $machineNums[$key];
            $stocks[$key]['created_at'] = now();
            $stocks[$key]['updated_at'] = now();
        }

        $todayNum = Stock::whereDate('created_at', today())->count();

        $oldStocks = Stock::whereDate('created_at', today())->get();

        if ($todayNum) {
            foreach ($stocks as $stock) {
                $profit = number_format(($stock['current_price'] - $stock['open_price']) / $stock['open_price'] * 100, 2);

                $target = $oldStocks->where('code', $stock['code'])->where('model', $stock['model'])->first();

                $target->profit = $profit;
                $target->current_price = $stock['current_price'];
                $target->current_price = $stock['current_price'];
                $target->volume = $stock['volume'];
                $target->bid_volume = $stock['bid_volume'];
                $target->ask_volume = $stock['ask_volume'];
                $target->trade_time = $stock['trade_time'];
                $target->price_change = $stock['price_change'];
                $target->price_change_percent = $stock['price_change_percent'];
                $target->highest_price = $stock['highest_price'];
                $target->lowest_price = $stock['lowest_price'];
                $target->turnover = $stock['turnover'];
                $target->amplitude = $stock['amplitude'];
                $target->save();
            }
        }

        return true;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\DailyProfit;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateIncAndDecNum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-final-num';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天收盘更新当日最终涨停数量';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->subDay()->format('Y-m-d');

        $response = make_request('https://push2.eastmoney.com/api/qt/ulist/get?fltt=1&invt=2&fields=f104%2Cf105%2Cf106&secids=1.000002%2C0.399002%2C0.899050&ut=8dec03ba335b81bf4ebdf7b29ec27d15&pn=1&np=1&dect=1&pz=20&_=1763519937379');

        $data = json_decode($response, true);

        $upNum = 0;
        $downNum = 0;
        $flatNum = 0;

        foreach ($data['data']['diff'] as $item) {
            $upNum += $item['f104'];
            $downNum += $item['f105'];
            $flatNum += $item['f106'];
        }

        $record = DailyProfit::where('date', $date)->first();

        if (!$record) {
            DailyProfit::create([
                'date' => $date,
                'up_num' => $upNum,
                'down_num' => $downNum,
                'flat_num' => $flatNum
            ]);
        } else {
            $record->up_num = $upNum;
            $record->down_num = $downNum;
            $record->flat_num = $flatNum;
            $record->save();
        }

        return 0;
    }

    /**
     * 检查是否为交易日
     */
    protected function checkTradingDay ($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        return !$date->isWeekend();
    }
}

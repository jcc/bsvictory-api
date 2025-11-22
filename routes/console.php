<?php

use App\Console\Commands\UpdateBidding;
use App\Console\Commands\UpdateDailyProfit;
use App\Console\Commands\UpdateIncAndDecNum;
use App\Console\Commands\UpdateSeconds;
use App\Console\Commands\UpdateYesterday;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateBidding::class)
    ->weekdays()
    ->everyFiveSeconds()
    ->between('09:26', '09:30');

Schedule::command(UpdateSeconds::class)
    ->weekdays()
    ->everyFiveSeconds()
    ->between('09:30', '15:01');

Schedule::command(UpdateYesterday::class)
    ->weekdays()
    ->dailyAt('09:26');

Schedule::command(UpdateDailyProfit::class)
    ->weekdays()
    ->dailyAt('09:29');

Schedule::command(UpdateIncAndDecNum::class)
    ->weekdays()
    ->dailyAt('15:01');

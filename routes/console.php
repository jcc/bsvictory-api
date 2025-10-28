<?php

use App\Console\Commands\UpdateBidding;
use App\Console\Commands\UpdateSeconds;
use App\Console\Commands\UpdateYesterday;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateYesterday::class)
    ->dailyAt('09:26');

Schedule::command(UpdateBidding::class)
    ->everyFiveSeconds()
    ->between('09:26', '09:30');

Schedule::command(UpdateSeconds::class)
    ->everyFiveSeconds()
    ->between('09:30', '15:00');

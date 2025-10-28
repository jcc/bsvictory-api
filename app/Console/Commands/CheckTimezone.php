<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTimezone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:timezone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display Laravel and server timezone settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('=== 时区信息检查 ===');

        // Laravel 应用时区
        $this->info('Laravel 应用时区: ' . config('app.timezone'));

        // PHP 默认时区
        $this->info('PHP 默认时区: ' . date_default_timezone_get());

        // 当前时间
        $this->info('当前时间 (Laravel): ' . now());
        $this->info('当前时间 (PHP): ' . date('Y-m-d H:i:s'));

        // 数据库时区 (MySQL 示例)
        // try {
        //     $dbTime = DB::select(DB::raw('SELECT NOW() as db_time'))[0]->db_time;
        //     $dbTz = DB::select(DB::raw('SELECT @@global.time_zone as global_tz, @@session.time_zone as session_tz'))[0];
        //     $this->info('数据库时间: ' . $dbTime);
        //     $this->info('数据库全局时区: ' . $dbTz->global_tz);
        //     $this->info('数据库会话时区: ' . $dbTz->session_tz);
        // } catch (\Exception $e) {
        //     $this->error('无法获取数据库时区信息: ' . $e->getMessage());
        // }

        $this->line('===================');

        return 0;
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('名字')->nullable();
            $table->string('name')->comment('代码')->nullable();
            $table->string('model')->comment('机器号')->nullable();
            $table->float('current_price')->comment('当前价格')->nullable();
            $table->string('profit')->comment('今开买获利')->nullable();
            $table->string('actual_profit')->comment('总收益')->nullable();
            $table->float('yesterday_close')->comment('昨收')->nullable();
            $table->float('open_price')->comment('今开')->nullable();
            $table->float('next_open')->comment('次日开')->nullable();
            $table->integer('volume')->comment('成交量(手)')->nullable();
            $table->integer('bid_volume')->comment('外盘(主动买入)')->nullable();
            $table->integer('ask_volume')->comment('内盘(主动卖出)')->nullable();
            $table->float('buy1_price')->comment('买1价')->nullable();
            $table->integer('buy1_volume')->comment('买1量（手）')->nullable();
            $table->float('buy2_price')->comment('买2价')->nullable();
            $table->integer('buy2_volume')->comment('买2量（手）')->nullable();
            $table->float('buy3_price')->comment('买3价')->nullable();
            $table->integer('buy3_volume')->comment('买3量（手）')->nullable();
            $table->float('buy4_price')->comment('买4价')->nullable();
            $table->integer('buy4_volume')->comment('买4量（手）')->nullable();
            $table->float('buy5_price')->comment('买5价')->nullable();
            $table->integer('buy5_volume')->comment('买5量（手）')->nullable();
            $table->float('sell1_price')->comment('卖1价')->nullable();
            $table->integer('sell1_volume')->comment('卖1量（手）')->nullable();
            $table->float('sell2_price')->comment('卖2价')->nullable();
            $table->integer('sell2_volume')->comment('卖2量（手）')->nullable();
            $table->float('sell3_price')->comment('卖3价')->nullable();
            $table->integer('sell3_volume')->comment('卖3量（手）')->nullable();
            $table->float('sell4_price')->comment('卖4价')->nullable();
            $table->integer('sell4_volume')->comment('卖4量（手）')->nullable();
            $table->float('sell5_price')->comment('卖5价')->nullable();
            $table->integer('sell5_volume')->comment('卖5量（手）')->nullable();
            $table->string('trade_time')->comment('最近逐笔成交')->nullable();
            $table->string('price_change')->comment('涨跌')->nullable();
            $table->string('price_change_percent')->comment('涨跌%')->nullable();
            $table->float('highest_price')->comment('最高')->nullable();
            $table->float('lowest_price')->comment('最低')->nullable();
            $table->string('turnover')->comment('换手率')->nullable();
            $table->string('open_turnover')->comment('开盘换手率')->nullable();
            $table->string('pe_ratio')->comment('市盈率')->nullable();
            $table->string('amplitude')->comment('振幅')->nullable();
            $table->string('total_market_value')->comment('总市值')->nullable();
            $table->string('circulating_market_value')->comment('流通市值')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}

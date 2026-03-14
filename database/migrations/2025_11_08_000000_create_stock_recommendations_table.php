<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_recommendations', function (Blueprint $table) {
            $table->id();
            $table->date('recommend_date')->comment('推荐日期');
            $table->enum('recommend_type', ['morning', 'afternoon', 'closing'])->comment('推荐类型');
            $table->integer('stock_rank')->comment('股票排名');
            $table->string('code', 20)->comment('股票代码');
            $table->string('name', 50)->nullable()->comment('股票名称');
            $table->decimal('last_price', 12, 4)->nullable()->comment('最新价格');
            $table->decimal('change_rate', 10, 4)->nullable()->comment('涨跌幅');
            $table->decimal('buy_low', 12, 4)->nullable()->comment('买入低价');
            $table->decimal('buy_high', 12, 4)->nullable()->comment('买入高价');
            $table->string('volume_feature', 50)->nullable()->comment('量能特征');
            $table->string('kline_shape', 50)->nullable()->comment('K线形态');
            $table->string('capital_flow', 50)->nullable()->comment('资金流向');
            $table->integer('score')->nullable()->index()->comment('评分');
            $table->decimal('pe_ratio', 12, 4)->nullable()->comment('市盈率');
            $table->decimal('pb_ratio', 12, 4)->nullable()->comment('市净率');
            $table->decimal('turnover_rate', 10, 6)->nullable()->comment('换手率');
            $table->decimal('total_market_val', 20, 2)->nullable()->comment('总市值');
            $table->bigInteger('snapshot_id')->nullable()->comment('快照ID');
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
        Schema::dropIfExists('stock_recommendations');
    }
}

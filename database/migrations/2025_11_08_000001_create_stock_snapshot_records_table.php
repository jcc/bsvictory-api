<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSnapshotRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_snapshot_records', function (Blueprint $table) {
            $table->id();
            $table->date('snapshot_date')->index()->comment('快照日期');
            $table->string('code', 20)->index()->comment('股票代码');
            $table->string('name', 50)->nullable()->comment('股票名称');
            $table->enum('record_type', ['morning', 'afternoon'])->default('morning')->comment('记录类型');
            $table->decimal('last_price', 12, 4)->nullable()->comment('最新价格');
            $table->decimal('open_price', 12, 4)->nullable()->comment('开盘价');
            $table->decimal('high_price', 12, 4)->nullable()->comment('最高价');
            $table->decimal('low_price', 12, 4)->nullable()->comment('最低价');
            $table->decimal('prev_close_price', 12, 4)->nullable()->comment('昨收价');
            $table->decimal('change_rate', 10, 4)->nullable()->comment('涨跌幅');
            $table->bigInteger('volume')->nullable()->comment('成交量');
            $table->decimal('turnover', 20, 2)->nullable()->comment('成交额');
            $table->decimal('turnover_rate', 10, 6)->nullable()->comment('换手率');
            $table->decimal('amplitude', 10, 6)->nullable()->comment('振幅');
            $table->decimal('avg_price', 12, 4)->nullable()->comment('均价');
            $table->decimal('volume_ratio', 10, 4)->nullable()->comment('量比');
            $table->decimal('ask_price', 12, 4)->nullable()->comment('卖一价');
            $table->decimal('bid_price', 12, 4)->nullable()->comment('买一价');
            $table->bigInteger('ask_vol')->nullable()->comment('卖一量');
            $table->bigInteger('bid_vol')->nullable()->comment('买一量');
            $table->decimal('pe_ratio', 12, 4)->nullable()->comment('市盈率');
            $table->decimal('pb_ratio', 12, 4)->nullable()->comment('市净率');
            $table->decimal('total_market_val', 20, 2)->nullable()->comment('总市值');
            $table->decimal('circular_market_val', 20, 2)->nullable()->comment('流通市值');
            $table->bigInteger('issued_shares')->nullable()->comment('总股本');
            $table->bigInteger('outstanding_shares')->nullable()->comment('流通股本');
            $table->decimal('highest52weeks_price', 12, 4)->nullable()->comment('52周最高价');
            $table->decimal('lowest52weeks_price', 12, 4)->nullable()->comment('52周最低价');
            $table->boolean('suspension')->nullable()->comment('是否停牌');
            $table->string('sec_status', 20)->nullable()->comment('证券状态');
            $table->date('listing_date')->nullable()->comment('上市日期');
            $table->datetime('update_time')->nullable()->comment('更新时间');
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
        Schema::dropIfExists('stock_snapshot_records');
    }
}

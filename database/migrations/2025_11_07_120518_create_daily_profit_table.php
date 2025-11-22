<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_profit', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable()->index()->comment('日期');
            $table->decimal('profit', 15, 4)->default(0)->comment('利润（平均）');
            $table->decimal('total_profit', 15, 4)->default(0)->comment('总利润');
            $table->integer('stock_count')->default(0)->comment('股票数量');
            $table->integer('profit_stock_count')->default(0)->comment('获利股票数量');
            $table->integer('loss_stock_count')->default(0)->comment('亏损股票数量');
            $table->integer('up_num')->default(0)->comment('当日盘面上涨数量');
            $table->integer('down_num')->default(0)->comment('当日盘面下跌数量');
            $table->integer('flat_num')->default(0)->comment('当日盘面平数量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_profit');
    }
};

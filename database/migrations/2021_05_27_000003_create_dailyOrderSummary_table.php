<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOrderSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('dailyOrderSummary', function (Blueprint $table) {
                $table->id();
                $table->integer('type')->default(-1)->comment('遊戲類型');
                $table->integer('currency')->default(-1)->comment('幣別');
                $table->string('transactionDate', 24)->default('')->comment('結算日期');
                $table->integer('orderCount')->default(0)->comment('總單量');
                $table->double('totalWin')->default(0)->comment('總贏分');
                $table->double('bet')->default(0)->comment('總投注額');
                $table->double('totalPayout')->default(0)->comment('總派彩');
                $table->timestamp('createdAt')->nullable();
                $table->timestamp('updatedAt')->nullable();
            });
        } catch (\Exception $exception) {
            $this->down();
            throw $exception;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailyOrderSummary');
    }
}

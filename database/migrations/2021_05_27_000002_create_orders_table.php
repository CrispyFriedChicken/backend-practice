<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->string('userUuid')->nullable();
                $table->string('gameUuid')->nullable();
                $table->foreign('userUuid')->references('uuid')->on('users');
                $table->foreign('gameUuid')->references('uuid')->on('games');
                $table->string('roundSerial', 20)->default('')->comment('局號');
                $table->string('orderSerial', 20)->unique()->default('')->comment('注單編號');
                $table->string('transactionDate', 24)->default('')->comment('下注時間');
                $table->string('code', 10)->default('')->comment('遊戲代號');
                $table->integer('type')->default(-1)->comment('遊戲類型');
                $table->string('email')->comment('信箱(帳號)');
                $table->integer('currency')->default(-1)->comment('幣別');
                $table->double('totalWin')->default(0)->comment('總贏分(原幣別)');
                $table->double('totalWinCny')->default(0)->comment('總贏分(人民幣)');
                $table->double('bet')->default(0)->comment('投注額(原幣別)');
                $table->double('betCny')->default(0)->comment('投注額(人民幣)');
                $table->double('totalPayout')->default(0)->comment('總派彩(原幣別)');
                $table->double('totalPayoutCny')->default(0)->comment('總派彩(人民幣)');
                $table->double('exchangeRate')->default(0)->comment('匯率(原幣別)');
                $table->double('exchangeRateCny')->default(0)->comment('匯率(人民幣)');
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
        Schema::dropIfExists('orders');
    }
}

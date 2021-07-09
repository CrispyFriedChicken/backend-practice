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
                $table->string('roundSerial', 20)->default('')->unique()->comment('局號');
                $table->string('orderSerial', 20)->unique()->default('')->comment('注單編號');
                $table->string('transactionDate', 24)->default('')->comment('下注時間');
                $table->string('code', 10)->default('')->comment('遊戲代號');
                $table->string('type', 30)->default('')->comment('遊戲類型');
                $table->string('email')->comment('信箱(帳號)');
                $table->string('currency', 10)->default('')->comment('幣別');
                $table->double('stake')->default(0)->comment('投注額(原幣別)');
                $table->double('stakeCny')->default(0)->comment('投注額(人民幣)');
                $table->double('winning')->default(0)->comment('派彩(原幣別)');
                $table->double('winningCny')->default(0)->comment('派彩(人民幣)');
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

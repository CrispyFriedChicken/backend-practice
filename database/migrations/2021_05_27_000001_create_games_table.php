<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->string('chineseName',100)->default('')->unique()->comment('中文名稱');
                $table->string('englishName',100)->default('')->unique()->comment('英文名稱');
                $table->string('code',10)->default('')->unique()->comment('遊戲代號');
                $table->string('type',30)->default('')->comment('遊戲類型');
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
        Schema::dropIfExists('games');
    }
}

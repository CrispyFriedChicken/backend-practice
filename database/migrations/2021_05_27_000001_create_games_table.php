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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 40)->default('')->unique();
            $table->string('chineseName')->default('')->unique()->comment('中文名稱');
            $table->string('englishName')->default('')->unique()->comment('英文名稱');
            $table->string('code')->default('')->unique()->comment('遊戲代號');
            $table->string('type')->default('')->comment('遊戲類型');
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
        Schema::dropIfExists('games');
    }
}

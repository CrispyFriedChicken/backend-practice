<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('serialSetting', function (Blueprint $table) {
                $table->id();
                $table->string('identifier')->default('')->comment('識別碼');
                $table->string('prefix')->default('')->comment('前贅詞');
                $table->string('dateRule', 24)->default('')->comment('日期格式');
                $table->integer('length')->default(3)->comment('流水號長度');
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
        Schema::dropIfExists('serialSetting');
    }
}

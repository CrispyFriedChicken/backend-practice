<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('serialControl', function (Blueprint $table) {
                $table->id();
                $table->string('identifier')->default('')->comment('識別碼');
                $table->string('date')->default('')->comment('日期');
                $table->integer('latest')->default(0)->comment('最新的流水號');
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
        Schema::dropIfExists('serialControl');
    }
}

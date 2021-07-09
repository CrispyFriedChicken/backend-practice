<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name',100)->comment('玩家名稱');
            $table->string('role',30)->comment('角色');
            $table->string('email',100)->unique()->comment('玩家帳號(信箱)');
            $table->string('password')->comment('密碼');
            $table->string('currency',10)->default('')->comment('幣別');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->string('telephone',11)->default('')->comment('手机号');
            $table->tinyInteger('status')->default(1)->comment('状态 1=激活 2=禁用');
            $table->tinyInteger('is_vip')->default(0)->comment('状态 1=是 0=否');
            $table->string('wechat_openid',512)->default('')->comment('微信openid');
            $table->string('wechat_nickname',512)->default('')->comment('微信nickname');
            $table->string('wechat_avatar',512)->default('')->comment('微信avatar');
            $table->text('wechat_original')->comment('微信原始数据');
            $table->integer('recommend_id')->default(0)->comment('推荐人id');
            $table->decimal('can_use_money',10,2)->default(0.00)->comment('可提现押金');
            $table->decimal('not_can_use_money',10,2)->default(0.00)->comment('冻结的押金');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

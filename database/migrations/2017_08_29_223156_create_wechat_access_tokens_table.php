<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_access_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('access_token',255)->default('')->comment('微信access_token');
            $table->integer('expires_in')->default(0)->comment('过期时间');
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
        Schema::dropIfExists('wechat_access_tokens');
    }
}

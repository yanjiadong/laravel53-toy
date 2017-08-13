<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',32)->default('')->comment('订单编号');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('good_id')->default(0)->comment('玩具id');
            $table->string('good_title',255)->default('')->comment('玩具标题');
            $table->string('good_picture',255)->default('')->comment('玩具图片');
            
            $table->tinyInteger('status')->default(0)->comment('订单状态');
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
        Schema::dropIfExists('orders');
    }
}

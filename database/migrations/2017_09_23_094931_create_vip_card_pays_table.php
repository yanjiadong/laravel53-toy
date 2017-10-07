<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVipCardPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_card_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('vip_card_id')->default(0);
            $table->tinyInteger('vip_card_type')->default(0)->comment('会员卡类型');
            $table->tinyInteger('pay_status')->default(0)->comment('0未支付 1支付成功');
            $table->tinyInteger('status')->default(1)->comment('1正常 -1过期 -2申请提现中 -3提现完成');
            $table->integer('days')->default(0)->comment('天数');
            $table->decimal('price',10,2)->default(0.00)->comment('订单总价');
            $table->decimal('money',10,2)->default(0.00)->comment('押金');
            $table->string('order_code',64)->default('')->comment('订单编号');
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
        Schema::dropIfExists('vip_card_pays');
    }
}

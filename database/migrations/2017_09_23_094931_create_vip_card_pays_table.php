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
            $table->tinyInteger('pay_status')->default(0)->comment('0未支付 1支付成功');
            $table->tinyInteger('status')->default(1)->comment('1正常 -1过期');
            $table->integer('days')->default(0)->comment('天数');
            $table->decimal('price',10,2)->default(0.00)->comment('价格');
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

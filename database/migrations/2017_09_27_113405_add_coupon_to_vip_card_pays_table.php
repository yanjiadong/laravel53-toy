<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponToVipCardPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vip_card_pays', function (Blueprint $table) {
            $table->decimal('coupon_price',10,2)->comment('优惠券优惠金额')->default('0.00');
            $table->integer('user_coupon_id')->comment('用户优惠券id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vip_card_pays', function (Blueprint $table) {
            $table->dropColumn('coupon_price');
            $table->dropColumn('user_coupon_id');
        });
    }
}

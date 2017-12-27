<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToUserCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            $table->tinyInteger('coupon_type')->default(0)->comment('类型 1=任意金额 2=满减');
            $table->integer('coupon_price')->default(0)->comment('优惠金额');
            $table->integer('coupon_days')->default(0)->comment('优惠券有效天数');
            $table->string('coupon_title',64)->default('')->comment('名称');
            $table->date('start_time')->comment('开始时间');
            $table->date('end_time')->comment('结束时间');
            $table->integer('condition')->default(0)->comment('满多少');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            $table->dropColumn('coupon_type');
            $table->dropColumn('coupon_price');
            $table->dropColumn('coupon_days');
            $table->dropColumn('coupon_title');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('condition');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('days')->default(0)->comment('租用天数');
            $table->decimal('good_day_price',10,1)->default(0.0)->comment('每日租金');
            $table->decimal('total_price',10,2)->default(0.00)->comment('租金');
            $table->dateTime('start_time')->nullable()->comment('租用开始时间');
            $table->dateTime('end_time')->nullable()->comment('租用结束时间');
            $table->tinyInteger('is_use_zhima')->default(0)->comment('是否使用芝麻减免');
            $table->tinyInteger('coupon_id')->default(0)->comment('优惠券id');
            $table->decimal('coupon_price',10,2)->default(0.00)->comment('优惠券减免金额');
            $table->decimal('zhima_price',10,2)->default(0.00)->comment('芝麻分减免的押金金额');
            $table->tinyInteger('money_status')->default(0)->comment('押金状态 0=未申请 1=申请中 2=提现成功');
            $table->tinyInteger('over_days')->default(0)->comment('逾期天数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('days');
            $table->dropColumn('good_day_price');
            $table->dropColumn('total_price');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('is_use_zhima');
            $table->dropColumn('coupon_id');
            $table->dropColumn('coupon_price');
            $table->dropColumn('zhima_price');
            $table->dropColumn('money_status');
            $table->dropColumn('over_days');
        });
    }
}

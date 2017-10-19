<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplyTimeToVipCardPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vip_card_pays', function (Blueprint $table) {
            $table->dateTime('apply_time')->nullable()->comment('申请提现时间');
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
            $table->dropColumn('apply_time');
        });
    }
}

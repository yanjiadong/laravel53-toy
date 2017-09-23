<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVipCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('会员卡名称');
            $table->integer('price')->default(0)->comment('押金');
            $table->integer('days')->default(0)->comment('有效天数');
            $table->integer('money')->default(0)->comment('所需押金');
            $table->tinyInteger('type')->default(0)->comment('类型 1月卡 2季度卡  3半年卡');
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
        Schema::dropIfExists('vip_cards');
    }
}

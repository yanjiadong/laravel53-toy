<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('province_id')->default(0)->comment('省份');
            $table->integer('city_id')->default(0)->comment('城市');
            $table->integer('area_id')->default(0)->comment('区域');
            $table->string('address',255)->default('')->comment('地址');
            $table->string('receiver',64)->default('')->comment('收货人');
            $table->string('receiver_telephone',11)->default('')->comment('收货人手机号');
            $table->tinyInteger('is_default')->default(0)->comment('是否默认 0=否 1=是');
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
        Schema::dropIfExists('user_addresses');
    }
}

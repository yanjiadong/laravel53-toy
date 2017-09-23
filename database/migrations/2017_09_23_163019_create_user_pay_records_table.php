<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPayRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pay_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('');
            $table->tinyInteger('type')->default(1)->comment('类型 1=押金');
            $table->tinyInteger('pay_type')->default(1)->comment('类型 1=充值 2=提现');
            $table->decimal('price',10,2)->default(0.00)->comment('金额');
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
        Schema::dropIfExists('user_pay_records');
    }
}

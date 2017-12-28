<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->string('express',64)->default('')->comment('配送方式');
            $table->tinyInteger('days')->default(0)->comment('几天后发货');
            $table->integer('express_price')->default(0)->comment('运费');
            $table->decimal('free_price',10,2)->default(0.00)->comment('满多少减免来回运费');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('express');
            $table->dropColumn('days');
            $table->dropColumn('express_price');
            $table->dropColumn('free_price');
        });
    }
}

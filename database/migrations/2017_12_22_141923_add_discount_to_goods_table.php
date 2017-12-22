<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->tinyInteger('is_discount')->default(0)->comment('是否促销 1=促销 0=不促销');
            $table->decimal('discount1',10,1)->default(0.0);
            $table->decimal('discount2',10,1)->default(0.0);
            $table->decimal('discount3',10,1)->default(0.0);
            $table->decimal('discount4',10,1)->default(0.0);
            $table->decimal('discount5',10,1)->default(0.0);
            $table->decimal('discount6',10,1)->default(0.0);
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
            $table->dropColumn('is_discount');
            $table->dropColumn('discount1');
            $table->dropColumn('discount2');
            $table->dropColumn('discount3');
            $table->dropColumn('discount4');
            $table->dropColumn('discount5');
            $table->dropColumn('discount6');
        });
    }
}

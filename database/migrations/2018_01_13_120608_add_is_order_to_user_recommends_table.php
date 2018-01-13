<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsOrderToUserRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_recommends', function (Blueprint $table) {
            $table->tinyInteger('is_order')->default(0)->comment('1=已经下过单');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_recommends', function (Blueprint $table) {
            $table->dropColumn('is_order');
        });
    }
}

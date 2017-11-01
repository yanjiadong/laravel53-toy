<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZhimaScoreToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('zhima_score')->default(0)->comment('芝麻分');
            $table->dateTime('zhima_time')->nullable()->comment('授权获取芝麻分时间');
            $table->integer('is_zhima')->default(0)->comment('芝麻分是否授权过 1=授权过 0=从未');
            $table->string('zhima_open_id',64)->default('')->comment('芝麻open_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('zhima_score');
            $table->dropColumn('zhima_time');
            $table->dropColumn('is_zhima');
            $table->dropColumn('zhima_open_id');
        });
    }
}

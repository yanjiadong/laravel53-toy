<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZhimaFaceToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zhima_biz_no',255)->default('')->comment('芝麻人脸认证所需biz_no');
            $table->integer('biz_no_time')->default(0)->comment('芝麻人脸认证所需biz_no过期时间戳');
            $table->tinyInteger('zhima_face')->default(0)->comment('芝麻人脸认证 1=通过 0=未通过');
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
            $table->dropColumn('zhima_biz_no');
            $table->dropColumn('biz_no_time');
            $table->dropColumn('zhima_face');
        });
    }
}

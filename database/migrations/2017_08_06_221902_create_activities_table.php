<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',521)->default('')->comment('活动链接');
            $table->string('picture',255)->default('')->comment('活动图片');
            $table->tinyInteger('type')->default(1)->comment('活动类型 1=运营活动');
            $table->string('title',64)->default('')->comment('活动标题');
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
        Schema::dropIfExists('activities');
    }
}

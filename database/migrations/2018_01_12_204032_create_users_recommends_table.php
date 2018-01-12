<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_recommends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->default(0)->comment('推荐人');
            $table->integer('to_user_id')->default(0)->comment('推荐人');
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
        Schema::dropIfExists('user_recommends');
    }
}

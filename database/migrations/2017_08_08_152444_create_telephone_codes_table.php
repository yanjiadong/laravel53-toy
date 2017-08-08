<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelephoneCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephone_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->default(0)->comment('验证码');
            $table->string('telephone',11)->default('')->comment('手机号');
            $table->tinyInteger('is_used')->default(1)->comment('是否使用 1=未使用 2=已使用');
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
        Schema::dropIfExists('telephone_codes');
    }
}

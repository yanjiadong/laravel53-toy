<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJuheStatusToExpressInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('express_infos', function (Blueprint $table) {
            $table->tinyInteger('juhe_status')->default(0)->comment('聚合快递查询状态 1=不再变化 0=变化');
            $table->tinyInteger('type')->default(0)->comment('0=老版本 1=聚合快递');
            $table->text('juhe_content')->comment('查询内容');
            $table->text('juhe_content_list')->comment('查询内容');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('express_infos', function (Blueprint $table) {
            $table->dropColumn('juhe_status');
            $table->dropColumn('juhe_content');
            $table->dropColumn('juhe_content_list');
            $table->dropColumn('type');
        });
    }
}

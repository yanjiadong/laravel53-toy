<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',64)->default('')->comment('商品名称');
            $table->decimal('price', 10, 2)->default(0.00)->comment('市场价');
            $table->integer('category_id')->default(0)->comment('分类id');
            $table->integer('category_tag_id')->default(0)->comment('分类标签id');
            $table->string('brand',64)->default('')->comment('品牌');
            $table->string('brand_country',64)->default('')->comment('品牌所属');
            $table->string('material',64)->default('')->comment('材质');
            $table->string('weight',64)->default('')->comment('重量');
            $table->string('effect',64)->default('')->comment('作用');
            $table->string('way',64)->default('')->comment('消毒方式');
            $table->text('desc')->comment('商品描述');
            $table->integer('store')->default(0)->comment('库存');
            $table->string('picture',255)->default('')->comment('封面图');
            $table->string('video',255)->default('')->comment('视频地址');
            $table->tinyInteger('is_new')->default(0)->comment('是否新品');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热门');
            $table->tinyInteger('status')->default(1)->comment('1=上架 2=下架');
            $table->integer('sort')->default(100)->comment('排序编号');
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
        Schema::dropIfExists('goods');
    }
}

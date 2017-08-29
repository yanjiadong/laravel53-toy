<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',32)->default('')->comment('订单编号');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('good_id')->default(0)->comment('玩具id');
            $table->string('good_title',255)->default('')->comment('玩具标题');
            $table->string('good_picture',255)->default('')->comment('玩具图片');
            $table->decimal('good_price', 10, 2)->default(0.00)->comment('商品市场价');
            $table->tinyInteger('category_id')->default(0)->comment('商品分类id');
            $table->tinyInteger('category_tag_id')->default(0)->comment('商品分类id');
            $table->tinyInteger('good_brand_id')->default(0)->comment('商品品牌id');
            $table->decimal('express_price',10,2)->default(0.00)->comment('邮费');
            $table->decimal('clean_price',10,2)->default(0.00)->comment('包装清理费');
            $table->decimal('price',10,2)->default(0.00)->comment('订单合计');
            $table->decimal('money',10,2)->default(0.00)->comment('押金');
            $table->integer('address_id')->default(0)->comment('地址id');
            $table->string('receiver',64)->default('')->comment('收货人');
            $table->string('receiver_telephone',11)->default('')->comment('收货人电话');
            $table->string('receiver_address',255)->default('')->comment('收货人地址');
            $table->string('express_title',32)->default('')->comment('快递公司名称');
            $table->string('express_com',32)->default('')->comment('快递100编码');
            $table->string('express_no',64)->default('')->comment('运单号');
            $table->tinyInteger('status')->default(0)->comment('订单状态');
            $table->tinyInteger('back_status')->default(0)->comment('回寄状态');
            $table->string('back_express_title',32)->default('')->comment('回寄快递公司名称');
            $table->string('back_express_com',32)->default('')->comment('回寄快递100编码');
            $table->string('back_express_no',64)->default('')->comment('回寄运单号');
            $table->dateTime('confirm_time')->comment('确认收货时间');
            $table->dateTime('back_time')->comment('提交完成寄回物流信息时间');
            $table->string('month','32')->default('')->comment('下单的年月');
            $table->tinyInteger('pay_type')->default(1)->comment('支付方式 1微信');
            $table->string('out_trade_no',32)->default('')->comment('支付订单号');
            $table->dateTime('pay_success_time')->comment('支付成功时间');
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
        Schema::dropIfExists('orders');
    }
}

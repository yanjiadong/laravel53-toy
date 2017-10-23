<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['code','user_id','good_id','good_title','good_picture','good_price','category_id','category_tag_id','express_price','clean_price',
    'price','money','address_id','receiver','receiver_telephone','receiver_address','express_title','express_com','express_no','status','back_status',
        'back_express_title','back_express_com','back_express_no','confirm_time','back_time','month','pay_type','out_trade_no','pay_success_time','receiver_province','receiver_city','receiver_area','good_brand_id','good_old','send_time','user_telephone'];
    //status   0未支付 1待发货  2已发货  3租用中 4已归还 -1已取消
    const STATUS_UNPAY = 0;
    const STATUS_WAITING_SEND = 1;
    const STATUS_SEND = 2;
    const STATUS_DOING = 3;
    const STATUS_BACK = 4;
    const STATUS_CANCEL = -1;

    const STATUS_WAITING_SEND_STR = '待发货';
    const STATUS_SEND_STR = '已发货';
    const STATUS_DOING_STR = '租用中';
    const STATUS_BACK_STR = '已归还';
    const STATUS_CANCEL_STR = '已取消';

    //back_status   0待验证  1已验证
    const BACK_STATUS_WAITING = 0;
    const BACK_STATUS_DOING = 1;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function category_tag()
    {
        return $this->belongsTo(CategoryTag::class);
    }

    public function good_brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getStatusAttribute($value)
    {
        switch ($value)
        {
            case -1:
                $str = '已取消';
                break;
            case 0:
                $str = '未支付';
                break;
            case 1:
                $str = '待发货';
                break;
            case 2:
                $str = '已发货';
                break;
            case 3:
                $str = '租用中';
                break;
            case 4:
                $str = '已归还';
                break;
        }
        return $str;
    }

    public function getBackStatusAttribute($value)
    {
        switch ($value)
        {
            case 0:
                $str = '待验证';
                break;
            case 1:
                $str = '已验证';
                break;
        }
        return $str;
    }
}

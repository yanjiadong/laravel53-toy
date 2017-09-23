<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VipCardPay extends Model
{
    protected $table = 'vip_card_pays';
    protected $fillable = ['user_id','vip_card_id','days','price','status','pay_status','order_code','money'];
}

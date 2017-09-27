<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChooseCoupon extends Model
{
    protected $table = 'user_choose_coupons';
    protected $fillable = ['user_id','coupon_id'];
}

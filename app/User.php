<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'wechat_openid', 'wechat_original', 'wechat_nickname', 'wechat_avatar', 'is_vip', 'can_use_money', 'not_can_use_money', 'telephone', 'open_num', 'days','zhima_score', 'zhima_time', 'is_zhima', 'zhima_open_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function carts()
    {
        return $this->belongsToMany(Good::class,'carts','user_id','good_id');
    }

    public function addCart($good_id)
    {
        return $this->carts()->toggle($good_id);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class,'user_coupons','user_id','coupon_id');
    }
}

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
        'name', 'email', 'password', 'wechat_openid', 'wechat_original', 'wechat_nickname', 'wechat_avatar'
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
}

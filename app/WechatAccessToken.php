<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WechatAccessToken extends Model
{
    protected $table = 'wechat_access_tokens';
    protected $fillable = ['access_token','expires_in'];
}

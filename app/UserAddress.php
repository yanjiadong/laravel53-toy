<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';
    protected $fillable = ['address','user_id','province_id','city_id','area_id','is_default','receiver','receiver_telephone'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayRecord extends Model
{
    protected $table = 'user_pay_record';
    protected $fillable = ['user_id','type','pay_type','price'];
}

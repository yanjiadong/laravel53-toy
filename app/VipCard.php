<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VipCard extends Model
{
    protected $table = 'vip_cards';
    protected $fillable = ['title','price','money','days','type'];

}

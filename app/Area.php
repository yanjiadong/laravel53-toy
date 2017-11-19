<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = ['name','area','fid','first'];

    public $timestamps = false;

    const TYPE_AREA_PROVINCE = 2;  //省
    const TYPE_AREA_CITY = 3;  //市
    const TYPE_AREA_AREA = 4;  //区
}

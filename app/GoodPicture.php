<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodPicture extends Model
{
    protected $table = 'good_pictures';
    protected $fillable = ['good_id','picture'];

    public $timestamps = false;
}

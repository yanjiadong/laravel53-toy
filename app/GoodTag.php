<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodTag extends Model
{
    protected $table = 'good_tags';
    protected $fillable = ['good_id','tag_id'];
}

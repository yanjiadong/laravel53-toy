<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZmxyScore extends Model
{
    protected $table = 'zmxy_scores';
    protected $fillable = ['user_id','info'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zmxy extends Model
{
    protected $table = 'zmxies';
    protected $fillable = ['user_id','info'];
}

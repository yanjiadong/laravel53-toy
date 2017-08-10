<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{
    protected $table = 'expresses';
    protected $fillable = ['title','com'];
}

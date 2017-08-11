<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpressInfo extends Model
{
    protected $table = 'express_infos';
    protected $fillable = ['nu','content','state'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelephoneCode extends Model
{
    protected $table = 'telephone_codes';
    protected $fillable = ['code','telephone','is_used'];
}

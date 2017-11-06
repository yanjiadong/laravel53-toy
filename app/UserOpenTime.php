<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOpenTime extends Model
{
    protected $table = 'user_open_times';
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

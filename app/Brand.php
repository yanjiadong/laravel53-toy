<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['title','category_id'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

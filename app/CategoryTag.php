<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTag extends Model
{
    protected $table = 'category_tags';
    protected $fillable = ['title','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

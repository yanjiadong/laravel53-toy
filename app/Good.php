<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'goods';
    //protected $fillable = ['title','price','category_id','category_tag_id','brand_id','brand_country','material','weight','effect','way','desc','store','picture','category_picture','is_new','is_hot','status','sort','video','video_second','old'];

    protected $guarded = [];  //排除不能插入数据库的字段

    const STATUS_ON_SALE = 1;  //上架状态
    const STATUS_UN_SALE = 2;  //下架状态

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function category_tag()
    {
        return $this->belongsTo(CategoryTag::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function pictures()
    {
        return $this->hasMany(GoodPicture::class);
    }

    public function tags()
    {
        return $this->hasMany(GoodTag::class);
    }


}

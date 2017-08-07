<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Category;
use App\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $categorys = Category::all();
        $banners = Banner::all();
        $new_goods = Good::with(['category_tag'])->where(['is_new'=>1,'status'=>Good::STATUS_ON_SALE])->first();
        $goods = Good::with(['category_tag'])->limit(4)->get();

        return ['code'=>200,'msg'=>['categorys'=>$categorys,'banners'=>$banners,'new_goods'=>$new_goods,'goods'=>$goods]];
    }
}

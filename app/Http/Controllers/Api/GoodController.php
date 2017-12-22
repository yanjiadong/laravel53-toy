<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Good;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodController extends BaseController
{
    /**
     * 获取商品详情
     * @param Request $request
     * @return array
     */
    public function detail(Request $request)
    {
        $good_id = $request->get('good_id');
        $user_id = $request->get('user_id');

        $good = Good::with(['tags','pictures','brand'])->where('id',$good_id)->first();

        $tags = [];
        if(!empty($good->tags))
        {
            foreach ($good->tags as $tag)
            {
                $tag = Tag::find($tag->tag_id);

                $tags[]= ['title'=>$tag->title,'desc'=>$tag->desc];
            }
        }

        $good->desc_new = filterHtmlTag($good->desc);

        //获取购物车数量
        $cart_num = Cart::where('user_id',$user_id)->count();
        $this->ret['info'] = ['good'=>$good,'tags'=>$tags,'cart_num'=>$cart_num];
        return $this->ret;
    }

    public function info($good_id)
    {
        $good = Good::with(['tags','pictures','brand'])->where('id',$good_id)->first();

        $tags = [];
        if(!empty($good->tags))
        {
            foreach ($good->tags as $tag)
            {
                $tag = Tag::find($tag->tag_id);

                $tags[]= ['title'=>$tag->title,'desc'=>$tag->desc];
            }
        }

        $good->desc_new = filterHtmlTag($good->desc);

        //获取购物车数量
        $cart_num = Cart::where('user_id',$good->user_id)->count();
        $this->ret['info'] = ['good'=>$good,'tags'=>$tags,'cart_num'=>$cart_num];
        return $this->ret;
    }

    public function get_day_price(Request $request)
    {
        $good_id = $request->get('good_id');
        $days = $request->get('days');

        $good = Good::select('price','day_price')->where('id',$good_id)->first();

        $price = $good->day_price;
        if($days >= 8 && $days <= 60)
        {
            $price = getGoodPriceByDays($good->price,$days);
        }

        $price = sprintf("%.2f", $price);
        $this->ret['info'] = ['price'=>$price,'days'=>$days];
        return $this->ret;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Good;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodController extends BaseController
{
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
        $this->ret['info'] = ['good'=>$good,'tags'=>$tags];
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

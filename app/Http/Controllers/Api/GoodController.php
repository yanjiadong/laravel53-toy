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
        $good = Good::with(['tags','pictures'])->where('id',$good_id)->first();

        $tags = [];
        if(!empty($good->tags))
        {
            foreach ($good->tags as $tag)
            {
                $tag = Tag::find($tag->tag_id);

                $tags[]= ['title'=>$tag->title,'desc'=>$tag->desc];
            }
        }
        $this->ret['info'] = ['good'=>$good,'tags'=>$tags];
        return $this->ret;
    }
}

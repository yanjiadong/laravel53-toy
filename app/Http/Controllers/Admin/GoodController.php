<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\CategoryTag;
use App\Good;
use App\GoodPicture;
use App\GoodTag;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $goods = Good::with(['category','brand'])->paginate(20);
        dd($goods);
        $menu = 'good';
        //dd($goods);
        return view('admin.good.index',compact('goods','username','menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'good';

        $categorys = Category::all();
        $tags = Tag::all();

        return view('admin.good.create',compact('categorys','username','menu','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tags = $data['tags'];
        $pics = $data['pics'];
        unset($data['tags']);
        unset($data['pics']);
        $data['status'] = Good::STATUS_ON_SALE;

        $good = Good::create($data);

        if(!empty($pics))
        {
            $pics_arr = explode(',',$pics);
            foreach ($pics_arr as $picture)
            {
                GoodPicture::create(['good_id'=>$good->id,'picture'=>$picture]);
            }
        }

        if(!empty($tags))
        {
            foreach ($tags as $tag)
            {
                GoodTag::create(['good_id'=>$good->id,'tag_id'=>$tag]);
            }
        }

        return alert(route('goods.index'),1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];
        $menu = 'good';

        $good = Good::findOrFail($id);

        $categorys = Category::all();
        $tags = Tag::all();

        //获取已选分类的标签列表
        $brands = Brand::where('category_id',$good->category_id)->get();

        //获取商品的已选标签
        $tags_seleted = GoodTag::where('good_id',$good->id)->get();
        $tags_arr = [];
        if(!empty($tags_seleted))
        {
            foreach ($tags_seleted as $tag)
            {
                $tags_arr[] = $tag->tag_id;
            }
        }

        //获取商品的图片列表
        $pictures_seleted = GoodPicture::where('good_id',$good->id)->get();
        $picJson = '';
        if(!empty($pictures_seleted))
        {
            $picJson = "[";
            foreach($pictures_seleted as $v) $picJson .= '{"url":"'.$v->picture.'"},';
            $picJson = chop($picJson,',') . "]";
        }

        return view('admin.good.edit',compact('username','menu','good','tags','categorys','brands','tags_arr','picJson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $tags = $data['tags'];
        $pics = $data['pics'];
        unset($data['tags']);
        unset($data['pics']);
        unset($data['_method']);
        $data['status'] = Good::STATUS_ON_SALE;

        $good = Good::where('id',$id)->update($data);

        GoodPicture::where('good_id',$id)->delete();
        if(!empty($pics))
        {
            $pics_arr = explode(',',$pics);
            foreach ($pics_arr as $picture)
            {
                GoodPicture::create(['good_id'=>$id,'picture'=>$picture]);
            }
        }

        GoodTag::where('good_id',$id)->delete();
        if(!empty($tags))
        {
            foreach ($tags as $tag)
            {
                GoodTag::create(['good_id'=>$id,'tag_id'=>$tag]);
            }
        }

        return alert(route('goods.index'),1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Good::destroy($id);
        GoodTag::where('good_id',$id)->delete();
        GoodPicture::where('good_id',$id)->delete();

        return alert('',1);
    }

    public function action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['status'=>$request->get('status')]);
        return alert('',1);
    }
}

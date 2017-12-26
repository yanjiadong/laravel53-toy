<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Cart;
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
    public function index(Request $request)
    {
        $admin_info = $this->get_session_info();
        $username = $admin_info['username'];

        $category_id = $request->get('category_id');
        $brand_id = $request->get('brand_id');

        $brands = [];
        if($category_id)
        {
            $where['category_id'] = $category_id;
            if($brand_id)
            {
                $where['brand_id'] = $brand_id;
            }
            $goods = Good::with(['category','brand'])->where($where)->orderBy('sort','asc')->paginate();

            $brands = Brand::where('category_id',$category_id)->get();
        }
        else
        {
            $goods = Good::with(['category','brand'])->orderBy('sort','asc')->paginate(20);
        }

        //分页需要的参数
        $goods->appends([
            'category_id'=>$category_id,
            'brand_id'=>$brand_id,
        ]);
        //dd($goods);
        //echo $url;
        $current_url = url()->full();
        session(['current_url'=>$current_url]);

        //dd($goods);
        $menu = 'good';
        $categorys = Category::all();
        //dd($goods);
        return view('admin.good.index',compact('goods','username','menu','category_id','categorys','brands','brand_id'));
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
        //$tags = $data['tags'];
        $pics = $data['pics'];
        //unset($data['tags']);
        unset($data['pics']);
        $data['status'] = Good::STATUS_ON_SALE;

        $data['day_price'] = 0;
        if($data['is_discount'] == 1)
        {
            //促销
            if($data['discount3'] > 0)
            {
                $data['day_price'] = $data['discount3'];
            }
            else
            {
                $data['discount3'] = getGoodPriceByDays($data['price'],21);
            }

            if($data['discount1'] <= 0)
            {
                $data['discount1'] = getGoodPriceByDays($data['price'],7);
            }

            if($data['discount2'] <= 0)
            {
                $data['discount2'] = getGoodPriceByDays($data['price'],14);
            }

            if($data['discount4'] <= 0)
            {
                $data['discount4'] = getGoodPriceByDays($data['price'],30);
            }

            if($data['discount5'] <= 0)
            {
                $data['discount5'] = getGoodPriceByDays($data['price'],45);
            }

            if($data['discount6'] <= 0)
            {
                $data['discount6'] = getGoodPriceByDays($data['price'],60);
            }
        }

        if($data['day_price']<=0)
        {
            $data['day_price'] = getGoodPriceByDays($data['price'],21);
        }


        $good = Good::create($data);

        if(!empty($pics))
        {
            $pics_arr = explode(',',$pics);
            foreach ($pics_arr as $picture)
            {
                GoodPicture::create(['good_id'=>$good->id,'picture'=>$picture]);
            }
        }

        /*if(!empty($tags))
        {
            foreach ($tags as $tag)
            {
                GoodTag::create(['good_id'=>$good->id,'tag_id'=>$tag]);
            }
        }*/

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
        //$tags = $data['tags'];
        $pics = $data['pics'];
        //unset($data['tags']);
        unset($data['pics']);
        unset($data['_method']);
        //$data['status'] = Good::STATUS_ON_SALE;

        $data['day_price'] = 0;
        if($data['is_discount'] == 1)
        {
            //促销
            if($data['discount3'] > 0)
            {
                $data['day_price'] = $data['discount3'];
            }
            else
            {
                $data['discount3'] = getGoodPriceByDays($data['price'],21);
            }

            if($data['discount1'] <= 0)
            {
                $data['discount1'] = getGoodPriceByDays($data['price'],7);
            }

            if($data['discount2'] <= 0)
            {
                $data['discount2'] = getGoodPriceByDays($data['price'],14);
            }

            if($data['discount4'] <= 0)
            {
                $data['discount4'] = getGoodPriceByDays($data['price'],30);
            }

            if($data['discount5'] <= 0)
            {
                $data['discount5'] = getGoodPriceByDays($data['price'],45);
            }

            if($data['discount6'] <= 0)
            {
                $data['discount6'] = getGoodPriceByDays($data['price'],60);
            }
        }
        else
        {
            $data['discount1'] = 0;
            $data['discount2'] = 0;
            $data['discount3'] = 0;
            $data['discount4'] = 0;
            $data['discount5'] = 0;
            $data['discount6'] = 0;
        }

        if($data['day_price']<=0)
        {
            $data['day_price'] = getGoodPriceByDays($data['price'],21);
        }

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

        /*GoodTag::where('good_id',$id)->delete();
        if(!empty($tags))
        {
            foreach ($tags as $tag)
            {
                GoodTag::create(['good_id'=>$id,'tag_id'=>$tag]);
            }
        }*/

        if(session('current_url'))
        {
            $current_url = session('current_url');
        }
        else
        {
            $current_url = route('goods.index');
        }
        //echo $current_url;
        return alert($current_url,1);
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
        Cart::where('good_id',$id)->delete();
        GoodTag::where('good_id',$id)->delete();
        GoodPicture::where('good_id',$id)->delete();

        return alert('',1);
    }

    public function action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['status'=>$request->get('status')]);
        return alert('',1);
    }

    /**
     * 排序操作
     * @param Request $request
     */
    public function sort_action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['sort'=>$request->get('sort')]);
        return alert('',1);
    }

    /**
     * 库存操作
     * @param Request $request
     */
    public function store_action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['store'=>$request->get('store')]);
        return alert('',1);
    }

    /**
     * 是否设置新品操作
     * @param Request $request
     */
    public function new_action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['is_new'=>$request->get('status')]);
        return alert('',1);
    }

    /**
     * 是否设置热门操作
     * @param Request $request
     */
    public function hot_action(Request $request)
    {
        Good::where('id',$request->get('id'))->update(['is_hot'=>$request->get('status')]);
        return alert('',1);
    }

    public function get_discount(Request $request)
    {
        $price = $request->get('price');
        if(empty($price))
        {
            $data['discount1'] = '0.0';
            $data['discount2'] = '0.0';
            $data['discount3'] = '0.0';
            $data['discount4'] = '0.0';
            $data['discount5'] = '0.0';
            $data['discount6'] = '0.0';
        }
        else
        {
            $data['discount1'] = getGoodPriceByDays($price,7);
            $data['discount2'] = getGoodPriceByDays($price,14);
            $data['discount3'] = getGoodPriceByDays($price,21);
            $data['discount4'] = getGoodPriceByDays($price,30);
            $data['discount5'] = getGoodPriceByDays($price,45);
            $data['discount6'] = getGoodPriceByDays($price,60);
        }

        return $data;
    }
}

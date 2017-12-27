<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Good;
use App\Order;
use App\User;
use App\VipCardPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends BaseController
{
    /**
     * 新版购物车列表接口
     * @param Request $request
     * @return array
     */
    public function cart_list(Request $request)
    {
        $user_id = $request->get('user_id');

        $result = [];
        $carts = Cart::where('user_id',$user_id)->orderBy('id','desc')->get();
        if(count($carts) > 0)
        {
            foreach ($carts as $cart)
            {
                $result[] = Good::select('id','title','picture','store','price','old','day_price')->where('id',$cart->good_id)->first()->toArray();
            }
        }

        $this->ret['info'] = ['carts'=>$result];
        return $this->ret;
    }

    public function index(Request $request)
    {
        $user_id = $request->get('user_id');
        $user = User::find($user_id);

        $result = [];
        $carts = Cart::where('user_id',$user_id)->orderBy('id','desc')->get();
        if(count($carts) > 0)
        {
            foreach ($carts as $cart)
            {
                $result[] = Good::where('id',$cart->good_id)->first()->toArray();
            }
        }

        if($user->is_vip==1)
        {
            //判断是否已过期
            $num = VipCardPay::where('user_id',$user_id)->where('status',1)->where('pay_status',1)->count();
            if($num > 0)
            {
                //判断是否租用中的玩具
                $order = Order::whereIn('status',[Order::STATUS_WAITING_SEND,Order::STATUS_SEND,Order::STATUS_DOING])->where('user_id',$user_id)->get();
                if(count($order) > 0)
                {
                    $type = 3;
                }
                else
                {
                    $type = 2;
                }
            }
            else
            {
                //已过期
                $type = 1;
            }
        }
        else
        {
            $type = 1;
        }

        $rent = false;
        if($type == 3)
        {
            //true为该账户有租用商品
            $rent = true;
        }

        $this->ret['info'] = ['carts'=>$result,'type'=>$type,'rent'=>$rent];
        return $this->ret;
    }

    public function add(Request $request)
    {
        $user_id = $request->get('user_id');
        $good_id = $request->get('good_id');

        $cart = Cart::where(['user_id'=>$user_id,'good_id'=>$good_id])->first();
        if(!empty($cart))
        {
            $this->ret['code'] = 300;
            $this->ret['msg'] = '已添加成功，请在玩具箱中查看';
            return $this->ret;
        }
        $user = User::find($user_id);
        $user->addCart($good_id);

        $count = Cart::where(['user_id'=>$user_id])->count();
        $this->ret['info'] = ['count'=>$count];
        return $this->ret;
    }

    public function delete(Request $request)
    {
        $user_id = $request->get('user_id');
        $good_id = $request->get('good_id');

        $user = User::find($user_id);
        $user->addCart($good_id);
        return $this->ret;
    }

    public function select_good(Request $request)
    {
        $good_id = $request->get('good_id');
        $good = Good::find($good_id);
        $this->ret['info'] = ['good_store'=>$good->store];
        return $this->ret;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->get('user_id');
        $user = User::find($user_id);
        $carts = $user->carts()->get();
        $this->ret['info'] = ['carts'=>$carts];
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
            $this->ret['msg'] = '该玩具已经在玩具箱,不能重复添加';
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
}

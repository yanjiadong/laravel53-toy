<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $ret = ['code'=>200,'msg'=>'操作成功','info'=>[]];
    public $time = null;
    public $datetime = null;

    public function __construct()
    {
        $this->time = time();
        $this->datetime = date('Y-m-d H:i:s',$this->time);
    }
}

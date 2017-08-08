<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $ret = ['code'=>200,'msg'=>'操作成功','info'=>[]];

}

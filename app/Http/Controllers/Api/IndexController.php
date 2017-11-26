<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Area;
use App\Banner;
use App\Brand;
use App\Category;
use App\CategoryTag;
use App\Express;
use App\Good;
use App\TelephoneCode;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;

class IndexController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        $categorys = Category::all();
        //$banners = Banner::all();
        $new_goods = Good::with(['brand'])->where(['is_new'=>1,'status'=>Good::STATUS_ON_SALE])->first();
        $goods = Good::with(['brand'])->where(['is_hot'=>1,'status'=>Good::STATUS_ON_SALE])->orderBy('sort','asc')->get();
        $activities = Activity::where('type',1)->get();

        $this->ret['info'] = ['categorys'=>$categorys,'new_goods'=>$new_goods,'goods'=>$goods,'activities'=>$activities];
        return $this->ret;
    }

    public function categories()
    {
        $categorys = Category::all();
        $this->ret['info'] = ['categorys'=>$categorys];
        return $this->ret;
    }

    public function banners()
    {
        $banners = Banner::all();

        $this->ret['info'] = ['banners'=>$banners];
        return $this->ret;
    }

    public function activities()
    {
        $activities = Activity::where('type',1)->get();

        $this->ret['info'] = ['list'=>$activities];
        return $this->ret;
    }

    public function goods(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');

        $offset = ($page-1)*$limit;
        $goods = Good::with(['category_tag'])->where(['is_hot'=>1,'status'=>Good::STATUS_ON_SALE])->orderBy('sort','asc')->skip($offset)->take($limit)->get();
        $this->ret['info'] = ['goods'=>$goods];
        return $this->ret;
    }

    /**
     * 获取分类页信息
     * @param $category_id
     * @param $tag_id
     * @return array
     */
    public function category($category_id,$brand_id)
    {
        $category = Category::find($category_id);
        $categorys = Category::all();


        $brands = Brand::where('category_id',$category_id)->get()->toArray();

        $brands_result = [];
        if(count($brands) > 0)
        {
            foreach ($brands as &$brand)
            {
                $good = Good::where('brand_id',$brand['id'])->where('category_id',$category_id)->where('status',Good::STATUS_ON_SALE)->first();
                if(!empty($good))
                {
                    $brands_result[] = $brand;
                }
            }

        }

        //print_r($brands_result);
        if(!empty($brand_id))
        {
            $where['brand_id'] = $brand_id;
        }
        $where['category_id'] = $category_id;
        $where['status'] = Good::STATUS_ON_SALE;

        $goods = Good::with(['brand'])->where($where)->orderBy('sort','asc')->get();
        $this->ret['info'] = ['category'=>$category,'categorys'=>$categorys,'brands'=>$brands_result,'goods'=>$goods];
        return $this->ret;
    }

    /**
     * 获取分类页商品列表分页
     * @param Request $request
     * @return array
     */
    public function category_goods(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $category_id = $request->get('category_id');
        $brand_id = $request->get('brand_id');

        $offset = ($page-1)*$limit;

        if(!empty($tag_id))
        {
            $where['brand_id'] = $brand_id;
        }
        $where['category_id'] = $category_id;
        $where['status'] = Good::STATUS_ON_SALE;

        $goods = Good::with(['brand'])->where($where)->skip($offset)->take($limit)->get();
        $this->ret['info'] = ['goods'=>$goods];
        return $this->ret;
    }

    public function get_telephone_code(Request $request)
    {
        $telephone = $request->get('telephone');
        if(!isMobile($telephone))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号有误'];
            return $this->ret;
        }

        $start_time = date('Y-m-d 00:00:00');
        $end_time = date('Y-m-d 23:59:59');

        $count = TelephoneCode::where('created_at','>=',$start_time)->where('created_at','<=',$end_time)->where('telephone',$telephone)->count();

        if($count>=config('app.day_sms_count'))
        {
            $this->ret = ['code'=>400,'msg'=>'今日获取验证码次数已达上限,请明日再试'];
            return $this->ret;
        }

        $user = User::where(['telephone'=>$telephone,'status'=>1])->first();
        if(!empty($user))
        {
            $this->ret = ['code'=>300,'msg'=>'手机号已被绑定'];
            return $this->ret;
        }

        $data['code'] = mt_rand(1000,9999);
        $data['telephone'] = $telephone;
        $data['is_used'] = 1;
        TelephoneCode::create($data);

        $this->send_sms($telephone,$data['code']);

        $this->ret['msg'] = '验证码发送成功';
        return $this->ret;
    }

    private function send_sms($telephone,$code)
    {
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                     'aliyun'
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => config('app.ali_sms_access_key_id'),
                    'access_key_secret' => config('app.ali_sms_access_key_secret'),
                    'sign_name' => '玩玩具趣编程',
                ],
            ],
        ];

        $easySms = new EasySms($config);

        $easySms->send($telephone, [
            'content'  => '您的验证码为: 6379',
            'template' => 'SMS_85380002',
            'data' => [
                'number' => $code
            ],
        ]);
    }

    public function bind_telephone(Request $request)
    {
        $telephone = $request->get('telephone');
        $code = $request->get('code');
        $wechat_openid = $request->get('wechat_openid');

        if(empty($telephone) || !isMobile($telephone))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的手机号有误'];
            return $this->ret;
        }

        $pattern = "/^[0-9]{4}$/";
        if(empty($code) || !preg_match($pattern,$code))
        {
            $this->ret = ['code'=>300,'msg'=>'输入的短信验证码有误'];
            return $this->ret;
        }

        $user = User::where(['telephone'=>$telephone,'status'=>1])->first();
        if(!empty($user))
        {
            $this->ret = ['code'=>300,'msg'=>'手机号已被绑定'];
            return $this->ret;
        }

        $telephone_code = TelephoneCode::where('telephone',$telephone)->limit(1)->orderBy('id','desc')->first();

        if($telephone_code->is_used == 1 && $telephone_code->code==$code)
        {
            TelephoneCode::where('id',$telephone_code->id)->update(['is_used'=>2]);

            $ret = User::where('wechat_openid',$wechat_openid)->update(['telephone'=>$telephone]);
            if($ret)
            {
                $this->ret['msg'] = '绑定手机号码成功';
                return $this->ret;
            }
        }

        $this->ret = ['code'=>300,'msg'=>'请输入正确的手机号或验证码'];
        return $this->ret;
    }

    public function get_area($fid = 0)
    {
        $areas = Area::where(['fid'=>$fid])->orderBy('first','asc')->get()->toArray();

        array_unshift($areas,['id'=>0,'name'=>'请选择']);

        if(!empty($areas))
        {
            foreach ($areas as &$v)
            {
                $v['value'] = $v['id'];
                $v['text'] = $v['name'];
            }
        }
        $this->ret['info'] = $areas;
        return $this->ret;
    }

    public function get_express_list()
    {
        $expresses = Express::all();
        $this->ret['info'] = $expresses;
        return $this->ret;
    }

    public function test()
    {
        $result = get_express_info('yunda','3805420027268');
        echo $result;
    }
}

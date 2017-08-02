<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CommonController extends BaseController
{
    /*public function upload(Request $request)
    {
        $file = $request->file('userfile');
        $filename = 'toys/'.md5(time().str_random(16)).'.'.$file->getClientOriginalExtension();

        $disk = Storage::drive('qiniu');
        $disk->writeStream($filename,fopen($file->getRealPath(),'r'));

        $img_url= 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;

        echo json_encode(array('success'=>1,'url'=>$img_url,'path'=>$img_url));
    }*/

    /**
     * 切割图片并且上传到七牛存储
     * @param Request $request
     */
    public function upload(Request $request,$size = '')
    {
        $file = $request->file('userfile');
        $disk = Storage::drive('qiniu');
        $filename_qiniu = 'toys/'.md5(time().str_random(16)).'.'.$file->getClientOriginalExtension();

        if(!empty($size))
        {
            $filename = 'storage/'.md5(time().str_random(16)).'.'.$file->getClientOriginalExtension();
            Image::make($file)->resize(320, 160)->save($filename);
            $disk->writeStream($filename_qiniu,fopen($filename,'r'));
        }
        else
        {
            $disk->writeStream($filename_qiniu,fopen($file->getRealPath(),'r'));
        }

        $img_url= 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename_qiniu;
        echo json_encode(array('success'=>1,'url'=>$img_url,'path'=>$img_url));
    }
}
